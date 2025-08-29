<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 替換原本 product_list.php、hot.php 等查詢邏輯
        $hotProducts = DB::table('products') -> where('is_hot', 1) -> get();
        $products    = DB::table('products') -> paginate(20);

        return view('home', [
            'hotProducts' => $hotProducts,
            'products'    => $products,
        ]);
    }
}
