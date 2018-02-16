<?php

namespace src\infrastructure\framework\routing;

use src\useCases\Request;

interface ResourceLocation
{
    public function matches(Request $request);
}