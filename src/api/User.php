<?php

namespace Blazing\api;

class Bot{
    
    protected $user;
    protected $id;
    protected $FirstName;
    protected $LastName;
    protected $username;
    protected $LanguageCode;
    
    public function __construct($user){
        $this->user = $user;
        $this->id = $this->user['id'];
        $this->first_name = $this->user['first_name'];
        if (isset($this->user['last_name'])){
            $this->last_name = $this->user['last_name'];
        }
        if (isset($this->user['username'])){
            $this->username = $this->user['username'];
        }
        if (isset($this->user['language_code'])){
            $this->language_code = $this->user['language_code'];
        }
    }
    
    public function __get($field) {
        $field_lc = strtolower($field);
        if (property_exists($this, $field)){
            return $this->$field;
        }elseif (property_exists($this, $field_lc)){
            return $this->$field_lc;
        }else{
            throw new \Exception("Unknown method get" . $field);
        }
        
    }
    
    public function __set($field, $value) {
        $field_lc = strtolower($field);
        if (property_exists($this, $field)){
            $this->$field = $value;
        }elseif (property_exists($this, $field_lc)){
            $this->$field_lc = $value;
        }else{
            throw new \Exception("Unknown method set" . $field);
        }
    }
    
    public function __call($method, $args) {
        if (substr((string)$method, 0, 3) == 'get'){
            return $this->__get(substr($method, 3));
        }elseif (substr((string)$method, 0, 3) == 'set'){
            return $this->__set(substr($method, 3), $args);
        }else{
            throw new \Exception("Unknown method " . $method);
        }
    }
    
    public function has($field){
        if ($this->${$field} == null){
            return false;
        }
        return true;
    }
    
}