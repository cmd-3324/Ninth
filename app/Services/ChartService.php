<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Car;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class ChartService
{
 public static function addToChart(int $userId, int $carId, int $bought_num, int $cvv, string $card_number, string $card_name, string $recive_loc, string $description, string $expiray_date): bool
{
    DB::beginTransaction();

    try {
        $car = DB::table('cars')->where('car_id', $carId)->first();

        if (!$car) {
            throw new \Exception("Car not found");
        }

        if ($car->available_as < $bought_num) {
            throw new \Exception("Not enough stock available");
        }

        $exists = DB::table('car_user')
            ->where('UserID', $userId)
            ->where('car_id', $carId)
            ->exists();

        if ($exists) {
            throw new \Exception("Car already in cart");
        }



        DB::table('cars')
            ->where('car_id', $carId)
            ->update([
                'available_as' => $car->available_as - ($bought_num -1),
                'sell_number' => $car->sell_number + ($bought_num -1)
            ]);


        DB::table('car_user')->insert([
            'UserID' => $userId,
            'car_id' => $carId,
            'bought_num' => $bought_num,
            'cvv' => $cvv,
            'card_number' => $card_number,
            'card_name' => $card_name,
            'recive_loc' => $recive_loc,
            'description' => $description,
            'expiry_date' => $expiray_date,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::commit();
        return true;

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Failed to add car to chart: ' . $e->getMessage());
        return false;
    }
}

    public static function addToFavorites(int $userId, int $carId): bool
    {
        try {
            $car = DB::table('cars')->where('car_id', $carId)->first();

            if (!$car) {
                return false;
            }

            $exists = DB::table('cars_favorites')
                ->where('UserID', $userId)
                ->where('car_id', $carId)
                ->exists();

            if ($exists) {
                return false;
            }

            $user = Auth::user();
            if ($user->Active != 1) {
                Log::error('Failed: User account is inactive', [
                    'UserID' => $userId,
                    'car_id' => $carId,
                ]);
                return false;
            } else {
                DB::table('cars_favorites')->insert([
                    'UserID' => $userId,
                    'car_id' => $carId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                self::updateCarFavoriteCount($carId);

                return true;
            }
        } catch (\Exception $e) {
            Log::error('Failed to add car to favorites', [
                'UserID' => $userId,
                'car_id' => $carId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public static function removeFromFavorites(int $userId, int $carId): bool
    {
        try {
            $car = DB::table('cars')->where('car_id', $carId)->first();

            if (!$car) {
                return false;
            }

            $exists = DB::table('cars_favorites')
                ->where('UserID', $userId)
                ->where('car_id', $carId)
                ->exists();

            if (!$exists) {
                return false;
            }

            DB::table('cars_favorites')
                ->where('UserID', $userId)
                ->where('car_id', $carId)
                ->delete();
            self::updateCarFavoriteCount($carId);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to remove car from favorites', [
                'UserID' => $userId,
                'car_id' => $carId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public static function updateCarFavoriteCount(int $carId): void
    {
        $favCount = DB::table('cars_favorites')
            ->where('car_id', $carId)
            ->count();

        DB::table('cars')
            ->where('car_id', $carId)
            ->update(['fav_num' => $favCount]);
    }

    public static function removeFromChart(int $userId, int $carId): bool
    {
        try {
            $car = DB::table('cars')->where('car_id', $carId)->first();

            if (!$car) {
                return false;
            }

            $exists = DB::table('car_user')
                ->where('UserID', $userId)
                ->where('car_id', $carId)
                ->exists();

            if (!$exists) {
                return false;
            }

            DB::table('car_user')
                ->where('UserID', $userId)
                ->where('car_id', $carId)
                ->delete();

            self::syncCarSalesData($carId);

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to remove car from chart', [
                'UserID' => $userId,
                'car_id' => $carId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public static function isInFavorites(int $userId, int $carId): bool
    {
        return DB::table('cars_favorites')
            ->where('UserID', $userId)
            ->where('car_id', $carId)
            ->exists();
    }

    public static function getUserFavorites(int $userId)
    {
        return DB::table('cars_favorites')
            ->join('cars', 'cars_favorites.car_id', '=', 'cars.car_id')
            ->where('cars_favorites.UserID', $userId)
            ->select('cars.*', 'cars_favorites.created_at as favorited_at')
            ->orderBy('cars_favorites.created_at', 'desc')
            ->get();
    }

    public static function clearUserFavorites(int $userId): bool
    {
        try {
            $carIds = DB::table('cars_favorites')
                ->where('UserID', $userId)
                ->pluck('car_id')
                ->unique()
                ->toArray();

            DB::table('cars_favorites')
                ->where('UserID', $userId)
                ->delete();

            foreach ($carIds as $carId) {
                self::updateCarFavoriteCount($carId);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to clear user favorites', [
                'UserID' => $userId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public static function syncFavoriteCounts(): void
    {
        $favoriteCounts = DB::table('cars_favorites')
            ->select('car_id', DB::raw('COUNT(*) as fav_count'))
            ->groupBy('car_id')
            ->get()
            ->keyBy('car_id');

        $cars = DB::table('cars')->get();

        foreach ($cars as $car) {
            $favCount = isset($favoriteCounts[$car->car_id]) ? $favoriteCounts[$car->car_id]->fav_count : 0;

            DB::table('cars')
                ->where('car_id', $car->car_id)
                ->update(['fav_num' => $favCount]);
        }
    }

    public static function getUserChart(int $userId)
    {
        return DB::table('car_user')
            ->join('cars', 'car_user.car_id', '=', 'cars.car_id')
            ->where('car_user.UserID', $userId)
            ->select('cars.*', 'car_user.created_at as added_at')
            ->orderBy('car_user.created_at', 'desc')
            ->get();
    }

    public static function clearUserChart(int $userId): bool
    {
        try {
            $carIds = DB::table('car_user')
                ->where('UserID', $userId)
                ->pluck('car_id')
                ->unique()
                ->toArray();

            DB::table('car_user')
                ->where('UserID', $userId)
                ->delete();

            foreach ($carIds as $carId) {
                self::syncCarSalesData($carId);
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Failed to clear user chart', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public static function isInChart(int $userId, int $carId): bool
    {
        return DB::table('car_user')
            ->where('UserID', $userId)
            ->where('car_id', $carId)
            ->exists();
    }

    public static function syncCarSalesData(int $carId = null): void
    {
        if ($carId) {
            $car = Car::find($carId);
            if (!$car) {
                return;
            }

            $pivotCount = DB::table('car_user')
                ->where('car_id', $carId)
                ->count();

            $totalStock = $car->sell_number + $car->available_as;
            $available = $totalStock - $pivotCount;

            if ($available < 0) {
                $available = 0;
            }

            DB::table('cars')
                ->where('car_id', $carId)
                ->update([
                    'sell_number' => $pivotCount,
                    'available_as' => $available
                ]);
        } else {
            $cars = DB::table('cars')->get();

            foreach ($cars as $car) {
                $pivotCount = DB::table('car_user')
                    ->where('car_id', $car->car_id)
                    ->count();

                $totalStock = $car->sell_number + $car->available_as;
                $available = $totalStock - $pivotCount;

                if ($available < 0) {
                    $available = 0;
                }

                DB::table('cars')
                    ->where('car_id', $car->car_id)
                    ->update([
                        'sell_number' => $pivotCount,
                        'available_as' => $available
                    ]);
            }
        }
    }
public static function like_reply(int $commentId, int $userId): bool
{
    try {
        $comment = Comment::find($commentId);

        if (!$comment) {
            return false;
        }

        $alreadyLiked = DB::table('comment_likes')
            ->where('comment_id', $commentId)
            ->where('user_id', $userId)
            ->exists();

        if ($alreadyLiked) {
            // Remove like
            DB::table('comment_likes')
                ->where('comment_id', $commentId)
                ->where('user_id', $userId)
                ->delete();

            if ($comment->likes > 0) {
                $comment->decrement('likes');
            }

            return false; // now unliked
        } else {
            // Add like
            DB::table('comment_likes')->insert([
                'comment_id' => $commentId,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $comment->increment('likes');

            return true; // now liked
        }
    } catch (\Exception $e) {
        Log::error('Failed to toggle like', [
            'comment_id' => $commentId,
            'user_id'   => $userId,
            'error'     => $e->getMessage(),
        ]);
        return false;
    }
}

public static function addComment(array $data): bool
{
    try {
        Comment::create([
            'message' => $data['message'],
            'name' => $data['name'],
            'email' => $data['email'],
            'car_id' => null,
            'parent_id' => $data['parent_id'] ?? null,
            'likes' => 0,
            'reply_num' => 0
        ]);

        return true;
    } catch (\Exception $e) {
        Log::error('Failed to add comment', [
            'data' => $data,
            'error' => $e->getMessage()
        ]);
        return false;
    }
}


    public static function likeComment(int $commentId): bool
    {
        try {
            $comment = Comment::find($commentId);
            if ($comment) {
                $comment->increment('likes');
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Failed to like comment', [
                'comment_id' => $commentId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public static function getAllComments(string $sortBy = 'none')
    {
        $query = Comment::with('replies')->whereNull('parent_id');

        switch ($sortBy) {
           case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'most_liked':
                $query->orderBy('likes', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->get();

    }
public static function reply(string $replier_name, string $replier_email, string $replier_context, int $replier_parentid): bool
{
    if (!Auth::check() || Auth::user()->Active != 1) {

        return false;
    }

    try {
        DB::table('comments')->insert([
            'message'    => $replier_context,
            'name'       => $replier_name,
            'email'      => $replier_email,
            'parent_id'  => $replier_parentid,
            'car_id'     => null,
            'likes'      => 0,
            'reply_num'  => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('comments')
            ->where('id', $replier_parentid)
            ->increment('reply_num', 1);

        return true;
    } catch (\Exception $e) {
        Log::error('Error inserting comment reply: ' . $e->getMessage());
        return false;
    }
}



    public static function getCommentsCount(): int
    {
        return Comment::count();
    }
}
