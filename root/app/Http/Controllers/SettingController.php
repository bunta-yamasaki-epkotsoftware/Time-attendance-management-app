<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Assuming you have a User model

class SettingController extends Controller
{
    public function index()
    {
        if(!Auth::check()) {
            return redirect()->route('login')->with('error', 'ログインしてください。');
        }

        $requests = User::where('id', Auth::id())->first();
        // 設定ページの表示
        return view('settings.index',compact('requests')); // settings/index.blade.phpを表示
    }
}
