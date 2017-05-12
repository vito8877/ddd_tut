<?php
/**
 * Created by PhpStorm.
 * User: vitaly
 * Date: 22.04.17
 * Time: 15:34
 */

namespace tests\unit\entities;


use PHPUnit\Framework\TestCase;
use app\entities\Id;


class IdTest extends TestCase
{
    public function testCreate()
    {
        $id = $this->getInstance(23);
        $this->assertNotEmpty($id, 'check object creates');
        $this->assertAttributeEquals(23, 'id', $id, 'check object has property filled');
        $this->assertEquals(23, $id->getId(), 'check object getId method');
    }

    public function testIsEqualTo()
    {
        $model1 = $this->getInstance(23);
        $model2 = $this->getInstance(23);

        $this->assertTrue($model1->isEqualTo($model2), 'check object is equal to another');
    }

    public function testIsNotEqualTo()
    {
        $model1 = $this->getInstance(23);
        $model2 = $this->getInstance(4);

        $this->assertFalse($model1->isEqualTo($model2), 'check object is not equal to another');
    }




    /**
     * @param $id
     * @return Id
     */
    private function getInstance($id) : Id
    {
        $model = new Id($id);
        return $model;
    }
}
