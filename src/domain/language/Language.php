<?php

namespace src\domain\language;

abstract class Language
{
    private $language;

    private $languages =
        [
            'en',
            'ru'
        ]
    ;

    public function __construct($language)
    {
        if (!in_array($language, $this->languages)) {
            throw new \Exception('Language ' . $language . ' does not exist');
        }

        $this->language = $language;
    }

    public function value()
    {
        return $this->language;
    }
}