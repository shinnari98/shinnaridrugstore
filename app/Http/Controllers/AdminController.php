<?php

namespace App\Http\Controllers;

use App\Models\Likes;
use App\Models\Products;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function adminIndex(Request $request)
    {
        $products = Products::paginate(5);
        $recommends = Products::RecommendedProducts(5)->get();
        $famous = Products::FamousProducts();
        $user = Auth::user();
        $likes = Likes::UserLikes()->get();
        return view('drugstore.admin.adminIndex',compact('products','recommends','likes','famous'));
    }
}
