<?php

namespace Src;

use Error;

class Settings
{
    private array $_settings;
    private static array $uris = [];

    public function __construct(array $settings = [])
    {
        $this->_settings= $settings;
    }

    public function __get($key)
    {
        if (array_key_exists($key, $this->_settings)) {
            return $this->_settings[$key];
        }
        throw new Error('Property does not exist');
    }

    public function getRootPath(): string
    {
        return $this->path['root'] ? '/' . $this->path['root'] : '';
    }

    public function getViewsPath(): string
    {
        return '/' . $this->path['views'] ?? '';
    }

    public function getDbSetting(): array {
        return $this->db ?? [];
    }

    public static function addUri($uri)
    {
        array_push(Settings::$uris, $uri);
    }

    public static function getUris()
    {
        return Settings::$uris;
    }
}