<?php

namespace Blazing;

use Composer\Script\Event;

class ComposerScripts
{
    public static function new(Event $event)
    {
        $args = $event->getArguments();
		
		if (count($args) == 0)
		{
			echo "invalid command!";
			exit();
		}
        switch (strtolower($args[0]))
        {
            case "bot" : 
                self::newBot($args);
                break;
            case "command" : 
                self::newCommand($args);
        }
    }
    
    private static function newBot(array $args)
    {
		if (count($args) != 3)
		{
			echo "invalid format!\ncomposer new bot [bot_name] [bot_token]\n2 parameters required! given " . count($args);
			exit();
		}
		
        $name = $args[1];
        $token = $args[2];
        
        $pregtoken = '/^[0-9]{9}:[a-zA-Z0-9-]{35}$/';
        $pregname = '/^[a-zA-Z0-9]{1,10}$/';
        $tokenresult = preg_match($pregtoken, $token);
        $nameresult = preg_match($pregname, $name);
        
        if ($tokenresult != 1)
        {
            echo "invalid token provided!";
			exit();
        }
        if ($nameresult != 1)
        {
            echo "invalid bot name!";
			exit();
        }
        
		if (file_exists($name))
		{
			echo "a bot named " . $name . " already exists!";
			exit();
		}
		
		$text = "<?php\n\nnamespace Blazing;\n\ninclude('vendor/autoload.php');\n\n$" . $name . " = new Bot('" . $token . "');\n\necho $" . $name . "->getUpdates();";
        mkdir($name);
		file_put_contents($name . "/" . $name . ".php", $text);
		echo $name . " initialized successfully! Build something amazing!";
		exit();
    }
    
    private static function newCommand(array $args)
    {
        
    }
}