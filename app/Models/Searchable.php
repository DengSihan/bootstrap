<?php

namespace App\Models;

interface Searchable{
    // index name in elasticsearch
    public static function getAliasName();
    // index structure in elasticsearch
    public static function getProperties();
    // transform data from database to elasticsearch
    public function toESArray();
}
