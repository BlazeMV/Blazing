<?php

namespace Blazing;

class Response{
    
    protected $json_response;
    protected $array_response;
    
    public function __construct($json_response){
        $this->json_response = $json_response;
        $this->array_response = json_decode($json_response, true);
        $this->id = $this->getMe()->getResult()['id'];
    }
    
    public function __get($field) {
        $field_lc = strtolower($field);
        if (property_exists($this->$field)){
            return $this->$field;
        }elseif (property_exists($this->$field_lc)){
            return $this->$field_lc;
        }else{
            throw new /Exception("Unknown method get" . $field);
        }
        
    }
    
    public function __set($field, $value) {
        $field_lc = strtolower($field);
        if (property_exists($this->$field)){
            $this->$field = $value;
        }elseif (property_exists($this->$field_lc)){
            $this->$field_lc = $value;
        }else{
            throw new /Exception("Unknown method set" . $field);
        }
    }
    
    public function __call($method, $args) {
        if (substr((string)$method, 0, 3) == 'get'){
            return $this->__get(substr($method, 3));
        }elseif (substr((string)$method, 0, 3) == 'set'){
            return $this->__set(substr($method, 3), $args);
        }else{
            throw new /Exception("Unknown method " . $method);
        }
    }
    
    public function getJson(){
        return $this->json_response;
    }
    
    public function isOK(){
        if ($this->array_response['ok'] == true){
            return true;
        }else{
            return false;
        }
    }
    
    public function getResult(){
        return $this->array_response['result'];
    }
    
    public function getArray(){
        return $this->array_response;
    }
    
    public function getErrorCode(){
        return $this->array_response['error_code'];
    }
    
    public function getErrorDesc(){
        return $this->array_response['description'];
    }
    
}