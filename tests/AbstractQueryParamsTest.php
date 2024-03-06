<?php

namespace Nullform\AppStoreServerApiClient\Tests;

use Nullform\AppStoreServerApiClient\AbstractQueryParams;

class AbstractQueryParamsTest extends AbstractTestCase
{
    public function testToQueryString()
    {
        $instance = new class extends AbstractQueryParams {

            public $stringParam = 'value';

            public $numArray = ['first', 'second'];

            public $assocArray = [
                'one' => 'value1',
                'two' => 'value2',
            ];

            public $nullableParam = null;

            public $floatParam = 1.5;

            public $trueParam = true;

            public $falseParam = false;
        };

        $queryString = $instance->toQueryString();

        $this->assertEquals(
            'stringParam=value&numArray=first&numArray=second&assocArray=value1&assocArray=value2'
            . '&floatParam=1.5&trueParam=true&falseParam=false',
            $queryString
        );
    }
}
