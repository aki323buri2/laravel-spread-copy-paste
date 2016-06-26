<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Catalog;

class CatalogController extends Controller
{
    protected $catalog;
    public function __construct()
    {
    	$this->catalog = new Catalog();
    }
    public function index(Request $request)
    {
    	return view('catalog/index', ['catalog' => $this->catalog]);
    }
    public function spread(Request $request)
    {
    	$cache = $request->session()->get('spread-cache');
    	$cache = json_decode($cache);
    	return view('catalog/spread', ['catalog' => $this->catalog, 'cache' => $cache]);
    }
    public function session(Request $request)
    {
    	$method = $request->method();
    	$name = $request->input('name');
    	if ($method === 'POST')
    	{
	    	$data = $request->input('data');
	    	$request->session()->put($name, json_encode($data));
	    }
	    else if ($method === 'GET')
	    {
	    	$data = $request->session()->get($name);
	    	return $data;
	    }
    }

    public function postIndex(Request $request) { return $this->index($request); }
    public function  getIndex(Request $request) { return $this->index($request); }
    public function postSpread(Request $request) { return $this->spread($request); }
    public function  getSpread(Request $request) { return $this->spread($request); }
    public function postSession(Request $request) { return $this->session($request); }
    public function  getSession(Request $request) { return $this->session($request); }

}
