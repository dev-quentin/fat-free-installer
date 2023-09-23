<?php

namespace FatFreeInstaller\Library;

use Base, Template;
use function Termwind\{ terminal, render, ask };

class Term
{
    public static function question(string $question)
    {
        Base::instance()->set('question', $question);
        return ask((Template::instance())->render('question.html'));
    }

    public static function error(?string $message = null)
    {
        Base::instance()->set('error', $message ?? Base::instance()->get('msg.error'));
        Term::render('error.html');
    }

    public static function clear()
    {
        terminal()->clear();
    }

    public static function success()
    {
        Term::render('success.html');
    }

    public static function msg(string $msg)
    {
        print render(sprintf("<template>%s<br></template>", strip_tags($msg)));
    }

    public static function render(string $template)
    {
        print render(sprintf("<template>%s<br></template>", (Template::instance())->render($template)));
    }
}