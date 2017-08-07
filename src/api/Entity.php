<?php

namespace Blazing\api;

class Entity{
    
    protected $entity;
    protected $type;
    protected $offset;
    protected $length;
    protected $url;
    protected $user;
    protected $message;
    
    public function __construct($entity, $message){
        $this->entity = $entity;
        $this->message = $message
        $this->offset = $this->entity['offset'];
        $this->length = $this->entity['length'];
        $this->type = $this->entity['type'];
        if (isset($this->entity['url'])){
            $this->url = $this->entity['url'];
        }
        if (isset($this->entity['user'])){
            $this->user = $this->entity['user'];
        }
    }
    
    public function __get($field) {
        $field_name = str_ireplace(array('_', '-', '.'), '', $field);
        $ref = new ReflectionClass($this);
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
        $ref = new ReflectionClass($this);
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
    
    public function getText(){
        return substr($this->getMessage()->getText(), $this->getOffset(), $this->getLength());
    }
    
}