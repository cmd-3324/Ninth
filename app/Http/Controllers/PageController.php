<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Car;
use App\Models\CarUserPivot;
use Illuminate\Http\Request;
use App\Models\CarUser;
use App\Services\ChartService;
use App\Models\FavoriteCarPivot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Comment;

class PageController extends Controller
{
    public function show_all_cars()
    {
        $cars = Car::where('available_as', '>', 0)
                ->withCount('carBuyers as total_buyers')
                ->sort()
                ->paginate(5);

        $sortByComment = request()->input('comment_sort', 'none');
        $commentsCount = Comment::count();

        $replyCount = Comment::where("parent_id", "!=", null)->count();
        $commentsTopLevel = Comment::where("parent_id", "=",null)->count();
        $comments = Comment::whereNull('parent_id')->with('replies')
            ->sort_comment('created_at', 'desc', 'comment_sort')
            ->get();

        return view('CarPage', compact('cars', 'commentsCount', 'comments', 'sortByComment','replyCount','commentsTopLevel'));
    }

    public function reply(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
            'comment_id' => 'required|integer|exists:comments,id',
        ]);

        if (ChartService::reply(
            $validated['name'],
            $validated['email'],
            $validated['message'],
            $validated['comment_id']
        )) {
            return redirect()->back()->with('success', 'Reply posted successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to post reply. Please try again.');
        }
    }

    public function searchCarPage(Request $request)
    {
        $searchTerm = $request->input("searchTerm");

        $query = Car::where('available_as', '>', 0)
                   ->withCount('carBuyers as total_buyers');

        if (!empty($searchTerm)) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('discription', 'like', '%' . $searchTerm . '%');
            });
        }

        $cars = $query->orderBy('name', 'asc')->paginate(5);

        $sortByComment = request()->input('comment_sort', 'none');
        $commentsCount = Comment::count();

        $commentsTopLevel = Comment::where("parent_id", "=",null)->count();
        $comments = Comment::whereNull('parent_id')
            ->sort_comment('created_at', 'desc', 'comment_sort')
            ->get();
          $replyCount = Comment::where("parent_id", "!=", null)->count();

        return view('CarPage', compact('cars', 'searchTerm', 'commentsCount', 'comments', 'sortByComment','commentsTopLevel','sortByComment','replyCount'));
    }

    public function gotoProfile(Request $request)
    {
        $user_id = Auth::user()->UserID;
        $sortByFav = request()->input('sort2', 'none');
        $activeSection = request()->input('active_section', 'cars');

        $car_ids = FavoriteCarPivot::where('UserID', $user_id)->pluck('car_id');
        $favcars = Car::whereIn('car_id', $car_ids)->sort('name', 'asc', 'sort2')->get();

        $user = CarUser::with(['cars' => function($query) {
            $query->sort();
        }])->find($user_id);

        if (!$user) {
            abort(404, 'User not found');
        }

        $totalCarCount = $user->cars()->count();
        $foundCarCount = $user->cars->count();
        $sortBy = request()->input('sort', 'none');

        return view('UserPannel', compact('user', 'totalCarCount', 'foundCarCount', 'sortBy', 'sortByFav', 'favcars', 'activeSection'));
    }

    public function deleteaccount(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'deletePassword' => 'required|string',
        ]);

        if (Hash::check($request->deletePassword, $user->password)) {
            DB::table("carsusers")->where("UserID", $user->UserID)->delete();
            return redirect('/home')->with('success', 'Your account has been deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Incorrect password. Account deletion failed.');
        }
    }

    public function changeAccount(Request $request)
    {
        $user_id = Auth::user()->UserID;

        $validated = $request->validate([
            'username' => ['required', 'string'],
            'email' => ['required', 'email'],
            'phone_number' => ['required', 'numeric'],
        ]);

        DB::table('carsusers')->where('UserID', $user_id)->update([
            'UserName' => $validated['username'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
        ]);

        return redirect()->back()->with('success', 'Account changed successfully');
    }

    public function showPurchaseForm($carId)
    {
        $car = Car::findOrFail($carId);

        // Check if car is available
        if ($car->available_as <= 0) {
            return redirect()->route('all-cars')->with('error', 'This car is currently out of stock');
        }

        return view('ShowPurchaseForm', compact('car'));
    }

    public function addToChart(Request $request)
    {
        if (!Auth()->check()) {
            // Save only the car_id for after login
            $request->session()->put('chart_car_id', $request->car_id);
            return redirect()->route('login');
        }

        $request->validate(['car_id' => 'required|exists:cars,car_id']);
        $carId = $request->car_id;
        $userId = Auth::id();

        $car = Car::find($carId);
        if (!$car) {
            return redirect()->back()->with("error", "Car not found");
        }

        if ($car->available_as <= 0) {
            return redirect()->back()->with("error", "This car is currently out of stock");
        }

        $existingCartItem = CarUserPivot::where('UserID', $userId)
                                        ->where('car_id', $carId)
                                        ->first();

        if ($existingCartItem) {
            return redirect()->back()->with("error", "You've already added this car to your cart");
        }

        if (Auth::user()->Active != 1) {
            return redirect()->back()->with("error", "Your account is not active anymore");
        }

        return redirect()->route('purchase.form', ['carId' => $carId]);
    }

    public function processPurchase(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,car_id',
            'quantity' => 'required|integer|min:1',
            'receive_location' => 'required|string',
            'description' => 'nullable|string|max:170',
            'card_name' => 'required|string',
            'card_number' => 'required|string',
            'expiry_date' => 'required|date',
            'cvv' => 'required|string|min:3|max:4'
        ]);

        try {
            $carId = $request->car_id;
            $userId = Auth::user()->UserID;
            $bought_num = $request->quantity;
            $cvv = $request->cvv;
            $card_number = $request->card_number;
            $card_name = $request->card_name;
            $recive_loc = $request->receive_location;
            $description = $request->description;
            $expiray_date = $request->expiry_date;

            $car = Car::findOrFail($carId);
            if ($car->available_as < $bought_num) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['quantity' => "Only {$car->available_as} units available"]);
            }

            ChartService::addToChart($userId, $carId, $bought_num, $cvv, $card_number, $card_name, $recive_loc, $description, $expiray_date);

            return redirect()->route('all-cars')->with("success", "Car added to cart successfully!");

        } catch (\Exception $e) {
            return redirect()->back()->with("error", "Purchase failed: " . $e->getMessage());
        }
    }

    public function emergencyFixCarCounts()
    {
        ChartService::syncCarSalesData();
        ChartService::syncFavoriteCounts();

        return "All car counts have been synced successfully!";
    }

    public function removeFromChart(Request $request)
    {
        $request->validate(['car_id' => 'required|exists:cars,car_id']);
        $carId = $request->car_id;
        $user_id = Auth::user()->UserID;

        if (ChartService::removeFromChart($user_id, $carId)) {
            return redirect()->back()->with('success', 'Car removed from chart!');
        } else {
            return redirect()->back()->with('error', 'Failed to remove car from chart.');
        }
    }

    public function clearChart()
    {
        if (ChartService::clearUserChart(Auth::id())) {
            return redirect()->back()->with('success', 'Chart cleared!');
        }

        return redirect()->back()->with('error', 'Failed to clear chart.');
    }

    public function change_password(Request $request)
    {
        $user_id = Auth::user()->UserID;

        $current_password_request = $request->input("current_password");
        $new_password = $request->input("new_password");
        $new_password_confirmation = $request->input("new_password_confirmation");

        $user = DB::table("carsusers")->where("UserID", $user_id)->first();

        if (!Hash::check($current_password_request, $user->password)) {
            return redirect("/profile/{$user_id}")->with("error", "Current Password Does not match");
        }

        if ($new_password !== $new_password_confirmation) {
            return redirect("/profile/{$user_id}")->with("error", "New Password Does not match");
        }

        DB::table("carsusers")->where("UserID", $user_id)->update([
            'password' => Hash::make($new_password)
        ]);

        return redirect()->back()->with("success", "Changed Password");
    }

    public function Contact()
    {
        return view("Contact");
    }

    public function GetAboutPage() {
        return view("aboutus");
    }

    public function deleteCar(Request $request)
    {
        $carId = $request->input('car_id');
        $user = Auth::user();

        if (ChartService::removeFromChart($user->UserID, $carId)) {
            return redirect()->back()->with('success', 'Car removed!');
        }

        return redirect()->back()->with('error', 'Failed to remove car.');
    }

    protected function getUserFavoriteCars($user_id, $sortByFav = 'none')
    {
        $car_ids = FavoriteCarPivot::where('UserID', $user_id)->pluck('car_id');

        $favcarsQuery = Car::whereIn('car_id', $car_ids);

        if ($sortByFav !== 'none') {
            $favcarsQuery->orderBy($sortByFav, 'asc');
        }

        return $favcarsQuery->get();
    }

    public function search(Request $request)
    {
        $user_id = Auth::user()->UserID;
        $sortBy = $request->input('sort', 'none');
        $searchTerm = $request->input('search');
        $sortByFav = $request->input('sort2', 'none');
        $activeSection = $request->input('active_section', 'cars');

        $user = Auth::user();

        // Get favorite cars with sorting
        $car_ids = FavoriteCarPivot::where('UserID', $user_id)->pluck('car_id');
        $favcars = Car::whereIn('car_id', $car_ids)->sort('name', 'asc', 'sort2')->get();

        $totalCarCount = $user->cars()->count();

        $user->load(['cars' => function($query) use ($searchTerm) {
            if (!empty($searchTerm)) {
                $query->where(function($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', "%{$searchTerm}%");
                });
            }
            $query->sort();
        }]);

        $foundCarCount = $user->cars->count();

        return view('UserPannel', compact(
            'user',
            'totalCarCount',
            'foundCarCount',
            'sortBy',
            'searchTerm',
            'favcars',
            'sortByFav',
            'activeSection'
        ));
    }

    public function deleteAll()
    {
        $user = Auth::user();

        // Use ChartService instead of manual DB operations
        if (ChartService::clearUserChart($user->UserID)) {
            return redirect()->back()->with("success", "All cars deleted successfully!");
        }

        return redirect()->back()->with("error", "Failed to delete all cars!");
    }

    public function addToFavorites(Request $request)
    {
        $user_id = Auth::user()->UserID;
        $request->validate(['car_id' => 'required|exists:cars,car_id']);
        $carId = $request->car_id;
        $checkExist = FavoriteCarPivot::where('car_id',"=", $carId)
                ->where('UserID', $user_id)
                ->first();
        if (ChartService::addToFavorites(Auth::id(), $carId)) {
            return redirect()->back()->with('success', 'Car added to favorites!');
        }elseif($checkExist){
            return redirect()->back()->with("error", "You've already added this to your Favorites!");
        }else {
            if (Auth::user()->Active != 1) {
                return redirect()->back()->with("error", "Your account is inactive");
            }
            return redirect()->back()->with('error', 'Failed to add car to favorites.');
        }
    }

    public function removeFromFavorites(Request $request)
    {
        $request->validate(['car_id' => 'required|exists:cars,car_id']);
        $carId = $request->car_id;

        if (ChartService::removeFromFavorites(Auth::id(), $carId)) {
            return redirect()->back()->with('success', 'Car removed from favorites!');
        }

        return redirect()->back()->with('error', 'Failed to remove car from favorites.');
    }

    public function addComment(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
        ]);

        try {
            $data = $request->only(['message', 'name', 'email', 'parent_id']);

            if (ChartService::addComment($data)) {
                return redirect()->back()->with('success', 'Comment added successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to add comment.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to add comment: ' . $e->getMessage());
        }
    }

    public function likeComment(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id'
        ]);

        $user = Auth::user();
        $commentId = $request->comment_id;

        if (!$user) {
            return redirect()->back()->with('error', 'You must be logged in to like comments');
        }

        try {
            $alreadyLiked = DB::table('comment_likes')
                ->where('comment_id', $commentId)
                ->where('user_id', $user->UserID)
                ->exists();

            if ($alreadyLiked) {
                // Unlike: Remove the like and decrease count
                DB::table('comment_likes')
                    ->where('comment_id', $commentId)
                    ->where('user_id', $user->UserID)
                    ->delete();

                DB::table('comments')
                    ->where('id', $commentId)
                    ->decrement('likes');

                return redirect()->back()->with('success', 'Comment unliked!');
            } else {
                // Like: Add the like and increase count
                DB::table('comment_likes')->insert([
                    'comment_id' => $commentId,
                    'user_id' => $user->UserID,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                DB::table('comments')
                    ->where('id', $commentId)
                    ->increment('likes');

                return redirect()->back()->with('success', 'Comment liked!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to like comment.');
        }
    }

    public function like_reply(Request $request)
    {
        $request->validate([
            'comment_id' => 'required|exists:comments,id',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', 'You must be logged in to like/unlike');
        }

        $commentId = $request->comment_id;

        try {
            $alreadyLiked = DB::table('comment_likes')
                ->where('comment_id', $commentId)
                ->where('user_id', $user->UserID)
                ->exists();

            if ($alreadyLiked) {
                // Unlike: Remove the like and decrease count
                DB::table('comment_likes')
                    ->where('comment_id', $commentId)
                    ->where('user_id', $user->UserID)
                    ->delete();

                DB::table('comments')
                    ->where('id', $commentId)
                    ->decrement('likes');

                return redirect()->back()->with('success', 'You unliked this!');
            } else {
                // Like: Add the like and increase count
                DB::table('comment_likes')->insert([
                    'comment_id' => $commentId,
                    'user_id' => $user->UserID,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                DB::table('comments')
                    ->where('id', $commentId)
                    ->increment('likes');

                return redirect()->back()->with('success', 'You liked this!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to like/unlike.');
        }
    }
}
