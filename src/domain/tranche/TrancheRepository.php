<?php

namespace src\domain\tranche;

interface TrancheRepository
{
    /**
     * @param TrancheId $trancheId
     * @return Tranche
     */
    public function byId(TrancheId $trancheId);
}