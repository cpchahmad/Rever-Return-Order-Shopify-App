<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{

    public function logout(){


        Auth::logout();
        return redirect('/admin');
    }


    public function index(){


        $user=User::where('is_admin','0')->get();
        return view('admin.index',compact('user'));

    }
}
