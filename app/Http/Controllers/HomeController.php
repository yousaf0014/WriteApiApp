<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }


    public function userList(Request $request){
        $userObj = new User;        
        $keyword = '';
        if(isset($request->keyword)){
            $keyword = $request->keyword;
            $userObj = $userObj->where('email','like', '%'.$keyword.'%');
        }        
        $users = $userObj->where('id','<>',1)->withTrashed()->paginate(20);
        return view('Home.index',compact('users','keyword'));
    }

    public function lock(User $user){
        $user->deleted_at = date('Y-m-d H:i:s');
        $user->save();
        return back();
    }

    public function restoreuser(Request $request){
        $userObj = User::where('id',$request->id)->withTrashed()->first();
        $userObj->restore();
        return back();
    }
}
