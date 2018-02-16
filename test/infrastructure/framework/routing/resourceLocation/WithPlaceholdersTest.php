<?php

namespace test\infrastructure\framework\routing\resourceLocation;

use PHPUnit\Framework\TestCase;
use src\infrastructure\framework\http\request\HttpMethod;
use src\infrastructure\framework\http\request\HttpRequestStub;
use src\infrastructure\framework\http\request\Uri;
use src\infrastructure\framework\routing\resourceLocation\WithPlaceholders;

class WithPlaceholdersTest extends TestCase
{
    /**
     * @dataProvider urlDataProvider
     */
    public function testSuccessfullParsing($searchPattern, $url)
    {
        $withPlaceholders = new WithPlaceholders($searchPattern);

        $this->assertTrue(
            $withPlaceholders
                ->matches(
                    new HttpRequestStub(
                        new HttpMethod('POST'),
                        new Uri($url),
                        ['header: value'],
                        ''
                    )
                )
        );
    }

    public function urlDataProvider()
    {
        return
            [
                ['/investors/:id/invest', 'http://localhost/investors/1/invest'],
                ['/investors/:i/invest', 'http://localhost/investors/1/invest'],
                ['/investors/:idddd/invest', 'http://localhost/investors/1/invest'],
                ['/investors/:id/invest', 'http://localhost/investors/123456789/invest'],
                ['/investors/:id/loans/:loan_id', 'http://localhost/investors/123456789/loans/564'],
            ];
    }
}