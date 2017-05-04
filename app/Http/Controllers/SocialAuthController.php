<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\SocialAccountService;
use App\Http\Controllers\Controller;

class SocialAuthController extends Controller
{
	public function redirect()
	{
		return Socialite::driver('facebook')->fields([
			'first_name', 'last_name', 'email', 'gender', 'birthday'
			])->scopes([
			'email', 'user_birthday'
			])->redirect();   
		}   

		public function callback(SocialAccountService $service,Request $request)
		{
			$state = $request->get('state');
			$request->session()->put('state',$state);
			session()->regenerate();

			$user = $service->createOrGetUser(Socialite::driver('facebook')->fields([
				'first_name', 'last_name', 'email', 'gender', 'birthday','verified'
				])->user());
			
			auth()->login($user);
			
			return redirect()->to('/courses');
		}


	}

