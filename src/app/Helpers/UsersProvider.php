<?php

namespace Likemusic\Laravel\AutologinPanel\Helpers;

use Illuminate\Contracts\Container\Container as ContainerInterface;
use Illuminate\Database\Eloquent\Collection;

class UsersProvider
{
    const CONFIG_KEY = 'autologin';

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(
        ConfigProvider $configProvider,
        ContainerInterface $container
    )
    {
        $this->configProvider = $configProvider;
        $this->container = $container;
    }

    public function getUserByUserId($userId)
    {
        $userModelClassName = $this->getModelClassName();
        $model = $this->createInstanceByClassName($userModelClassName);
        $idFieldName = $this->getIdFieldName();

        return $model->where($idFieldName, $userId)->first();
    }

    private function getModelClassName()
    {
        return $this->configProvider->getUserModelClassName();
    }

    private function createInstanceByClassName(string $className)
    {
        return $this->container->make($className);
    }

    private function getIdFieldName()
    {
        return $this->configProvider->getIdFieldName();
    }

    public function getUsers(): array
    {
        $userModelClassName = $this->getModelClassName();
        $userKey = $this->getUserKey();
        $userKeyValues = $this->getUserKeyValues();

        $users = $this->getUsersByModel($userModelClassName, $userKey, $userKeyValues);

        return $this->orderUsersByKeyValues($users, $userKey, $userKeyValues);
    }

    private function getUserKey()
    {
        return $this->configProvider->getUserKey();
    }

    private function getUserKeyValues()
    {
        return $this->configProvider->getUserKeyValues();
    }

    private function getUsersByModel($userModelClassName, $userKey, $userKeyValues)
    {
        $model = $this->createInstanceByClassName($userModelClassName);

        return $model->whereIn($userKey, $userKeyValues)->get();
    }

    private function orderUsersByKeyValues(Collection $users, $userKey, $userKeyValues)
    {
        $users = $users->keyBy($userKey);

        $ret = [];

        foreach ($userKeyValues as $userKeyValue) {
            $ret[] = $users->get($userKeyValue);
        }

        return $ret;
    }
}
