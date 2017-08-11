<?php

namespace Blazing;

use Composer\Script\Event;

class ComposerScripts
{
    public function new(Event $event)
    {
        $args = $event->getArguments();
        switch (strtolower($args[0]))
        {
            case "bot" : 
                this->newBot($args);
                break;
            case "command" : 
                this->newCommand($args);
        }
    }
    
    private function newBot(array $args)
    {
        $name = $args[1];
        $token = $args[2];
        
        $pregtoken = '/^[0-9]{9}:[a-zA-Z0-9-]{35}$/';
        $pregname = '/^[a-zA-Z0-9]{1,10}$/';
        $tokenresult = preg_match($pregtoken, $token);
        $nameresult = preg_match($pregname, $name);
        
        if ($tokenresult != 1)
        {
            echo "invalid token provided!";
        }
        if ($nameresult != 1)
        {
            echo "invalid bot name!"
        }
        
        $text = "<?php\nrequire('vendor/autoload.php')\n";
        file_put_contents($name . ".php", $text);
    }
    
    private function newCommand(array $args)
    {
        
    }
}