<?php

namespace FatFreeInstaller\Library;

use FatFreeInstaller\Template\Api\Builder as ApiBuilder;
use FatFreeInstaller\Template\Webapp\Builder as WebappBuilder;
use FatFreeInstaller\Template\Cli\Builder as CliBuilder;

use Base, Template;

class Installer
{
    protected Base $base;

    public function __construct(Base $base)
    {
        $this->base = $base;
    }

    public function help()
    {
        Term::render('help.html');
    }

    public function error()
    {
        Term::clear();
        Term::error();
        $this->base->reroute('/');
    }

    public function api(string $projectName): ApiBuilder
    {
        Term::clear();
        return new ApiBuilder("./{$projectName}");
    }

    public function app(string $projectName): WebappBuilder
    {
        Term::clear();
        return new WebappBuilder("./{$projectName}");
    }

    public function cli(string $projectName): CliBuilder
    {
        Term::clear();
        return new CliBuilder("./{$projectName}");
    }
}