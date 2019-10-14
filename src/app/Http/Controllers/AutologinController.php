<?php

namespace Likemusic\Laravel\AutologinPanel\Http\Controllers;

use Illuminate\Contracts\Auth\Factory as AuthFactoryInterface;
use Likemusic\Laravel\AutologinPanel\Helpers\UsersProvider;

class AutologinController
{
    private $authFactory;

    /**
     * @var UsersProvider
     */
    private $usersProvider;

    public function __construct(AuthFactoryInterface $authFactory, UsersProvider $usersProvider)
    {
        $this->authFactory = $authFactory;
        $this->usersProvider = $usersProvider;
    }

    public function autologin(string $userId)
    {
        $user = $this->getUserByUserId($userId);

        return $this->authUserAndRedirectBack($user);
    }

    private function getUserByUserId($userId)
    {
        return $this->usersProvider->getUserByUserId($userId);
    }

    private function authUserAndRedirectBack($user)
    {
        $this->authUser($user);

        return $this->redirectBack();
    }

    private function authUser($user)
    {
        $this->authFactory->login($user);
    }

    private function redirectBack()
    {
        return redirect()->back();
    }
}
