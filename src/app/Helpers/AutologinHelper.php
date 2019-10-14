<?php

namespace Likemusic\Laravel\AutologinPanel\Helpers;

use InvalidArgumentException;

class AutologinHelper
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(ConfigProvider $autoLoginConfig)
    {
        $this->configProvider = $autoLoginConfig;
    }

    public function getRouteByUser($user)
    {
        $idFieldName = $this->getUserIdFieldName();
        $userId = $user->{$idFieldName};

        return route('autologin', ['user_id' => $userId]);
    }

    private function getUserIdFieldName()
    {
        return $this->configProvider->getIdFieldName();
    }

    public function getUserCaption($user)
    {
        $nameTemplate = $this->getConfigNameTemplate();

        return $this->getEvaluatedTemplate($nameTemplate, $user);
    }

    private function getConfigNameTemplate()
    {
        return $this->configProvider->getNameTemplate();
    }

    private function getEvaluatedTemplate($template, $user)
    {
        $usedVariables = $this->getUsedVariables($template);
        $variablesValues = $this->getVariablesValues($usedVariables, $user);

        return $this->applyTemplateVariables($template, $variablesValues);
    }

    private function getUsedVariables($template)
    {
        $pattern = '/\{(?<vars>.*?)\}/';
        $matches = [];

        if (false == preg_match_all($pattern, $template, $matches)) {
            throw  new InvalidArgumentException("Invalid pattern ({$pattern}) or template ({$template})");
        }

        return array_unique($matches['vars']);
    }

    private function getVariablesValues($variables, $user)
    {
        $values = [];

        foreach ($variables as $variableName) {
            $values[$variableName] = $user->{$variableName};
        }

        return $values;
    }

    private function applyTemplateVariables($template, $variablesValues)
    {
        foreach ($variablesValues as $name => $value) {
            $template = $this->applyTemplateVariable($template, $name, $value);
        }

        return $template;
    }

    private function applyTemplateVariable($template, $name, $value)
    {
        $search = '{' . $name . '}';

        return str_replace($search, $value, $template);
    }
}
