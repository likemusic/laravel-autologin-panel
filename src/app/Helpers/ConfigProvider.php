<?php

namespace Likemusic\Laravel\AutologinPanel\Helpers;

use Illuminate\Contracts\Config\Repository as ConfigRepositoryInterface;

class ConfigProvider
{
    const CONFIG_KEY_MODEL_CLASS_NAME = 'model_class_name';
    const CONFIG_KEY_KEY = 'key';
    const CONFIG_KEY_VALUES = 'values';
    const CONFIG_KEY_NAME_TEMPLATE = 'name_template';
    const CONFIG_KEY_ID_NAME = 'id_name';

    const AUTOLOGIN_CONFIG_KEY = 'autologin';

    /**
     * @var ConfigRepositoryInterface
     */
    private $configRepository;

    public function __construct(ConfigRepositoryInterface $configRepository)
    {
        $this->configRepository = $configRepository;
    }

    public function getUserModelClassName()
    {
        return $this->getAutoLoginConfig(self::CONFIG_KEY_MODEL_CLASS_NAME);
    }

    public function getIdFieldName()
    {
        return $this->getAutoLoginConfig(self::CONFIG_KEY_ID_NAME);
    }

    private function getAutoLoginConfig($configKey)
    {
        $configPath = $this->getAutologinConfigPath($configKey);

        return $this->getConfig($configPath);
    }

    private function getAutologinConfigPath($configKey)
    {
        return self::AUTOLOGIN_CONFIG_KEY . '.' . $configKey;
    }

    private function getConfig(string $configPath)
    {
        return $this->configRepository->get($configPath);
    }

    public function getUserKey()
    {
        return $this->getAutoLoginConfig(self::CONFIG_KEY_KEY);
    }

    public function getUserKeyValues()
    {
        return $this->getAutoLoginConfig(self::CONFIG_KEY_VALUES);
    }

    public function getNameTemplate()
    {
        return $this->getAutoLoginConfig(self::CONFIG_KEY_NAME_TEMPLATE);
    }
}
