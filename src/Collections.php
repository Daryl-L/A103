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

namespace Daryl\Collection;

use Daryl\Collection\Contracts\CollectionsInterface;

class Collections implements CollectionsInterface
{
    protected $collections;

    protected $length;

    public function __construct(array $collections)
    {
        $this->collections = $collections;
    }

    /**
     * Get all the collections as array.
     *
     * @return array
     */
    public function all() : array
    {
        return $this->toArray();
    }

    /**
     * Calculate the average of values which are numbers.
     *
     * @return float|int
     */
    public function average()
    {
        return $this->sum() / count($this->collections);
    }

    /**
     * Calculate the summary of values which are numbers.
     *
     * @return int|string
     */
    public function sum()
    {
        return $this->sumInterate($this->collections);
    }

    /**
     * Help to calculate the summary.
     *
     * @param $collections
     * @return int|string
     */
    protected function sumInterate($collections)
    {
        $sum = 0;
        foreach ($collections as $collection) {
            if (is_array($collection)) {
                $sum += $this->sumInterate($collection);
            } else {
                if (is_numeric($collection)) {
                    $sum += $collection;
                }
            }
        }

        return $sum;
    }

    /**
     * Get the array explanation of Collections.
     *
     * @return array
     */
    public function toArray() : array
    {
        return $this->collections;
    }

    /**
     * Chunk the collection to parts with a certain length.
     *
     * @param int $length
     * @param bool $preserveKey
     * @return array
     */
    public function chunk(int $length, bool $preserveKey) : array
    {
        $array = [];

        for ($i = 0; $i < ceil(count($this->collections) / $length); $i++) {
            $slice = array_slice($this->collections, $i * $length, $length);
            foreach ($slice as $key => $collection) {
                if ($preserveKey) {
                    $array[$i][] = $collection;
                } else {
                    $array[$i][$i * $length + $key] = $collection;
                }
            }
        }

        return $array;
    }

    /**
     * The collections is empty or not.
     *
     * @return bool
     */
    public function isEmpty() : bool
    {
        return !$this->length;
    }
}