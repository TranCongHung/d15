<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // Phải trả về view khớp với đường dẫn: views/admin/index.blade.php
        return view('admin.index'); 
    }
}
