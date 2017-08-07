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
                        ));
                        break;

                    case "/help":
                        $bot->sendRequest(array(
                            'method' => 'sendMessage',
                            'text' => $this->host->getHelpText(),
                            'chat_id' => $msg->getChatId(),
                            'reply_to_message_id' => $msg->getMessageId()
                        ));
                        break;
                }
            }
        }
    }
    
    public function __get($field) {
        $field_name = str_ireplace(array('_', '-', '.'), '', $field);
        $ref = new ReflectionClass($this);
        $found = false;
        foreach ($ref->getproperties() as $prop){
            if (strtolower($prop->getName()) == strtolower($field_name)){
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
        $field_name = str_ireplace(array('_', '-', '.'), '', $field);
        $ref = new ReflectionClass($this);
        $found = false;
        foreach ($ref->getproperties() as $prop){
            if (strtolower($prop->getName()) == strtolower($field_name)){
                $found = true;
                $temp = $prop->getName();
                $this->$temp = $value[0];
                return true;
            }
        }
        if (!$found){
            throw new \Exception("Unknown method set" . $field);
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
    
    public function hasCommand(){
        if ($this->getUpdateType() == 'Message' && $this->getUpdateObject()->has('entities')){
            foreach ($this->getUpdateObject()->getEntities() as $entity){
                if ($entity->getType() == 'bot_command'){
                    return true;
                }
            }
        }
        return false;
    }
    
    public function getCommand(){
        if ($this->hasCommand()){
            foreach ($this->getUpdateObject()->getEntities() as $entity){
                if ($entity->getType() == 'bot_command'){
                    return $entity->gettext();
                }
            }
        }else{
            throw new \Exception("Update does not contain a bot command!");
        }
    }
    
    public function isCallBackQuery(){
        if ($this->getUpdateType() == 'CallbackQuery'){
            return true;
        }else{
            return false;
        }
    }
    
    public function getCallBackQueryData(){
        if ($this->isCallBackQuery()){
            return $this->getUpdateObject()->getData();
        }else{
            throw new \Exception("Update does not contain a bot command!");
        }
    }
}