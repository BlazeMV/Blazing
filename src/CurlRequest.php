<?php

namespace Blazing;

class CurlRequest extends BaseModel{
    
    protected $url;
    protected $data;
    
    public function __construct(string $url, array $data){
        $this->url = $url;
        $this->data = $data;
    }
    
    public function execute(){
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