<?php

namespace App\Models;

trait SearchHelper{

    public static function rebuild(){
        $es = app('es');
        self::query()
            ->chunkById(100, function($cols) use ($es){
                $request = [
                    'body' => []
                ];
                foreach ($cols as $col) {
                    $data = $col->toESArray();
                    $request['body'][] =[
                        'index' => [
                            '_index' => self::getAliasName(),
                            '_id' => $data['id']
                        ]
                    ];
                    $request['body'][] = $data;
                }
                try{
                    $es->bulk($request);
                }catch(\Exception $e){
                    var_dump($e->getMessage());
                }
            });
    }

    protected static function getAnalyzer(String $locale = null): string{
        switch ($locale) {
            case 'ar':
                return 'arabic';
            case 'de':
                return 'german';
            case 'en':
                return 'english';
            case 'es':
                return 'spanish';
            case 'fr':
                return 'french';
            case 'hi':
                return 'hindi';
            case 'id':
                return 'indonesian';
            case 'it':
                return 'italian';
            case 'ja':
                return 'cjk';
            case 'ru':
                return 'russian';
            case 'zh-CN':
                return 'cjk';
            case 'zh-TW':
                return 'cjk';
            default:
                return 'standard';
        }
    }

    protected static function generateI18nColumeIndex(Array $colums): array{
        $results = array();
        foreach ($colums as $colum) {
            foreach (config('app.locales_available') as $locale) {
                $result[$colum . '_' . str_replace('-', '_', $locale)] = [
                    'type' => 'text',
                    'analyzer' => self::getAnalyzer($locale)
                ];
            }
        }
        return $results;
    }
}
