<?php

namespace Lucid\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Lucid\Core\Follow;
use Lucid\Core\Document;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        //URL::forceScheme('https');
        $isLocal = App::environment('local') ? true : false;
        View::share('isLocal', $isLocal);
        if($isLocal){
        }
        else{
          $this->app['request']->server->set('HTTPS', true);

        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(Follow::class, function($app,$username){
          return new Follow($username);
        });
        $this->app->singleton(Document::class, function($app,$username){
          return new Document($username);
        });
    }
}
