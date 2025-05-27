<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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
        // Use our custom pagination view
        Paginator::defaultView('vendor.pagination.custom');
        Paginator::defaultSimpleView('vendor.pagination.custom');
        
        View::composer('partials.sidebar', function ($view) {
            $menus = Menu::with('children')->whereNull('parent_id')->orderBy('order')->get();

            $menus = $menus->filter(function($menu) {
                return $menu->isAccessibleBy(Auth::user());
            });

            $menus->each(function($menu) {
                $menu->children = $menu->children->filter(function($submenu) {
                    return $submenu->isAccessibleBy(Auth::user());
                });
            });

            $view->with('menus', $menus);
        });
        
        Blade::directive('permission', function ($expression) {
            return "<?php if (Auth::check() && (Auth::user()->is_super_admin || app('laratrust')->hasPermission({$expression}))) : ?>";
        });
    }
}
