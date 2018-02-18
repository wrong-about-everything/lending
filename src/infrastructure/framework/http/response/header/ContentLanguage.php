<?php

namespace src\infrastructure\framework\http\response\header;

use src\domain\language\Language;
use src\infrastructure\framework\http\response\Header;

class ContentLanguage implements Header
{
    /**
     * @var Language[]
     */
    private $languages;

    public function __construct(array $languages)
    {
        $this->languages = $languages;
    }

    public function value()
    {
        return
            'Content-Language: ' .
            implode(
                ', ',
                array_map(
                    function (Language $language) {
                        return $language->value();
                    },
                    $this->languages
                )
            );
    }
}