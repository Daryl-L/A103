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

namespace Daryl\Collection\Contracts;


interface CollectionsInterface
{
    public function all() : array;

    public function average();

    public function sum();

    public function toArray() : array;

    public function chunk(int $length, bool $preserveKey) : array;

    public function isEmpty() : bool;
}