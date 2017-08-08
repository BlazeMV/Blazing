<?php

namespace Blazing;

class Request extends BaseModel{
    
    protected $data;
    protected $method;
    protected $host;
    
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
        $this->host = $host;
    }
    
    private function validateMethod($method){
        return true;
    }
    
    public function send(){
        if ($this->method == null || $this->data == null){
            throw new \Exception("Invalid Request!");
        }
        if (!isset($this->data['method'])){
            $this->data['method'] = $this->method;
        }
        $url = "https://api.telegram.org/bot" . $this->host->getToken() . "/";
        
        $curl = new CurlRequest($url, $this->data);
        return $curl->execute();
    }
    
    public function makeMessage($params){
        $data = array(
           'method' => 'sendMessage' 
        );
        $data = array_combine($data, $params);
        $this->data = $data;
    }
}