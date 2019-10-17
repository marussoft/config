<?php

declare(strict_types=1);

namespace Marussia\Config;

use Marussia\JsonFileLoader\JsonFileLoader;

class Config
{
    private $rootPath;

    private $configDir;

    private $configures = [];

    private const ENV_FILENAME = 'env';

    public function __construct(string $rootPath, string $configDir)
    {
        $this->rootPath = $rootPath;

        $this->configDir = $rootPath . '/' . $configDir;
    }

    public function getAll(string $configName) : array
    {
        if (array_key_exists($configName, $this->configures)) {
            return $this->configures[$configName];
        }

        $configPath = $this->configDir . '/' . str_replace('.', '/', $configName) . '.php';

        if (is_file($configPath)) {
            $this->configures[$configName] = include $configPath;
            return $this->configures[$configName];
        }
        return [];
    }

    public function get(string $configFile, string $configName)
    {
        $configArray = $this->getAll($configFile);

        if (array_key_exists($configName, $configArray)) {
            return $configArray[$configName];
        }
    }

    public function env(string $configName)
    {
        $configArray = JsonFileLoader::load($this->rootPath . '/.' . self::ENV_FILENAME . '.json');

        if (array_key_exists($configName, $configArray)) {
            return $configArray[$configName];
        }
    }
}
