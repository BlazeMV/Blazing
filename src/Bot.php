<?php

namespace Blazing;

class Bot extends BaseModel{
    
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