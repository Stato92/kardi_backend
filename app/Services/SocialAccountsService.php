<?php
namespace App\Services;
use App\User;
use App\LinkedSocialAccount;
use Laravel\Socialite\Two\User as ProviderUser;
class SocialAccountsService
{
    /**
     * Find or create user instance by provider user instance and provider name.
     *
     * @param ProviderUser $providerUser
     * @param string $provider
     *
     * @return User
     */
    public function findOrCreate(ProviderUser $providerUser, string $provider): User
    {
        $linkedSocialAccount = LinkedSocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();
        if ($linkedSocialAccount) {
            return $linkedSocialAccount->user;
        } else {
            $user = null;
            if ($email = $providerUser->getEmail()) {
                $user = User::where('email', $email)->first();
            }
            if (! $user) {
                if (isset($providerUser->user['given_name']) && isset($providerUser->user['family_name'])) {
                    $name = $providerUser->user['given_name'];
                    $surname = $providerUser->user['family_name'];
                }
                    else {
                    $name = explode(" ",$providerUser->getName())[0];
                    $surname = explode(" ",$providerUser->getName())[1];
                };
                $user = User::create([
                    'name' => $name,
                    'surname' => $surname,
                    'email' => $providerUser->getEmail(),
                ]);
            }
            $user->linkedSocialAccounts()->create([
                'provider_id' => $providerUser->getId(),
                'provider_name' => $provider,
            ]);
            return $user;
        }
    }
}
