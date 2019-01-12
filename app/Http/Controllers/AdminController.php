<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
        if (!Auth::user()->canAdmin()){
            return redirect('home')->withErrors(['error'=>'You don\'t have permission to perform this operation.']);
        }
        $logs = Log::all();
        return view('admin.index',compact('logs'));
    }

}
