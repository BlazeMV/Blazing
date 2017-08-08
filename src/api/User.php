<?php

namespace Blazing\api;

use Blazing\BaseModel;

class User extends BaseModel{
    
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
    
    public function has($field){
        if ($this->${$field} == null){
            return false;
        }
        return true;
    }
    
}