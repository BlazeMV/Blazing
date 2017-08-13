<?php

namespace Blazing;

class FileBuilder
{
    public static function buildBotFile($name, $token)
    {
        $text = "<?php\n" . 
            "use Blazing\Bot;\n" . 
            "include('../vendor/autoload.php');\n\n" .
            "define('APP_ROOT_FOLDER', realpath(__DIR__.'/../'));\n" .
            "define('BOT_NAME', '" . $name . "');\n\n" .
            '$'."loader = require APP_ROOT_FOLDER . '/vendor/autoload.php';\n" .
            '$'."loader->setPsr4('" . $name . "\\\', __DIR__);\n\n" .
            '$'."token = '" . $token . "';\n" .
            "$" . $name . " = new Bot($token);\n" .
            "return $" . $name . "->getUpdates();\n\n\n\n\n" .
            "?>";
        $text = "<?php\n" . 
            "use Blazing\Bot;\n" . 
            "include('../vendor/autoload.php');\n\n" .
            "define('APP_ROOT_FOLDER', realpath(__DIR__.'/../'));\n" .
            "define('BOT_NAME', '$name');\n\n" .
            '$'."loader = require APP_ROOT_FOLDER . '/vendor/autoload.php';\n" .
            '$'."loader->setPsr4('$name\\\', __DIR__);\n\n" .
            '$'."token = '$token';\n" .
            "$$name = new Bot('$token');\n" .
            "return $".$name."->getUpdates();\n\n\n\n\n" .
            "?>";
        
        if (file_put_contents($name . '/' . $name . '.php', $text) == false)
        {
            return false;
        }
        
        $text = "<?php\n\n" .
            "namespace " . $name . ";\n\n" .
            "class Commands\n" .
            "{\n" .
            "   public static function __callStatic(".'$'."method, ".'$'."args)\n" .
            "   {\n" .
            "       throw new \Exception('command /' . ".'$'."method . ' is not registered!');\n" .
            "   }\n\n" .
            "   public static function has(".'$'."command)\n" .
            "   {\n" .
            "       return method_exists(__CLASS__, ".'$'."command);\n" .
            "   }\n" .
            "}\n\n?>";
        
        if (file_put_contents($name . '/Commands.php', $text) == false)
        {
            return false;
        }
        
        $text = "<?php\n\n" .
            "namespace " . $name . ";\n\n" .
            "class Commands\n" .
            "{\n" .
            "   public static function __callStatic(".'$'."method, ".'$'."args)\n" .
            "   {\n" .
            "       throw new \Exception('command /' . ".'$'."method . ' is not registered!');\n" .
            "   }\n\n" .
            "   public static function has(".'$'."command)\n" .
            "   {\n" .
            "       return method_exists(__CLASS__, ".'$'."command);\n" .
            "   }\n" .
            "}\n\n?>";
        
        if (file_put_contents($name . '/CallBackQueries.php', $text) == false)
        {
            return false;
        }
        
        return true;
    }
    
    public static function addCommand($command, $botname)
    {
        
    }
    
    public static function addQuery($query, $botname)
    {
        
    }
    
}