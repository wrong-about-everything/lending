<?php

namespace src\infrastructure\framework\http\response\header;

use src\infrastructure\framework\http\response\Header;

class XmlContentType implements Header
{
    public function value()
    {
        return 'Content-Type: text/xml;charset=UTF-8';
    }
}
