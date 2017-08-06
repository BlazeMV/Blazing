<?php

namespace Blazing;

class Bot{
    
    protected $token;
    protected $name;
    protected $id;
    protected $username;
    
    
    public function __construct($token){
        $this->token = $token;
        $this->name = $this->getMe()->getResult()['first_name'];
        $this->username = $this->getMe()->getResult()['username'];
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
    
    public function getMe(){
        $data = array([
            'method' => 'getMe'
        ]);
        $url = "https://api.telegram.org/bot" . $this->token . "/";
        
        $curl = new CurlRequest($url, $data);
        return $curl->makeRequest();
    }
    
    public function getUpdates(){
        $temp = file_get_contents('php://input');

        $data = json_decode($temp, true);

        $Update = new Update($data);
        return $Update;
    }
}