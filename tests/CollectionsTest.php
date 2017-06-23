<?php
/**
 * Created by PhpStorm.
 * User: daryl
 * Date: 2017/6/23
 * Time: 下午10:32
 */

use Daryl\Collection\Collections;
use PHPUnit\Framework\TestCase;

class CollectionsTest extends TestCase
{
    /** @test */
    public function a_collection_can_return_array_for_all()
    {
        $collection = new Collections([0, 1, 2]);
        $this->assertEquals([0, 1, 2], $collection->all());
    }

    /** @test */
    public function a_collection_can_calculate_the_average_as_if_the_value_is_number()
    {
        $collection = new Collections([0, 1, 2]);
        $this->assertEquals(1, $collection->average());
    }

    /** @test */
    public function a_collection_can_be_reverted_to_array()
    {
        $collection = new Collections([0, 1, 2]);
        $this->assertEquals([0, 1, 2], $collection->toArray());
    }
}
