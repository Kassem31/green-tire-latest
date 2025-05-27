<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SidebarController extends Controller
{
    public function getMenus()
    {
        $menus = Menu::with('children')->whereNull('parent_id')->orderBy('order')->get();

        $menus = $menus->filter(function($menu) {
            return $menu->isAccessibleBy(Auth::user());
        });

        $menus->each(function($menu) {
            $menu->children = $menu->children->filter(function($submenu) {
                return $submenu->isAccessibleBy(Auth::user());
            });
        });

        return view('layouts.sidebar', compact('menus'));
    }
}
