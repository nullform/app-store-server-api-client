<?php

namespace Nullform\AppStoreServerApiClient\Tests;

use Nullform\AppStoreServerApiClient\AbstractModel;

class AbstractModelTest extends AbstractTestCase
{
    public function testMap()
    {
        $model = new class extends AbstractModel
        {
            public $prop1 = 'value1';

            public $prop2 = 'value2';

            public $prop3 = 'value2';
        };

        $model->map(['prop2' => 'newValue', 'prop3' => null]);

        $this->assertTrue($model->prop1 === 'value1');
        $this->assertTrue($model->prop2 === 'newValue');
        $this->assertTrue($model->prop3 === null);
    }

    public function testToJson()
    {
        $model = new class extends AbstractModel
        {
            public $prop1 = 'value1';

            public $prop2 = 'value2';

            public $prop3 = 'value2';
        };

        $this->assertJson($model->toJson());
    }

    public function testToQueryString()
    {
        $instance = new class extends AbstractModel {

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

        $queryString = $instance->toAppleQueryString();

        $this->assertEquals(
            'stringParam=value&numArray=first&numArray=second&assocArray=value1&assocArray=value2'
            . '&floatParam=1.5&trueParam=true&falseParam=false',
            $queryString
        );
    }
}
