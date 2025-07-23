<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // 設定ページの表示
        return view('settings.index'); // settings/index.blade.phpを表示
    }
}
