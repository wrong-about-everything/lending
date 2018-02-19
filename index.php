<?php

require_once 'autoload.php';

use \src\useCases\investInTranche\InvestInTranche;
use src\infrastructure\domain\loan\InMemoryLoanRepository;
use src\infrastructure\domain\tranche\InMemoryTrancheRepository;
use src\infrastructure\domain\investor\InMemoryInvestorRepository;
use src\infrastructure\controllers\investInTranche\request\FromJson;
use src\infrastructure\controllers\investInTranche\response\xml\InvestedSuccessfully;
use \src\infrastructure\framework\routing\Route;
use \src\infrastructure\framework\front\WebFront;
use \src\infrastructure\framework\http\request\HttpMethod;
use \src\infrastructure\framework\http\request\HttpRequestStub;
use \src\infrastructure\framework\http\request\Uri;
use \src\infrastructure\framework\routing\resourceLocation\WithPlaceholders;
use \src\domain\tranche\DefaultTranche;
use \src\domain\tranche\TrancheId;
use \src\domain\loan\LoanId;
use \src\domain\money\currency\Pound;
use \src\domain\money\format\InMinorUnits;
use \src\domain\percentage\format\DefaultPercent;
use \src\infrastructure\framework\http\request\ReceivedHttpRequest;
use \src\domain\loan\DefaultLoan;
use \src\domain\loan\LoanInterval;
use \src\domain\investor\DefaultInvestor;
use \src\domain\investor\InvestorId;
use \src\infrastructure\framework\routing\RouteChain;
use \src\infrastructure\framework\fallback\Fallback;
use \src\infrastructure\framework\fallback\SystemFailure;
use src\infrastructure\framework\WithHeaders;
use \src\domain\language\En;
use \src\infrastructure\framework\http\response\header\ContentLanguage;
use \src\infrastructure\framework\http\response\header\DateHeader;

$trancheRepository = new InMemoryTrancheRepository();
$trancheRepository->add(
    new DefaultTranche(
        new TrancheId(1), new LoanId(1), new InMinorUnits(0, new Pound()), new InMinorUnits(1000000, new Pound()), new DefaultPercent(7)
    )
);

$loanRepository = new InMemoryLoanRepository();
$loanRepository->add(
    new DefaultLoan(
        new LoanId(1), new LoanInterval(new DateTime('2018-02-01'), new DateTime('2018-02-28'))
    )
);

$investorRepository = new InMemoryInvestorRepository();
$investorRepository->add(
    new DefaultInvestor(
        new InvestorId(1), new InMinorUnits(1000, new Pound())
    )
);

try {
    (new WithHeaders(
        new Fallback(
            new RouteChain(
                [
                    new Route(
                        new WithPlaceholders('/investors/:id/invest'),
                        new HttpMethod($_SERVER['REQUEST_METHOD']),
                        new FromJson(
                            new InvestInTranche(
                                $loanRepository,
                                $trancheRepository,
                                $investorRepository,
                                new DateTime('now')
                            ),
                            function (array $data) {
                                return new InvestedSuccessfully($data);
                            }
                        )
                    )
                ]
            ),
            new SystemFailure()
        ),
        [new ContentLanguage([new En()]), new DateHeader(new DateTime('now'))]
    ))
        ->act(
            new ReceivedHttpRequest()
        )
            ->display()
    ;
} catch (Exception $e) {
    var_dump($e->getMessage());
    var_dump($e->getTraceAsString());
}

//(new WebFront(
//    new WithDateHeader(
//        new Fallback(
//            new RouteChain(
//                [
//                    new Route(
//                        new WithPlaceholders('/investors/:id/invest'),
//                        new Post(),
//                        new FromJson(
//                            new InvestInTranche(
//                                new InMemoryLoanRepository(),
//                                new InMemoryTrancheRepository(),
//                                new InMemoryInvestorRepository(),
//                                new DateTime('now')
//                            ),
//                            function (array $data) {
//                                return new ToXml($data);
//                            }
//                        )
//                    ),
//                ],
//                new UrlNotFoundResponse()
//            ),
//            json_encode(['code' => 'exception', 'System failure. Come back later.'])
//        ),
//        new DateTime('now')
//    )
//))
//    ->respond();
