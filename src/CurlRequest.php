<?php

namespace Blazing;

class CurlRequest{
    
    protected $url;
    protected $data;
    
    public function __construct(string $url, array $data){
        $this->url = $url;
        $this->data = $data;
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
    
    public function makeRequest(){
        $data = json_encode($this->data);
        if (json_last_error() !== JSON_ERROR_NONE){
            throw new \Exception("the array provided could not be properly encoded as a json object!");
        }
        
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
                array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ( $status != 201 && $status != 200 ) {
            die("Error: call to URL $this->url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl) . var_dump($data));
        }
        curl_close($curl);
        $response = new Response($json_response);
        
        return $response;
    }
}