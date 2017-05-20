<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\SocialAccountService;
use App\Http\Controllers\Controller;

class SocialAuthController extends Controller
{
	public function redirect($provider)
	{
		if($provider == 'google'){
			return Socialite::driver('google')->redirect();
		}
		return Socialite::driver($provider)->fields([
			'first_name', 'last_name', 'email', 'gender', 'birthday'
			])->scopes([
			'email', 'user_birthday'
			])->redirect();   
		}   

		public function callback(SocialAccountService $service,Request $request,$provider)
		{
			$state = $request->get('state');
			$request->session()->put('state',$state);
			session()->regenerate();
			if (class_basename($provider) == 'google'){
				$user = $service->createOrGetUser(Socialite::driver($provider));
			}else{
			$user = $service->createOrGetUser(Socialite::driver($provider)->fields([
				'first_name', 'last_name', 'email', 'gender', 'birthday','verified'
				]));
			
			
			}
			auth()->login($user);
			return redirect()->to('/courses');
		}

		public function gredirect()
		{
			return Socialite::driver('google')->redirect();   
		}   

		public function gcallback(SocialAccountService $service,Request $request)
		{
			 $state = $request->get('state');
			 $request->session()->put('state',$state);
			session()->regenerate();

			// $user = $service->createOrGetUser(Socialite::driver('facebook')->fields([
			// 	'first_name', 'last_name', 'email', 'gender', 'birthday','verified'
			// 	])->user());
			
			// auth()->login($user);
			$user = $service->createOrGetUser(Socialite::driver('google')->user());
			auth()->login($user);
			//dd($user);
			return redirect()->to('/courses');
		}


	}

