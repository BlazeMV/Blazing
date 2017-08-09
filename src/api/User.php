<?php

namespace Blazing\api;

class User{
    
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
    
    public function __call($method, $args) {
        if (strtolower(substr((string)$method, 0, 3)) == 'get'){
            $strip_field = substr($method, 3);
            $strip_field = strtolower(str_ireplace(array('_', '-', '.'), '', $field));
            $ref = new \ReflectionClass($this);
            $found = false;
            foreach ($ref->getproperties() as $prop){
                $strip_prop = strtolower(str_ireplace(array('_', '-', '.'), '', $prop));
                if ($strip_field == $strip_prop){
                    $found = true;
                    $temp = $prop->getName();
                    return $this->$temp;
                }
            }
            if (!$found){
                throw new \Exception("Unknown method get" . $field);
            }
        }elseif (strtolower(substr((string)$method, 0, 3)) == 'set'){
            $strip_field = substr($method, 3);
            $strip_field = strtolower(str_ireplace(array('_', '-', '.'), '', $field));
            $ref = new \ReflectionClass($this);
            $found = false;
            foreach ($ref->getproperties() as $prop){
                $strip_prop = strtolower(str_ireplace(array('_', '-', '.'), '', $prop));
                if ($strip_field == $strip_prop){
                    $found = true;
                    $temp = $prop->getName();
                    $this->$temp = $args[0];
                }
            }
            if (!$found){
                throw new \Exception("Unknown method get" . $field);
            }
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