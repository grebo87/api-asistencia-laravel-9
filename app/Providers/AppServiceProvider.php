<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('jsonPaginate', function(){
            $perPage = 15;
            $page = 1;

            if(request()->has('page')){
                $perPage = request('per_page');
                $page = request('page');
            }

            return $this->paginate(
                $perPage = $perPage,
                $columns = ['*'],
                $pageName = 'page',
                $page = $page
            );
        });
    }
}
