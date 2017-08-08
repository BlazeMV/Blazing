<?php

namespace Blazing\api;

use Blazing\BaseModel;
use Blazing\api\media\ChatPhoto;

class Chat extends BaseModel{
    
    protected $chat;
    protected $id;
    protected $type;
    protected $title;
    protected $username;
    protected $FirstName;
    protected $LastName;
    protected $AllMembersAreAdministrators;
    protected $photo;
    protected $description;
    protected $InviteLink;
    
    public function __construct(array $chat){
        $this->chat = $chat;
        $this->id = $this->chat['id'];
        $this->type = $this->chat['type'];
        if (isset($this->chat['title'])){
            $this->title = $this->chat['title'];
        }
        if (isset($this->chat['username'])){
            $this->username = $this->chat['username'];
        }
        if (isset($this->chat['first_name'])){
            $this->FirstName = $this->chat['first_name'];
        }
        if (isset($this->chat['last_name'])){
            $this->LastName = $this->chat['last_name'];
        }
        if (isset($this->chat['all_members_are_administrators'])){
            $this->AllMembersAreAdministrators = $this->chat['all_members_are_administrators'];
        }
        if (isset($this->chat['photo'])){
            $this->photo = new ChatPhoto($this->chat['photo']);
        }
        if (isset($this->chat['description'])){
            $this->description = $this->chat['description'];
        }
        if (isset($this->chat['invite_link'])){
            $this->InviteLink = $this->chat['invite_link'];
        }
    }
    
}