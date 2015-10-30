<?php

namespace Conticket\OAuthBundle\Providers;

use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthUserProvider as BaseOAuthUserProvider;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Conticket\ApiBundle\Document\User;

class OAuthUserProvider extends BaseOAuthUserProvider
{
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        exit('um');
    }
    
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $a = parent::loadUserByOAuthUserResponse($response);
        var_dump($a);
        exit('dois');
    }
}
