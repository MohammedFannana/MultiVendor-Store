<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Illuminate\Support\Facades\Config;
use App\Actions\Fortify\AuthenticateUser;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // in this way 
        $request = request();
        // if request start with admin use guard admin not web  in auth.php
        if ($request->is('admin/*')) {
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.passwords', 'admins');
            Config::set('fortify.prefix', 'admin');
            Config::set('fortify.home', 'admin/dashboard');
        }

        // Config::set('fortify.home', 'admin/dashboard');
        // ====

        // $this->app->instance(LoginResponse::class, new class implements LoginResponse{
        //     public function toResponse($request){
        //         if($request->user('admin')){
        //             return redirect()->intended('admin/dashboard');
        //         }

        //         return redirect()->intended('/');
        //     }
        // });

        //The Same way form logout use LogoutResponse and register RegisterResponse
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {


        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        // 



        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email . $request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // Fortify::viewPrefix('auth.');

        //if need diffrent view from admin and user

        if (Config::get('fortify.guard') == 'admin') {
            // use to login use email or username or phone_number
            // and build class in app/Action/fortify for this task
            //authenticate is method in  AuthenticateUser class
            //beacuse the function not static need to pass object from AuthenticateUser class
            Fortify::authenticateUsing([new AuthenticateUser, 'authenticate']);
            ///////
            Fortify::viewPrefix('auth.');
        } else {
            Fortify::viewPrefix('front.auth.');
        }
    }
}
