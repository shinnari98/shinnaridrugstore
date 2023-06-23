<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $products = Products::paginate(10);
        $recommends = Products::orderBy('sold','desc')->orderBy('star','desc')->limit(5)->get();
        $likes = $request->session()->get('likes', []);        
        $famous = Products::where('star', '>=', 4)->orderBy('sold', 'desc')->take(10)->get('id')->pluck('id')->toArray();
        // $request->session()->forget('likes');
        return view('drugstore.index', compact('products','recommends','likes','famous'));
    }

    public function ajaxSearch()
    {
        // $keyword = $request->input('key');
        $data = Products::search()->get();

        return view('drugstore.item.ajaxSearch',compact('data'));
    }

}
