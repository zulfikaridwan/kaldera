<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Book;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        Gate::define('read-book', function($user){
            return $user->role == 'penjual' || $user->role == 'pembeli';
        });

        Gate::define('create-book', function($user){
            if($user->role == 'penjual'){
                return true;
            }else{
                false;
            }
        });

        Gate::define('detail-book', function($user){
            return $user->role == 'penjual' || $user->role == 'pembeli';
        });

        Gate::define('update-book', function($user){
            if($user->role == 'penjual'){
                return true;
            }else{
                false;
            }
        });

        Gate::define('delete-book', function($user){
            if($user->role == 'penjual'){
                return true;
            }else{
                false;
            }
        });

        Gate::define('my-book', function($user){
            if($user->role == 'penjual'){
                return true;
            }else{
                false;
            }
        });

        //Authorization tabel categories
        Gate::define('read-categorie', function($user){
            return $user->role == 'penjual' || $user->role == 'pembeli';
        });

        Gate::define('create-categorie', function($user){
            if($user->role == 'penjual'){
                return true;
            }else{
                false;
            }
        });

        Gate::define('detail-categorie', function($user){
            return $user->role == 'penjual' || $user->role == 'pembeli';
        });

        Gate::define('update-categorie', function($user){
            if($user->role == 'penjual'){
                return true;
            }else{
                false;
            }
        });

        Gate::define('delete-categorie', function($user){
            if($user->role == 'penjual'){
                return true;
            }else{
                false;
            }
        });

        //Transactions Table
        Gate::define('create-transaction', function($user){
            if($user->role == 'pembeli'){
                return true;
            }else{
                false;
            }
        });

        Gate::define('detail-transaction', function($user){
            if($user->role == 'pembeli'){
                return true;
            }else{
                false;
            }
        });
        
        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->input('api_token')) {
                return User::where('api_token', $request->input('api_token'))->first();
            }
        });
    }
}
