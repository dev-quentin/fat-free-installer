<?php

namespace FatFreeInstaller;

use Base;
final class Kernel
{
    private Application $app;

    private Base $base;

    public function __construct(Application $app, Base $base)
    {
        $this->app = $app;
        $this->base = $base;
    }

    public function boot()
    {
        $this->base->config($this->app->path('Config/routes.ini'));
        $this->base->config($this->app->path('Config/config.ini'));

        $this->base->run();
    }
}