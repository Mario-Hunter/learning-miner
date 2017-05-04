<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;
use Carbon;
class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {

            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {

                if ($providerUser->user['verified'] == true){
                    $confirmed =1;
                }else{
                    $confirmed =0;
                }

                $user =User::create( [
                    'email' => $providerUser->getEmail(),
                    'first_name' => $providerUser->user['first_name'],
                    'last_name' => $providerUser->user['last_name'],
                    'avatar'=> $providerUser->getAvatar(),
                    'dob' => Carbon\Carbon::parse($providerUser->user['birthday']),
                    'confirmed' => $confirmed,
                    'gender' =>$providerUser->user['gender'],
                   
                    
                ]);
            }
            $account->user()->associate($user);
            $account->save();

            return $user;

        }

    }
}