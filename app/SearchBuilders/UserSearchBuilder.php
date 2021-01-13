<?php

namespace App\SearchBuilders;

class UserSearchBuilder extends SearchBuilder{

    public $model = '\App\Models\User';

    // search by keyword
    public function keywords($keywords){
        $keywords = is_array($keywords) ? $keywords : [$keywords];
        foreach ($keywords as $keyword) {
            $this->params['body']['query']['bool']['must'][] = [
                'multi_match' => [
                    'query'  => $keyword,
                    'fields' => [
                        'id^2',
                        'email',
                        'name'
                    ],
                    'fuzziness' => 'AUTO'
                ]
            ];
        }
        return $this;
    }
}
