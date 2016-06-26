<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HomeController extends Controller
{
    public function index(Request $request)
    {
    	return view('home');
    }

	public function postIndex(Request $request) { return $this->index($request); }
	public function  getIndex(Request $request) { return $this->index($request); }

}
