<?php

namespace Blazing\api;

use Blazing\BaseModel;

class Entity extends BaseModel{
    
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
    
    public function getText(){
        return substr($this->getMessage()->getText(), $this->getOffset(), $this->getLength());
    }
    
}