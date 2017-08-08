<?php

namespace Blazing;

class BaseModel{
    
    public function __get($field) {
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
    }
    
    public function __set($field, $value) {
        $strip_field = strtolower(str_ireplace(array('_', '-', '.'), '', $field));
        $ref = new \ReflectionClass($this);
        $found = false;
        foreach ($ref->getproperties() as $prop){
            $strip_prop = strtolower(str_ireplace(array('_', '-', '.'), '', $prop));
            if ($strip_field == $strip_prop){
                $found = true;
                $temp = $prop->getName();
                $this->$temp = $value[0];
                return true;
            }
        }
        if (!$found){
            throw new \Exception("Unknown method get" . $field);
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
    
}