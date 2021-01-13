<?php

namespace App\SearchBuilders;

abstract class SearchBuilder{

    public $params;

    public function __construct(){
        $this->params = [
            'index' => $this->model::getAliasName(),
            'type'  => '_doc',
            'body'  => [
                'query' => [
                    'bool' => [
                        'filter' => [],
                        'must'   => [],
                    ],
                ],
            ],
        ];
    }

    public function query(){
        $ids = collect(app('es')->search($this->getParams())['hits']['hits'])->pluck('_id')->all();
        return $this->model::query()
            ->whereIn('id', $ids)
            ->orderByRaw(
                sprintf(
                    "FIND_IN_SET(id, '%s')",
                    join(',', $ids)
                )
            );
    }

    // paginate
    public function paginate($size, $page){
        $this->params['body']['from'] = ($page - 1) * $size;
        $this->params['body']['size'] = $size;
        return $this;
    }

    // add order
    public function orderBy($field, $direction){
        if (!isset($this->params['body']['sort'])) {
            $this->params['body']['sort'] = [];
        }
        $this->params['body']['sort'][] = [$field => $direction];
        return $this;
    }

    // return the final params for elasticsearch
    public function getParams(){
        return $this->params;
    }

    // minimum_should_match
    public function minShouldMatch($count){
        $this->params['body']['query']['bool']['minimum_should_match'] = (int)$count;
        return $this;
    }

    public function minScore($score){
        $this->params['body']['min_score'] = (float)$score;
        return $this;
    }

    protected static function generateI18nColums(Array $colums){
        $results = array();
        foreach ($colums as $colum) {
            foreach (config('app.locales_available') as $locale) {
                list($name, $level) = explode('^', $colum);
                $results[] = $name . '_' . str_replace('-', '_', $locale) . '^' . ($level ?? 1);
            }
        }
        return $results;
    }
}
