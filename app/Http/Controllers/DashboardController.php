<?php
namespace App\Http\Controllers;
use App\Models\ACL\User as User;
use Auth;

class DashboardController extends Controller {
	public function __construct()
	{
	    $this->middleware('auth');
	}

	protected $layout = 'main';
	
	public function index(){
		return view('content.dashboard');
	}
}
