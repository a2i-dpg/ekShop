<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WebsiteController extends Controller
{
	public function header(Request $request)
	{
		return view('admin.website_settings.header');
	}
	public function footer(Request $request)
	{
		$lang = $request->lang;
		return view('admin.website_settings.footer', compact('lang'));
	}
	public function pages(Request $request)
	{
		return view('admin.website_settings.pages.index');
	}
	public function appearance(Request $request)
	{
		return view('admin.website_settings.appearance');
	}
}
