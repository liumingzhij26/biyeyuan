<?php
namespace Response;

class Response {

    public static function Json($array=array(), $callback=null){
        header('Content-Type: application/json; charset=utf8');
        $data = json_encode($array);
        if(isset($callback)){
            echo $callback."({$data});";
        }else {
            echo $data;
        }

    }
}