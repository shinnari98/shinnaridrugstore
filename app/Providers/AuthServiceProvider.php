<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function ($user) {
            return $user->permission_id == 1;
        });

        Gate::define('isProducer', function ($user) {
            return $user->permission_id == 2 || $user->permission_id == 1;
        });

        Gate::define('isUser', function ($user) {
            return $user->permission_id == 3;
        });

        Gate::define('userHistory',function ($user,$order) {
            return $user->id == $order->user_id && $order->deli_status !='配達完了';
        });

        Gate::define('producerOrder',function($user,$order) {
            return $user->id == $order->product->producer_id;
        });

        Gate::define('producerOrderEdit',function($user,$order) {
            return $user->id == $order->product->producer_id && $order->del_flg == 0 ;
        });

        Gate::define('producerProduct',function($user,$product) {
            return $user->id == $product->producer_id;
        });
    }
}
