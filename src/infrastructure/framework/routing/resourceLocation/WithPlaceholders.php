<?php

namespace src\infrastructure\framework\routing\resourceLocation;

use src\infrastructure\framework\routing\ResourceLocation;
use src\useCases\Request;

class WithPlaceholders implements ResourceLocation
{
    private $placeholder;

    public function __construct($placeholder)
    {
        $this->placeholder = $placeholder;
    }

    public function matches(Request $request)
    {
        return
            preg_match(
                '@' . preg_replace('@\:[^\/]+@', '[^\/]+', $this->placeholder) . '@',
                $request->uri()->value()
            )
                ===
            1;
    }
}