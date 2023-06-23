<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\View;
use App\Models\Contacts;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    /* protected $user;
    protected $test;

    public function __construct(Request $request)
    {
        $this->user = $request->session()->get('user');
        if ($request->session()->has('user')) {
            $this->test = true;
        } else {
            $this->test = false;
        }

        View::share('user',$this->user);
        View::share('test',$this->test);
    } */

    public function contact(Request $request)
    {
        $request->session()->forget('status');
        $user = Auth::user();
        return view('drugstore.user.contact.index',compact('user'));
    }

    public function confirm(ContactRequest $request) 
    {
        $data = $request->validated();
        $user = Auth::user();

        if($request->input('previous') == 'backContact') {
            return redirect()->route('contact.index')->withInput()->withErrors([]);
        }

        return view('drugstore.user.contact.confirm',compact('user'));
    }

    public function complete(ContactRequest $request)
    {
        $request->session()->put('status', true);
        $contact = new Contacts();
        $contact->name = $request->name;
        $contact->phone = $request->phone;
        $contact->email = $request->email;
        $contact->content = $request->content;

        $user = Auth::user();
        if (Auth::user()) {
            $contact->user_id = $user->id;
            $contact->permission_id = $user->permission_id;
        }
        $contact->save();

        return view('drugstore.user.contact.complete',compact('user','test'));
    }

    public function index()
    {
        $contacts = Contacts::where('type_of','contact')->paginate(10);
        return view('drugstore.admin.contact.allContact',compact('contacts'));
    }

    public function show($id)
    {
        $contact = Contacts::where('id',$id)->first();
        return view('drugstore.admin.contact.oneContact',compact('contact'));
    }

    public function Adminfeedback(Request $request)
    {
        $contact = $request->all();
        $user = Auth::user();
        return view('drugstore.admin.contact.feedback',compact('contact','user'));
    }

    public function Sendfeedback(Request $request)
    {
        // dd($request->content);
        $contacted = Contacts::where('id',$request->send_to)->first();
        $contacted->have_fb = true;
        $contacted->save();
        
        Contacts::create([
            'send_to' => $request->send_to,
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
            'type_of' => $request->type_of,
            'permission_id' => $request->permission_id,
        ]);

        $text = 'フィードバックしました。';

        return redirect()->route('contact.index')->with('success', $text);
    }
}
