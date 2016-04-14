<?php

namespace App\Http\Controllers;

class PagesController extends Controller {

	public function getIndex() {
		return view('syncohome');
	}

	public function getLoggedIn() {
		return view('loggedin');
	}



}

