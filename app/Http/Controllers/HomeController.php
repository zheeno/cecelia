<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;



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
        $allCategories = Category::orderBy("category_name", "ASC")->get();
        return view('index')->with("params", [
            "navBarCatList" => $allCategories
        ]);
    }
}
