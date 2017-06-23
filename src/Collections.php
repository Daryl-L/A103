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

    public function __construct($datas)
    {
        foreach ($datas as $key => $data) {
            $this->collections[] = new CollectionItem($key, $data);
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
}