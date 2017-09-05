<?php

namespace Blazing;

class FileBuilder
{
    public static function buildBotFiles($name, $token)
    {
        //bot.php
        $searchF  = array('{bot_var_name}', '{bot_token}');
        $replaceW = array($name, $token);

        $fh = fopen("bot_file_templates/bot.txt", 'w');
        $file = file_get_contents($fh);
        fclose($fh);
        $file = str_replace($searchF, $replaceW, $file);
        $res = file_put_contents("$name/$name.php", $file);
        fclose($fh);
        
        if ($res == false){
            return false;
        }
        
        //updates.php
        $searchF  = array('{bot_var_name}', '{bot_token}');
        $replaceW = array($name, $token);

        $fh = fopen("bot_file_templates/updates.txt", 'w');
        $file = file_get_contents($fh);
        fclose($fh);
        $file = str_replace($searchF, $replaceW, $file);
        $res = file_put_contents("$name/Updates.php", $file);
        fclose($fh);
        
        if ($res == false){
            return false;
        }
        
        //commands.php
        $searchF  = array('{bot_var_name}', '{bot_token}');
        $replaceW = array($name, $token);

        $fh = fopen("bot_file_templates/Commands.txt", 'w');
        $file = file_get_contents($fh);
        fclose($fh);
        $file = str_replace($searchF, $replaceW, $file);
        $res = file_put_contents("$name/Commands.php", $file);
        fclose($fh);
        
        if ($res == false){
            return false;
        }
        
        //callbackqueries.php
        $searchF  = array('{bot_var_name}', '{bot_token}');
        $replaceW = array($name, $token);

        $fh = fopen("bot_file_templates/callbackqueries.txt", 'w');
        $file = file_get_contents($fh);
        fclose($fh);
        $file = str_replace($searchF, $replaceW, $file);
        $res = file_put_contents("$name/CallBackQueries.php", $file);
        fclose($fh);
        
        if ($res == false){
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
