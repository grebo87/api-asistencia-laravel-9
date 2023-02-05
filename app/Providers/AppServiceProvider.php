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
                $perPage = request('page.size');
                $page = request('page.number');
            }

            return $this->paginate(
                $perPage = $perPage,
                $columns = ['*'],
                $pageName = 'page[number]',
                $page = $page
            )->appends(request()->except('page.number'));
        });
    }
}
