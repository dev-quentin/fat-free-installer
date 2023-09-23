<?php

namespace FatFreeInstaller\Foundation;

class Command
{
    private static array $commands = [];

    private static array $help = [];

    public function __construct()
    {
        if (!isset($_SERVER['argv'][1])) {
            ++$_SERVER['argc'];
            $_SERVER['argv'][1] = 'help';
        }
        var_dump($_SERVER['argv']);
    }

    public static function add(string $command, $callback, string $desc = "")
    {
        static::$commands[$command] = $callback;
        static::$help[$command] = $desc;
    }

    public function run()
    {
        var_dump(static::$commands);
    }

    public function help()
    {
        
    }
}