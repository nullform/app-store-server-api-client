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
}
