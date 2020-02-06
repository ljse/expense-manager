<?php

namespace App\Providers;

use App\Expense;
use App\Policies\ExpensePolicy;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        Expense::class => ExpensePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        $gate->define('isAdmin', function($user){
            if ($user->role != null) {
                return $user->role->role == 'Administrator';
            }
        });

        $gate->define('isUser', function($user){
            if ($user->role != null) {
                return $user->role->role == 'User';
            }
        });
    }
}
