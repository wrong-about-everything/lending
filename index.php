<?php

require_once 'autoload.php';
require_once 'vendor/autoload.php';
require_once 'errorHandler.php';

use \src\useCases\investInTranche\InvestInTranche;
use src\infrastructure\application\loan\InMemoryLoanRepository;
use src\infrastructure\application\tranche\InMemoryTrancheRepository;
use src\infrastructure\application\investor\InMemoryInvestorRepository;
use \src\useCases\investInTranche\request\FromJson;
use \src\useCases\investInTranche\request\ToXml;

(new WebFront(
    new Fallback(
        new RouteChain(
            [
                new \src\infrastructure\framework\routing\Route(
                    new WithPlaceholders('/investors/:id/invest'),
                    new Post(),
                    new ToXml(
                        new FromJson(
                            new InvestInTranche(
                                new InMemoryLoanRepository(),
                                new InMemoryTrancheRepository(),
                                new InMemoryInvestorRepository(),
                                new DateTime('now')
                            )
                        )
                    )
                ),
            ],
            new UrlNotFoundResponse()
        ),
        json_encode(['code' => 'exception', 'System failure. Come back later.'])
    )
))
    ->respond();


try {
    (new WebFront(
        new Fallback(
            new RouteChain(
                [
                    new Route(
                        new Posted(
                            new Jsoned(
                                new Fixed('/payments')
                            )
                        ),
                        new RegisterPaymentApplicationFromJsonCoordinator(
                            new RegisterPaymentApplicationCoordinator(
                                new PostgresUserDataStorage(PspProdConnection::me())
                            )
                        )
                    ),
                ]
            ),
            new UrlNotFoundResponse()
        )
    ))
        ->act(
            new HttpRequest(
                new HttpMethod($_SERVER['REQUEST_METHOD']),
                new URL("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"),
                getallheaders(),
                new Data($_POST)
            )
        )
    ;
} catch (Exception $e) {
    var_dump($e->getMessage());
    var_dump($e->getTraceAsString());
    echo json_encode(['code' => 'exception', 'System failure. Come back later.']);
}
