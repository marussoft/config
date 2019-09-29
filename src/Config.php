<?php

declare(strict_types=1);

namespace Marussia\Config;

use Marussia\JsonFileLoader\JsonFileLoader;
use Marussia\Config\Exceptions\DirPathIsAlreadyInstalledException;

class Config
{
    private static $rootPath;

    private static $configDir;

    private static $configures = [];

    private static $isReady = false;

    public static function setConfigDir(string $rootPath, string $configDir)
    {
        if (static::$isReady) {
            throw new DirPathIsAlreadyInstalledException();
        }

        static::$rootPath = $rootPath;

        static::$configDir = $rootPath . '/' . $configDir;

        static::$isReady = true;
    }

    public static function getAll(string $configName) : array
    {
        if (array_key_exists($configName, static::$configures)) {
            return static::$configures[$configName];
        }

        $configPath = static::$configDir . '/' . str_replace('.', '/', $configName) . '.php';

        if (is_file($configPath)) {
            static::$configures[$configName] = include $configPath;
            return static::$configures[$configName];
        }
        return [];
    }

    public static function get(string $configFile, string $configName)
    {
        $configArray = static::getAll($configFile);

        if (array_key_exists($configName, $configArray)) {
            return $configArray[$configName];
        }
    }

    public static function env(string $configName)
    {
        $configArray = static::getAll($configFile);

        if (array_key_exists($configName, $configArray)) {
            return $configArray[$configName];
        }
    }

    public static function env(string $configName)
    {
        $configArray = JsonFileLoader::load(static::$rootPath . '/.env.json');

        if (array_key_exists($configName, $configArray)) {
            return $configArray[$configName];
        }
    }

    public static function isReady() : bool
    {
        return static::$isReady;
    }
}
