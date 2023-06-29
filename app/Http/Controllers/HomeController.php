<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public static string $categories;

    public function index(Request $request)
    {
        $products = Products::paginate(10);
        $recommends = Products::RecommendedProducts(5)->get();
        $likes = $request->session()->get('likes', []);        
        $famous = Products::FamousProducts();
        // dd($famous);        
        // $request->session()->forget('likes');
        $categories = Categories::all(); 
        return view('drugstore.index', compact('products','recommends','likes','famous'));
    }

    public function ajaxSearch()
    {
        // $keyword = $request->input('key');
        $data = Products::search()->get();

        return view('drugstore.item.ajaxSearch',compact('data'));
    }

}
