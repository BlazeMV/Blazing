<?php

namespace Blazing;
use Blazing\api\Message;
use Blazing\api\inline\InlineQuery;
use Blazing\api\inline\ChosenInlineResult;
use Blazing\api\CallbackQuery;
use Blazing\api\payment\ShippingQuery;
use Blazing\api\payment\PreCheckoutQuery;

class Update{
    protected $update;
    protected $update_id;
    protected $updateobject;
    protected $host;
    
    const UpdateTypes = array('Message', 'InlineQuery', 'ChosenInlineResult', 'CallbackQuery', 'ShippingQuery', 'PreCheckoutQuery');
    
    public function __construct(array $resquest, $bot){
        $this->host = $bot;
        $this->update = $resquest;
        if (isset($this->update['update_id'])){
            $this->update_id = $this->update['update_id'];
        }
        if (isset($this->update['message'])){
            $this->updateObject = new Message($this->update['message']);
        }
        if (isset($this->update['edited_message'])){
            $this->updateObject = new Message($this->update['edited_message']);
        }
        if (isset($this->update['channel_post'])){
            $this->updateObject = new Message($this->update['channel_post']);
        }
        if (isset($this->update['edited_channel_post'])){
            $this->updateObject = new Message($this->update['edited_channel_post']);
        }
        if (isset($this->update['inline_query'])){
            $this->updateObject = new InlineQuery($this->update['inline_query']);
        }
        if (isset($this->update['chosen_inline_result'])){
            $this->updateObject = new ChosenInlineResult($this->update['chosen_inline_result']);
        }
        if (isset($this->update['callback_query'])){
            $this->updateObject = new CallbackQuery($this->update['callback_query']);
        }
        if (isset($this->update['shipping_query'])){
            $this->updateObject = new ShippingQuery($this->update['shipping_query']);
        }
        if (isset($this->update['pre_checkout_query'])){
            $this->updateObject = new PreCheckoutQuery($this->update['pre_checkout_query']);
        }
        
        if ($this->getUpdateType() == 'Message'){
            $msg = $this->getUpdateObject();
            if ($msg->getCommand != false){
                switch (strtolower($msg->getCommand())) {
                    case "/start":
                        $bot->sendRequest(array(
                            'method' => 'sendMessage',
                            'text' => $this->host->getStartText(),
                            'chat_id' => $msg->getChatId(),
                            'reply_to_message_id' => $msg->getMessageId()
                        );
                        break;

                    case "/help":
                        $bot->sendRequest(array(
                            'method' => 'sendMessage',
                            'text' => $this->host->getHelpText(),
                            'chat_id' => $msg->getChatId(),
                            'reply_to_message_id' => $msg->getMessageId()
                        );
                        break;
                }
            }
        }
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
    
    public function getUpdateType(){
        $ok = false;
        $tempref = new \ReflectionClass($this->updateObject);
        $type = $tempref->getShortName();
        foreach (self::UpdateTypes as &$value) {
            if ($type == $value){
                $ok = true;
            }
        }
        if (!$ok){
            throw new \Exception("Unknown update type! " . $type . " hello");
        }
        return $type;
    }
}