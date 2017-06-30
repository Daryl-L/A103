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
    public function collections_can_chunk_into_several_part_with_a_certain_number_and_not_presverve_key()
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
        ], $collection->chunk(4, false)->all());
    }

    /** @test */
    public function collections_can_chunk_into_several_part_with_a_certain_number_and_preserve_key()
    {
        $collection = new Collections([1, 2, 3, 4, 5, 6, 7]);
        $this->assertEquals([[1, 2, 3, 4], [5, 6, 7]], $collection->chunk(4, true)->all());
    }

    /** @test */
    public function collections_can_know_if_it_is_empty()
    {
        $collection = new Collections([]);
        $this->assertEquals(true, $collection->isEmpty());
    }

    /** @test */
    public function collections_can_collapse()
    {
        $collection = new Collections([[1, 2, 3], [4, 5, 6], [7, 8, 9]]);
        $this->assertEquals([1, 2, 3, 4, 5, 6, 7, 8, 9], $collection->collapse()->all());
    }

    /** @test */
    public function collections_can_combine_another_array()
    {
        $collections = new Collections(['name', 'age']);
        $this->assertEquals([
            'name' => 'Daryl',
            'age'  => 23
        ], $collections->combine(['Daryl', 23])->all());
    }

    /** @test */
    public function collections_can_tell_you_whether_it_contains_the_value_you_give()
    {
        $collections = new Collections(['name' => 'Desk', 'price' => 100]);
        $this->assertEquals(true, $collections->contains('Desk'));
        $this->assertEquals(false, $collections->contains('Chair'));
    }

    /** @test */
    public function collections_can_tell_you_whether_it_contains_the_value_and_the_key_you_give()
    {
        $collections = new Collections(['product' => 'Desk', 'price' => 200]);
        $this->assertEquals(true, $collections->contains('Desk', 'product'));
        $this->assertEquals(false, $collections->contains('Desk', 'price'));
    }

    /** @test */
    public function collections_can_tell_you_whether_it_contains_the_value_rely_on_the_rule_you_give()
    {
        $collections = new Collections([1, 2, 3, 4, 5]);
        $this->assertEquals(true, $collections->contains(function ($key, $value) {
            return $value > 0;
        }));
        $this->assertEquals(false, $collections->contains(function ($key, $value) {
            return $value < 0;
        }));
    }

    /** @test */
    public function collections_can_tell_you_how_much_values_in_it()
    {
        $collections = new Collections([1, 2, 3, 4]);
        $this->assertEquals(4, $collections->count());
    }
    
    /** @test */
    public function collections_can_tell_you_the_differences_between_collections_and_given_array()
    {
        $collections = new Collections([1, 2, 3, 4, 5]);
        $this->assertEquals([1, 3, 5], $collections->diff([2, 4, 6])->all());
    }

    /** @test */
    public function collections_can_tell_you_the_key_differences_between_collections_and_given_array()
    {
        $collections = new Collections([
            'one' => 10,
            'two' => 20,
            'three' => 30,
            'four' => 40,
            'five' => 50,
        ]);
        $this->assertEquals(['one' => 10, 'three' => 30, 'five' => 50], $collections->diffKeys([
            'two' => 2,
            'four' => 4,
            'six' => 6,
            'eight' => 8,
        ])->all());
    }
    
    /** @test */
    public function collections_can_figure_out_if_all_the_items_accept_the_rule_you_given()
    {
        $collections = new Collections([1, 2, 3, 4]);
        $this->assertEquals(false, $collections->every(function ($key, $value) {
            return $value > 2;
        }));
    }
}
