<?php

namespace App\Console\Commands\Elasticsearch;

use App\Models\Searchable;

trait Operate{

    public $es;

    public function getAllIndices(){
        $path = app_path() . '/Models';
        $all_models = [];
        foreach ($this->getModels($path) as $model_path) {
            $model_path = str_replace($path, '\App\Models', $model_path);
            $model_path = str_replace('/', '\\', $model_path);
            if (class_exists($model_path)) {
                if ((new $model_path()) instanceof Searchable) {
                    $all_models[] = $model_path;
                }
            }
        }
        return $all_models;
    }

    protected function getModels($path){
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            $filename = $path . '/' . $result;
            if (is_dir($filename)) {
                $out = array_merge($out, getModels($filename));
            }else{
                $out[] = substr($filename, 0, -4);
            }
        }
        return $out;
    }

    public function createIndex(String $alias_name, $index): void{

        $this->es->indices()->create([
            // the first version will be named end with '_0'
            'index' => $alias_name . '_0',
            'body' => [
                'mappings' => [
                    'properties' => $index::getProperties(),
                ],
                'aliases' => [
                    $alias_name => new \stdClass()
                ]
            ]
        ]);
    }

    public function updateIndex(String $alias_name, $index): void{

        $this->es->indices()->close(['index' => $alias_name]);

        $this->es->indices()->putSettings([
            'index' => $alias_name,
        ]);

        $this->es->indices()->putMapping([
            'index' => $alias_name,
            'body'  => [
                'properties' => $index::getProperties(),
            ]
        ]);

        $this->es->indices()->open(['index' => $alias_name]);
    }

    public function recreateIndex(String $alias_name, $index): void{

        $index_info = $this->es->indices()->getAliases(['index' => $alias_name]);

        $index_name = array_keys($index_info)[0];

        // check the name wheather end with number
        if (!preg_match('~_(\d+)$~', $index_name, $m)) {
            $msg = 'Incorrect index name :'. $index_name;
            throw new \Exception($msg);
        }

        $new_index_name = $alias_name . '_' . ($m[1] + 1);

        $this->es->indices()->create([
            'index' => $new_index_name,
            'body' => [
                'mappings' => [
                    'properties' => $index::getProperties()
                ]
            ]
        ]);

        // add data to new index
        $index::rebuild($new_index_name);

        // change alias
        $this->es->indices()->putAlias(['index' => $new_index_name, 'name' => $alias_name]);

        // delete old index
        $this->es->indices()->delete(['index' => $index_name]);

    }
}
