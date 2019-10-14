<?php


namespace Likemusic\Laravel\AutologinPanel\Helpers;

class UserHelper
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    public function getUserKeyValue($user)
    {
        $userKeyFieldName = $this->getUserKeyFieldName();

        return $user->{$userKeyFieldName};
    }

    private function getUserKeyFieldName()
    {
        return $this->configProvider->getUserKey();
    }
}
