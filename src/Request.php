<?php

namespace Blazing;

class Request{
    
    protected $data;
    protected $method;
    protected $host
    
    public function __construct($host, array $data=null, $method=null){
        if (isset($data['method'])){
            if (!$this->validateMethod($data['method'])){
                throw new \Exception("Invalid method for request! please have a look at https://core.telegram.org/bots/api#available-methods to see which methods are allowed!");
            }else{
                $this->method = $data['method'];
            }
            
        }elseif ($method !== null){
            if (!$this->validateMethod($method)){
                throw new \Exception("Invalid method for request! please have a look at https://core.telegram.org/bots/api#available-methods to see which methods are allowed!");
            }else{
                $this->method = $method;
            }
        }
        $this->data = $data;
        $this->host = host;
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
    
    private function validateMethod($method){
        return true;
    }
    
    public function send(){
        if ($this->method == null || $this->data == null){
            throw new \Exception("Invalid Request!");
        }
        if (!isset$this->data['method']){
            $this->data['method'] = $this->method;
        }
        $url = "https://api.telegram.org/bot" . $this->host->getToken() . "/";
        
        $curl = new CurlRequest($url, $this->data);
        return $curl->makeRequest();
    }
    
    public function makeMessage($params){
        $data = array([
           'method' => 'sendMessage' 
        ]);
        $data = array_combine($data, $params);
        $this->data = $data;
    }
}