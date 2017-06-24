<?php
/**
 * Copyright 2017 daryl <daryl.moe@outlook.com>

 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at

 * http://www.apache.org/licenses/LICENSE-2.0

 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

use Daryl\Collection\Collections;
use PHPUnit\Framework\TestCase;

class CollectionsTest extends TestCase
{
    /** @test */
    public function collections_can_return_array_for_all()
    {
        $collection = new Collections([0, 1, 2]);
        $this->assertEquals([0, 1, 2], $collection->all());
    }

    /** @test */
    public function collections_can_calculate_the_average_as_if_the_value_is_number()
    {
        $collection = new Collections([0, 1, 2]);
        $this->assertEquals(1, $collection->average());
    }

    /** @test */
    public function collections_can_be_reverted_to_array()
    {
        $collection = new Collections([0, 1, 2]);
        $this->assertEquals([0, 1, 2], $collection->toArray());
    }

    /** @test */
    public function collections_can_chunk_into_several_part_with_a_certain_number_and_presverve_key()
    {
        $collection = new Collections([1, 2, 3, 4, 5, 6, 7]);
        $this->assertEquals([
            [
                0 => 1,
                1 => 2,
                2 => 3,
                3 => 4,
            ], [
                4 => 5,
                5 => 6,
                6 => 7,
            ],
        ], $collection->chunk(4, false));
    }

    /** @test */
    public function collections_can_chunk_into_several_part_with_a_certain_number_and_not_preserve_key()
    {
        $collection = new Collections([1, 2, 3, 4, 5, 6, 7]);
        $this->assertEquals([[1, 2, 3, 4], [5, 6, 7]], $collection->chunk(4, true));
    }

    /** @test */
    public function collections_can_know_if_it_is_empty()
    {
        $collection = new Collections([]);
        $this->assertEquals(true, $collection->isEmpty());
    }
}
