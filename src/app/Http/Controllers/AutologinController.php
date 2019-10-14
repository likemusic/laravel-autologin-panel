<?php

namespace Likemusic\Laravel\AutologinPanel\Http\Controllers;

use Illuminate\Contracts\Auth\Factory as AuthFactoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Likemusic\Laravel\AutologinPanel\Helpers\ConfigProvider;
use Likemusic\Laravel\AutologinPanel\Helpers\UserHelper;
use Likemusic\Laravel\AutologinPanel\Helpers\UsersProvider;

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

    /**
     * @var
     */
    private $configProvider;

    public function __construct(
        AuthFactoryInterface $authFactory,
        UsersProvider $usersProvider,
        UserHelper $userHelper,
        ConfigProvider $configProvider
    )
    {
        $this->authFactory = $authFactory;
        $this->usersProvider = $usersProvider;
        $this->userHelper = $userHelper;
        $this->configProvider = $configProvider;
    }

    public function autologin(string $userId)
    {
        $user = $this->getUserByUserId($userId);

        if (!$this->isAvailableUser($user)) {
            throw new \InvalidArgumentException('Not available user id: ' . $userId);
        }

        return $this->authUserAndRedirectBack($user);
    }

    private function getUserByUserId($userId)
    {
        return $this->usersProvider->getUserByUserId($userId);
    }

    private function isAvailableUser($user)
    {
        $userKeyValue = $this->getUserKeyValue($user);
        $availableKeyValues = $this->getAvailableKeyValues();

        return in_array($userKeyValue, $availableKeyValues);
    }

    private function getUserKeyValue($user)
    {
        return $this->userHelper->getUserKeyValue($user);
    }

    private function getAvailableKeyValues()
    {
        return $this->configProvider->getUserKeyValues();
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

    public function setUsersProvider(UsersProvider $usersProvider): void
    {
        $this->usersProvider = $usersProvider;
    }

    private function getAvailableUsersKeyByKey(): Collection
    {
        return $this->usersProvider->getAvailableUsersKeyByKey();
    }
}
