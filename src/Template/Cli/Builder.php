<?php

namespace FatFreeInstaller\Template\Cli;

use FatFreeInstaller\Template\RootBuilder;

class Builder extends RootBuilder
{
    public function fetchTree(): array
    {
        return [
            // Public resources
            join(DIRECTORY_SEPARATOR, ["public"]),
            // Application
            join(DIRECTORY_SEPARATOR, ["App"]),
            join(DIRECTORY_SEPARATOR, ["App", "Config"]),
            join(DIRECTORY_SEPARATOR, ["App", "Controller"]),
            join(DIRECTORY_SEPARATOR, ["App", "Locales"]),
            join(DIRECTORY_SEPARATOR, ["App", "Logs"]),
            join(DIRECTORY_SEPARATOR, ["App", "temp"]),
        ];
    }

    public function fileList(): array
    {
        return [
            "Readme.md.exemple" => "",
            "script.php.exemple" => "",
            // Application
            "config.ini.exemple" => join(DIRECTORY_SEPARATOR, ["App", "Config"]),
            "routes.ini.exemple" => join(DIRECTORY_SEPARATOR, ["App", "Config"]),
            "BaseController.php.exemple" => join(DIRECTORY_SEPARATOR, ["App", "Controller"]),
            "en.ini.exemple" => join(DIRECTORY_SEPARATOR, ["App", "Locales"]),
        ];
    }
}