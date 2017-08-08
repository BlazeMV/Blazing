<?php

namespace Blazing;

class Response extends BaseModel{
    
    protected $json_response;
    protected $array_response;
    
    public function __construct($json_response){
        $this->json_response = $json_response;
        $this->array_response = json_decode($json_response, true);
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
        if ($this->isOK()){
            return $this->array_response['result'];
        }else{
            return $this->array_response;
        }
    }
    
    public function getArray(){
        return $this->array_response;
    }
    
    public function getErrorCode(){
        if ($this->isOK()){return 0;}
        return $this->array_response['error_code'];
    }
    
    public function getErrorDesc(){
        if ($this->isOK()){return "Not an error!";}
        return $this->array_response['description'];
    }
    
}