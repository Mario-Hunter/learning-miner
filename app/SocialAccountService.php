<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;
use Laravel\Socialite\Contracts\Provider;
use Carbon;
class SocialAccountService
{
    public function createOrGetUser(Provider $provider)
    {
        $providerUser = $provider->user();
        $providerName = class_basename($provider);

        $account = SocialAccount::whereProvider($providerName)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $providerName
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                

                $user =User::create( $this->getData($providerName,$providerUser));
            }
            $account->user()->associate($user);
            $account->save();

            return $user;

        }

    }

    public function getData($provider,$providerUser){
        if($provider == 'facebook'){
            if ($providerUser->user['verified'] == true){
                    $confirmed =1;
                }else{
                    $confirmed =0;
                }
            $data = [
                    'email' => $providerUser->getEmail(),
                    'first_name' => $providerUser->user['first_name'],
                    'last_name' => $providerUser->user['last_name'],
                    'avatar'=> $providerUser->getAvatar(),
                    'dob' => Carbon\Carbon::parse($providerUser->user['birthday']),
                    'confirmed' => $confirmed,
                    'gender' =>$providerUser->user['gender'],
                    
                ];
        }
        if($provider == 'GoogleProvider'){
            if ($providerUser->user['verified'] == true){
                    $confirmed =1;
                }else{
                    $confirmed =0;
                }
            $data =[
                    'email' => $providerUser->getEmail(),
                    'first_name' => $providerUser->user['name']['givenName'],
                    'last_name' => $providerUser->user['name']['familyName'],
                    'avatar'=> $providerUser->getAvatar(),
                    'confirmed' => 1,
                    'gender' =>null,
                    
                ];
        }
        return $data;
    }
}