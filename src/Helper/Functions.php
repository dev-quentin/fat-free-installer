<?php

namespace FatFreeInstaller\Helper;

use FatFreeInstaller\Application;
function app()
{
    return Application::getInstance();
}

function requireFile(string $path)
{
    return require_once app()->path($path);
}