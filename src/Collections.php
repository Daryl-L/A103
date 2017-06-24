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

    public function __construct($datas)
    {
        $this->length = 0;

        foreach ($datas as $key => $data) {
            $this->collections[] = new CollectionItem($key, $data);
            $this->length++;
        }
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
        $sum = 0;
        $count = 0;

        foreach ($this->collections as $collection) {
            $sum += $collection->getValue();
            $count++;
        }

        return $sum / $count;
    }

    /**
     * Get the array explanation of Collections.
     *
     * @return array
     */
    public function toArray() : array
    {
        $array = [];

        foreach ($this->collections as $collection) {
            $array[$collection->getKey()] = $collection->getValue();
        }

        return $array;
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

        for ($i = 0; $i < $this->length; $i++) {
            if ($arrayPart = array_slice($this->collections, $i * $length, $length)) {
                foreach ($arrayPart as $collection) {
                    if ($preserveKey) {
                        $array[$i][] = $collection->getValue();
                    } else {
                        $array[$i][$collection->getKey()] = $collection->getValue();
                    }
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