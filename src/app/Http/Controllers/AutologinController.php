<?php

namespace Likemusic\Laravel\AutologinPanel\Http\Controllers;

use Illuminate\Contracts\Auth\Factory as AuthFactoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Likemusic\Laravel\AutologinPanel\Helpers\UsersProvider;
use Likemusic\Laravel\AutologinPanel\Helpers\UserHelper;

class AutologinController
{
    private $authFactory;

    /**
     * @var UsersProvider
     */
    private $usersProvider;

    /**
     * @var UserHelper
     */
    private $userHelper;

    public function __construct(
        AuthFactoryInterface $authFactory,
        UsersProvider $usersProvider,
        UserHelper $userHelper)
    {
        $this->authFactory = $authFactory;
        $this->usersProvider = $usersProvider;
        $this->userHelper = $userHelper;
    }

    public function autologin(string $userId)
    {
        $user = $this->getUserByUserId($userId);

        if (!$this->isAvailableUser($user)) {
            throw new \InvalidArgumentException('Not available user id: '. $userId);
        }

        return $this->authUserAndRedirectBack($user);
    }

    private function isAvailableUser($user)
    {
        $availableUsers = $this->getAvailableUsers();
        $userId = $this->getUserId($user);

        return $availableUsers->contains($userId);
    }

    private function getUserId($user)
    {
        return $this->userHelper->getUserId($user);
    }

    private function getAvailableUsers(): Collection
    {
        return $this->usersProvider->getAvailableUsers();
    }

    public function setUsersProvider(UsersProvider $usersProvider): void
    {
        $this->usersProvider = $usersProvider;
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
