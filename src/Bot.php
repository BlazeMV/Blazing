<?php

namespace Blazing;

class Bot{
    
    protected $token;
    protected $name;
    protected $id;
    protected $username;
    protected $start_Text = "Bot Started!";
    protected $help_Text = "Help text haven't been set yet!";
    
    public function __construct($token){
        $this->token = $token;
        $this->name = $this->getMe()->getResult()['first_name'];
        $this->username = $this->getMe()->getResult()['username'];
        $this->id = $this->getMe()->getResult()['id'];
    }
    
    public function __get($field) {
        $field_name = str_ireplace(array('_', '-', '.'), '', $field);
        $ref = new \ReflectionClass($this);
        $found = false;
        foreach ($ref->getproperties() as $prop){
            if (strtolower($prop->getName()) == strtolower($field_name)){
                $found = true;
                $temp = $prop->getName();
                return $this->$temp;
            }
        }
        if (!$found){
            throw new \Exception("Unknown method get" . $field);
        }
    }
    
    public function __set($field, $value) {
        $field_name = str_ireplace(array('_', '-', '.'), '', $field);
        $ref = new \ReflectionClass($this);
        $found = false;
        foreach ($ref->getproperties() as $prop){
            if (strtolower($prop->getName()) == strtolower($field_name)){
                $found = true;
                $temp = $prop->getName();
                $this->$temp = $value[0];
                return true;
            }
        }
        if (!$found){
            throw new \Exception("Unknown method set" . $field);
        }
    }
    
    public function __call($method, $args) {
        if (strtolower(substr((string)$method, 0, 3)) == 'get'){
            return $this->__get(substr($method, 3));
        }elseif (strtolower(substr((string)$method, 0, 3)) == 'set'){
            return $this->__set(substr($method, 3), $args);
        }else{
            throw new \Exception("Unknown method " . $method);
        }
    }
    
    public function getMe(){
        $data = array(
            'method' => 'getMe'
        );
        $req = new Request($this, $data);
        return $req->send();
    }
    
    public function getUpdates(){
        $temp = file_get_contents('php://input');

        $data = json_decode($temp, true);

        $Update = new Update($data, $this);
        return $Update;
    }
    
    public function sendRequest($data){
        $req = new Request($this, $data);
        return $req->send();
    }
}