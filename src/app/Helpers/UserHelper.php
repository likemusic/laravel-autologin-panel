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

    public function getUserId($user)
    {
        $userIdFieldName = $this->getUserIdFieldName();

        return $user->{$userIdFieldName};
    }

    private function getUserIdFieldName()
    {
        return $this->configProvider->getIdFieldName();
    }
}
