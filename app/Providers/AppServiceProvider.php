<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\SystemInfo;
use App\Models\IncomeCategory;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\MembershipPlan;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $system = SystemInfo::first();
            $view->with('system', $system);
        });

            // Check if income_categories table exists
            if (Schema::hasTable('income_category')) {
                if (!IncomeCategory::where('name', 'Membership Revenue')->exists()) {
                    IncomeCategory::create(['name' => 'Membership Revenue']);
                }
            }

            // Check if users table exists
            if (Schema::hasTable('users')) {
                if (User::count() === 0) {
                    User::create([
                        'name' => 'admin',
                        'email' => 'middlephort@gmail.com',
                        'password' => Hash::make('11111111'),
                        'position' => 'Admin',
                    ]);
                }
            }

            if (Schema::hasTable('membership_plans')) {
                if (MembershipPlan::count() === 0) {
                    MembershipPlan::create([
                        'name' => 'Standard',
                        'cost' => '5000'
                    ]);
                }
            }
            

    }
}
