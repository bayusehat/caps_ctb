<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Home',
            'content' => 'dashboard'
        ];

        return view('layout.index',['data' => $data]);
    }
}
