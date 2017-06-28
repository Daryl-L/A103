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
     * Chunk the collection to parts with a certain length.
     *
     * @param int $length
     * @param bool $preserveKey
     * @return CollectionsInterface
     */
    public function chunk(int $length, bool $preserveKey) : CollectionsInterface
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

        return new self($array);
    }

    /**
     * Collapse the collection to a single one.
     *
     * @return CollectionsInterface
     */
    public function collapse() : CollectionsInterface
    {
        $index = 0;

        $array = $this->collapseIterate($this->collections, $index);
        return new self($array);
    }

    /**
     * Help to collapse collections.
     *
     * @param $collections
     * @param $index
     * @return array
     */
    protected function collapseIterate($collections, &$index)
    {
        $array = [];

        foreach ($collections as $collection) {
            if (is_array($collection)) {
                $array = array_merge($array, $this->collapseIterate($collection, $index));
            } else {
                $array[$index++] = $collection;
            }
        }

        return $array;
    }

    /**
     * Combine the collections with a given array.
     *
     * @param array $combine
     * @return CollectionsInterface
     */
    public function combine(array $combine) : CollectionsInterface
    {
        $array = [];

        foreach ($this->collections as $key => $collection) {
            $array[$collection] = $combine[$key];
        }

        return new self($array);
    }

    /**
     * To tell if it contains the value or key or rule you give in the params.
     *
     * @param $needle
     * @return bool
     */
    public function contains($needle) : bool
    {
        if ($needle instanceof \Closure) {
            foreach ($this->collections as $key => $collection) {
                if ($needle($key, $collection)) {
                    return true;
                }
            }
        } elseif (func_num_args() === 1) {
            foreach ($this->collections as $collection) {
                if ($collection == $needle) {
                    return true;
                }
            }
        } elseif (func_num_args() === 2) {
            foreach ($this->collections as $key => $collection) {
                if ($collection == $needle && $key == func_get_args()[1]) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * To tell how many elements in the collections.
     *
     * @return int
     */
    public function count() : int
    {
        $count = 0;

        $this->countIterate($this->collections, $count);

        return $count;
    }

    /**
     * Help to count the collections.
     *
     * @param $collections
     * @param $count
     */
    protected function countIterate($collections, &$count)
    {
        foreach ($collections as $collection) {
            if (is_array($collection)) {
                $this->countIterate($collection, $count);
            } else {
                $count++;
            }
        }
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

    /**
     * Calculate the summary of values which are numbers.
     *
     * @return int|string
     */
    public function sum()
    {
        return $this->sumIterate($this->collections);
    }

    /**
     * Help to calculate the summary.
     *
     * @param $collections
     * @return int|string
     */
    protected function sumIterate($collections)
    {
        $sum = 0;
        foreach ($collections as $collection) {
            if (is_array($collection)) {
                $sum += $this->sumIterate($collection);
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
}