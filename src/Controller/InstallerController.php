<?php

namespace FatFreeInstaller\Controller;

use FatFreeInstaller\Library\{ Installer, Term };
use Base, Template;

class InstallerController
{

    public function beforeRoute(Base $base)
    {
        $base->set('installer', new Installer($base));
    }

    public function error(Base $base)
    {
        $base->get('installer')->error();
    }

    public function help(Base $base)
    {
        $base->get('installer')->help();
    }

    public function api(Base $base, array $args)
    {
        $base->get('installer')->api(basename($args['projectName']))->builProject();
        Term::success();
    }

    public function app(Base $base, array $args)
    {
        $base->get('installer')->app(basename($args['projectName']))->builProject();
        Term::success();
    }

    public function cli(Base $base, array $args)
    {
        $base->get('installer')->cli(basename($args['projectName']))->builProject();
        Term::success();
    }
}