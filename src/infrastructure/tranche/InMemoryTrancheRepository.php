<?php

namespace src\infrastructure\tranche;

use src\domain\tranche\NonExistentTranche;
use src\domain\tranche\Tranche;
use src\domain\tranche\TrancheId;
use src\domain\tranche\TrancheRepository;

class InMemoryTrancheRepository implements TrancheRepository
{
    private $tranches;

    public function __construct()
    {
        $this->tranches = [];
    }

    public function add(Tranche $tranche)
    {
        $this->tranches[$tranche->id()->id()] = $tranche;
    }

    public function byId(TrancheId $trancheId)
    {
        if (!isset($this->tranches[$trancheId->id()])) {
            return new NonExistentTranche();
        }

        return $this->tranches[$trancheId->id()];
    }
}
