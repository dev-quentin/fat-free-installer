<?php

namespace FatFreeInstaller;

use Base;
use FatFreeInstaller\Foundation\Container;

final class Application extends Container
{
    private string $basePath;

    private static ?Application $instance = null;

    private function __construct()
    {
        $this->instance(Application::class, $this);
        $this->instance(Container::class, $this);
        $this->instance(Base::class, Base::instance());

        $this->realPath = BASE_PATH;
        $this->basePath = "..";
    }

    public function path(string $path)
    {
        return join(DIRECTORY_SEPARATOR, [$this->realPath, 'src', $path]);
    }

    public function relativePath(string $path)
    {
        return join(DIRECTORY_SEPARATOR, [$this->basePath, 'src', $path]);
    }

    public function basePath()
    {
        return join(DIRECTORY_SEPARATOR, [$this->basePath, 'src']);
    }

    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new Application();
        }
        return static::$instance;
    }
}
