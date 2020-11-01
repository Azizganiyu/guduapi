<?php

namespace App\Http\Controllers;

use App\Models\Artisan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function getAnalytics(){
        $users = User::count();
        $artisans = Artisan::limit(4)->get();
        $products = Product::orderBy('id', 'desc')->with('user')->first();
        return response()->json([
            'users' => $users,
            'artisans' => $artisans,
            'products' => $products,
        ], 200);
    }
}
