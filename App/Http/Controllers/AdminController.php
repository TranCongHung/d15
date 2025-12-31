<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\User;
use App\Models\Category;
use App\Models\Comment;

class AdminController extends Controller
{

public function index()
{
    // Lấy dữ liệu cho admin views
    $articles = Article::with('author')->latest()->get();
    $users = User::all();

    return view('admin.index', compact('articles', 'users'));
}
}