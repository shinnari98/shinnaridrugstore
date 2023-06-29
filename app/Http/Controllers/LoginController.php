<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Likes;
use App\Models\Products;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        //  $this->middleware('auth')->except(['index', 'logIndex', 'RegisIndex', 'login', 'register']);
    }

    public function logIndex()
    {
        return view('drugstore.login');
    }

    public function RegisIndex()
    {
        return view('drugstore.register');
    }


    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (Auth::attempt($data)) {
            $user = User::where('email', $data['email'])->first();
            $request->session()->put('user', $user);

            return redirect()->route('homepage');
        } else {
            return redirect()->back();
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        User::create([
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return view('drugstore.registerComplete');
    }

    // public function registerComplete() {
    //     return view('drugstore.registerComplete');
    // }

    public function homepage(Request $request)
    {
        $products = Products::paginate(10);
        $recommends = Products::RecommendedProducts(5)->get();
        $famous = Products::FamousProducts();
        $user = Auth::user();
        $permission_id = $user->permission_id;

        if (session()->has('likes')) {
            $sess_likes = $request->session()->get('likes');
            
            foreach ($sess_likes as $key => $value) {
                $like = Likes::where('user_id', $user->id)
                    ->where('product_id', $key)
                    ->first();
                if (!$like) {
                    Likes::create([
                        'user_id' => $user->id,
                        'product_id' => $key,
                        'like' => true
                    ]);
                }
            }
            
        }
        $likes = Likes::UserLikes()->get();
        $request->session()->forget('likes');

        if ($permission_id == 1) {
            return redirect()->route('admin.index', compact('products', 'recommends', 'likes','famous'));
        } elseif ($permission_id == 2) {
            return view('drugstore.homepage', compact('user', 'products', 'recommends', 'likes','famous'));
        } else {
            return view('drugstore.homepage', compact('user', 'products', 'recommends', 'likes','famous'));
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->forget('cart');
        $request->session()->forget('card');
        $request->session()->forget('likes');
        $request->session()->forget('status');
        $request->session()->forget('status_payment');
        $request->session()->forget('status_orderFail');

        Auth::logout();
        return redirect()->route('index');
    }
}
