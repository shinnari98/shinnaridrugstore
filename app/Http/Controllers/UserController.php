<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\adminToUserRequest;
use App\Http\Requests\updateProfileRequest;
use App\Models\Products;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereNot('permission_id',1)->get();
        $products = Products::all();
        return view('drugstore.admin.user.allUser', compact('users', 'products'));
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('drugstore.admin.user.creatUser');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        // dd($request);
        $data = $request->validated();
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('img/user_img'), $filename);
            $data['avatar'] = $filename;
        }

        User::create([
            'name' => $data['name'],
            'nickname' => $data['nickname'],
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'],
            'address' => $data['address'] ?? null,
            'password' => Hash::make($data['password']),
            'avatar' => $data['avatar'] ?? null
        ]);
        $text = 'User created successfully';

        return redirect()->route('user.index')->with('success', $text);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        return view('drugstore.admin.user.oneUser', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('drugstore.admin.user.editUser',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(adminToUserRequest $request, User $user)
    {
        // $user = Auth::user();
        $data = $request->validated();

        $user->name = $request->input('name');
        $user->nickname = $request->input('nickname');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        if ($user->permission_id != $request->input('permission')) {
            $user->permission_id = $request->input('permission');
        }
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('img/user_img'), $filename);
            $user->avatar = $filename;
        }
        $user->save();
        $text = 'User id'.$user->id.' updated successfully';
        return redirect()->route('user.show',['user' => $user->id])->with('success', $text);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $text = 'User id'.$id.' deleted successfully' ;
        $user->delete();
        return redirect()->route('user.index')->with('success', $text);
    }


    /* ------------for user-------------- */
    public function showMyProfile(Request $request)
    {
        // dd($request->user());
        $user = $request->session()->get('user');
        return view('drugstore.user.profile.show', compact('user'));
    }

    public function editMyProfile(Request $request)
    {
        $user = $request->session()->get('user');
        return view('drugstore.user.profile.edit', compact('user'));
    }

    public function updateMyProfile(updateProfileRequest $request/* , User $user */)
    {
        $data = $request->validated();
        // dd($request);
        $user = session()->get('user');
        if ($user->nickname != $request->input('nickname')) {
            $user->nickname = $request->input('nickname');
        }
        if ($user->email != $request->input('email')) {
            $user->email = $request->input('email');
        }

        if ($request->input('newPassword') != null) {
           $user->password = Hash::make($request->input('newPassword')); 
        }

        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->address = $request->input('address');
        

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('img/user_img'), $filename);
            $user->avatar = $filename;
        }
        $user->save();

        $text = 'updated successfully';
        if ( Auth::user()->permission_id == 3) {
            return redirect()->route('user.showUser')->with('success', $text);
        } else {
            return redirect()->route('producer.showUser')->with('success', $text);
        }
    }
}
