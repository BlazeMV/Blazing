<?php

namespace Blazing\api;

use Blazing\BaseModel;

class CallBackQuery extends BaseModel{
    
    protected $CallBackQuery;
    protected $id;
    protected $from;
    protected $sender;
    protected $message;
    protected $InlineMessageId;
    protected $ChatInstance;
    protected $data;
    protected $GameShortName;
    
    public function __construct(array $query){
        $this->CallBackQuery = $query;
        $this->id = $this->CallBackQuery['id'];
        $this->from = $this->CallBackQuery['from'];
        $this->sender = $this->from;
        if (isset($this->CallBackQuery['message'])){
            $this->message = $this->CallBackQuery['message'];
        }
        if (isset($this->CallBackQuery['inline_message_id'])){
            $this->InlineMessageId = $this->CallBackQuery['inline_message_id'];
        }
        if (isset($this->CallBackQuery['chat_instance'])){
            $this->ChatInstance = $this->CallBackQuery['chat_instance'];
        }
        if (isset($this->CallBackQuery['data'])){
            $this->data = $this->CallBackQuery['data'];
        }
        if (isset($this->CallBackQuery['game_short_name'])){
            $this->GameShortName = $this->CallBackQuery['game_short_name'];
        }
    }
    
}