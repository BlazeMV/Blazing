<?php

namespace Blazing\api;

use Blazing\api\media\Audio;
use Blazing\api\media\Document;
use Blazing\api\media\Game;
use Blazing\api\media\PhotoSize;
use Blazing\api\media\Sticker;
use Blazing\api\media\Video;
use Blazing\api\media\Voice;
use Blazing\api\media\VideoNote;
use Blazing\api\media\Contact;
use Blazing\api\media\Location;
use Blazing\api\media\Venue;
use Blazing\api\payment\Invoice;
use Blazing\api\payment\SuccessfulPayment;

class Bot{
    
    //fields/properties/vars region
    protected $message;
    protected $MessageId;
    protected $text;
    protected $chat;
    protected $sender;
    protected $SendDate;
    protected $ForwardOriginFrom;
    protected $ForwardOriginChat;
    protected $ForwardOriginMessageId;
    protected $ForwardOriginDate;
    protected $ReplyMessage;
    protected $EditDate;
    protected $entities = array();
    protected $audio;
    protected $document;
    protected $game;
    protected $photo;
    protected $sticker;
    protected $video;
    protected $voice;
    protected $VideoNote;
    protected $NewChatMembers;
    protected $caption;
    protected $contact;
    protected $location;
    protected $venue;
    protected $NewChatMember;
    protected $LeftChatMember;
    protected $NewChatTitle;
    protected $NewChatPhoto;
    protected $DeleteChatPhoto;
    protected $GroupChatCreated;
    protected $SuperGroupChatCreated;
    protected $ChannelChatCreated;
    protected $MigrateToChatId;
    protected $MigrateFromChatId;
    protected $PinnedMessage;
    protected $invoice;
    protected $SuccessfulSayment;
    //endregion
    
    public function __construct(array $message){
        $this->message = $message;
        $this->message_id = $this->message['message_id'];
        $this->send_date = $this->message['date'];
        $this->chat = new Chat($this->message['chat']);
        if (isset($this->message['from'])) {
            $this->sender = new User($this->message['from']);
        }
        if (isset($this->message['text'])) {
            $this->text = $this->message['text'];
        }
        if (isset($this->message['forward_from'])) {
            $this->sender = new User($this->message['forward_from']);
        }
        if (isset($this->message['forward_from_chat'])) {
            $this->forward_from_chat = new chat($this->message['forward_from_chat']);
        }
        if (isset($this->message['forward_from_message_id'])) {
            $this->forward_origin_message_id = $this->message['forward_from_message_id'];
        }
        if (isset($this->message['forward_date'])) {
            $this->forward_origin_date = $this->message['forward_date'];
        }
        if (isset($this->message['reply_to_message'])) {
            $this->reply_message = new Message($this->message['reply_to_message']);
        }
        if (isset($this->message['edit_date'])) {
            $this->edit_date = $this->message['edit_date'];
        }
        if (isset($this->message['entities'])) {
            foreach ($this->message['entities'] as $entity) {
                $this->entities[] = new Entity($entity);
            }
        }
        if (isset($this->message['audio'])) {
            $this->audio = new Audio($this->message['audio']);
        }
        if (isset($this->message['document'])) {
            $this->document = new Document($this->message['document']);
        }
        if (isset($this->message['game'])) {
            $this->game = new Game($this->message['game']);
        }
        if (isset($this->message['photo'])) {
            $this->photo = new PhotoSize($this->message['photo']);
        }
        if (isset($this->message['sticker'])) {
            $this->sticker = new Sticker($this->message['sticker']);
        }
        if (isset($this->message['video'])) {
            $this->video = new Video($this->message['video']);
        }
        if (isset($this->message['voice'])) {
            $this->voice = new Voice($this->message['voice']);
        }
        if (isset($this->message['video_note'])) {
            $this->video_note = new VideoNote($this->message['video_note']);
        }
        if (isset($this->message['new_chat_members'])) {
            $this->new_chat_members = $this->message['new_chat_members'];
        }
        if (isset($this->message['caption'])) {
            $this->caption = $this->message['caption'];
        }
        if (isset($this->message['contact'])) {
            $this->contact = new Contact($this->message['contact']);
        }
        if (isset($this->message['location'])) {
            $this->location = new Location($this->message['location']);
        }
        if (isset($this->message['venue'])) {
            $this->venue = new Venue($this->message['venue']);
        }
        if (isset($this->message['new_chat_member'])) {
            $this->new_chat_member = new User($this->message['new_chat_member']);
        }
        if (isset($this->message['left_chat_member'])) {
            $this->left_chat_member = new User($this->message['left_chat_member']);
        }
        if (isset($this->message['new_chat_title'])) {
            $this->new_chat_title = $this->message['new_chat_title'];
        }
        if (isset($this->message['new_chat_photo'])) {
            $this->new_chat_photo = $this->message['new_chat_photo'];
        }
        if (isset($this->message['delete_chat_photo'])) {
            $this->delete_chat_photo = $this->message['delete_chat_photo'];
        }
        if (isset($this->message['group_chat_created'])) {
            $this->group_chat_created = $this->message['group_chat_created'];
        }
        if (isset($this->message['supergroup_chat_created'])) {
            $this->supergroup_chat_created = $this->message['supergroup_chat_created'];
        }
        if (isset($this->message['channel_chat_created'])) {
            $this->channel_chat_created = $this->message['channel_chat_created'];
        }
        if (isset($this->message['migrate_to_chat_id'])) {
            $this->migrate_to_chat_id = $this->message['migrate_to_chat_id'];
        }
        if (isset($this->message['migrate_from_chat_id'])) {
            $this->migrate_from_chat_id = $this->message['migrate_from_chat_id'];
        }
        if (isset($this->message['pinned_message'])) {
            $this->pinned_message = new Message($this->message['pinned_message']);
        }
        if (isset($this->message['invoice'])) {
            $this->invoice = new Invoice($this->message['invoice']);
        }
        if (isset($this->message['successful_payment'])) {
            $this->successful_payment = new SuccessfulPayment($this->message['successful_payment']);
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
    
    public function has($field) {
        if ($this->${$field} == null) {
            return false;
        }
        return true;
    }
    
    
    
}