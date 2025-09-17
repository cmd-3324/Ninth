<?php

namespace App\Providers;
use App\Models\Car;
use App\Models\Caruse;
use App\Models\CarUser;
use App\Models\CarUserPivot;
use Illuminate\Support\Facades\View;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {

        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
        $data = $view->getData();

        foreach ($data as $key => $value) {
            if (is_numeric($value)) {
                $view->with($key, number_format($value));
            }
        }
    });

        Builder::macro("deleteall", function () {
            $user_id = Auth::user()->UserID;
            return $this->where("UserID", $user_id)->delete();
    });
    Builder::macro("sort_comment", function ($defaultColumn = "created_at", $defaultDirection = "asc", $sortParamName = "comment_sort") {
   $sortParam = request()->input($sortParamName, 'comment_sort');
   $sortColumn  = $defaultColumn;
   $sortDirection = $defaultDirection;
      if (!$sortParam !== 'none') {
        switch ($sortParam) {
            case 'newest':
                $sortColumn = 'created_at';
                $sortDirection = 'desc';
                break;
            case 'oldest':
                $sortColumn = 'created_at';
                $sortDirection = 'asc';
                break;
            case 'most_liked':
                $sortColumn = 'likes';
                $sortDirection = 'desc';
                break;
            case 'most_replied':
                $sortColumn = 'reply_num';
                $sortDirection = 'desc';
                break;
            default:
                $sortParam = "none";
                $sortColumn = "created_at";
                $sortDirection = "desc";
    }}
     return $this->orderBy($sortColumn, $sortDirection);
});

Builder::macro('sort', function ($defaultColumn = 'name', $defaultDirection = 'asc', $sortParamName = 'sort') {
    $sortParam = request()->input($sortParamName, 'none');
    $sortColumn = $defaultColumn;
    $sortDirection = $defaultDirection;

    if ($sortParam !== 'none') {
        switch ($sortParam) {
            case 'price_asc':
                $sortColumn = 'price';
                $sortDirection = 'asc';
                break;
            case 'price_desc':
                $sortColumn = 'price';
                $sortDirection = 'desc';
                break;
            case 'name_asc':
                $sortColumn = 'name';
                $sortDirection = 'asc';
                break;
            case 'name_desc':
                $sortColumn = 'name';
                $sortDirection = 'desc';
                break;
    }}

    return $this->orderBy($sortColumn, $sortDirection);
});
    }
}
