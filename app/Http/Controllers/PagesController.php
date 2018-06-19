<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
	public function index(){
		$title = 'Kebap Guide';
		return view('pages.index')->with('title', $title);
	}

	public function  about(){
		$title = 'About';
		return view('pages.about')->with('title', $title);
	}

	public function  services(){
		$data = array(
			'title' => 'Services',
			'services' => ['Finding Close Kebap-Kiosks', 'Assess Kiosks', 'Creating A Profil Of Your Own Kiosk']
		);
		return view('pages.services')->with($data);
	}
}
