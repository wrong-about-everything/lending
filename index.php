<?php

require_once 'autoload.php';
require_once 'vendor/autoload.php';
require_once 'errorHandler.php';

use \src\useCases\investInTranche\InvestInTranche;
use src\infrastructure\domain\loan\InMemoryLoanRepository;
use src\infrastructure\domain\tranche\InMemoryTrancheRepository;
use src\infrastructure\domain\investor\InMemoryInvestorRepository;
use src\infrastructure\controllers\investInTranche\request\FromJson;
use src\infrastructure\controllers\investInTranche\response\ToXml;
use \src\infrastructure\framework\routing\Route;

(new WebFront(
    new WithDateHeader(
        new Fallback(
            new RouteChain(
                [
                    new Route(
                        new WithPlaceholders('/investors/:id/invest'),
                        new Post(),
                        new FromJson(
                            new InvestInTranche(
                                new InMemoryLoanRepository(),
                                new InMemoryTrancheRepository(),
                                new InMemoryInvestorRepository(),
                                new DateTime('now')
                            ),
                            function (array $data) {
                                return new ToXml($data);
                            }
                        )
                    ),
                ],
                new UrlNotFoundResponse()
            ),
            json_encode(['code' => 'exception', 'System failure. Come back later.'])
        ),
        new DateTime('now')
    )
))
    ->respond();
