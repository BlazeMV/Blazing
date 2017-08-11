<?php

namespace Blazing;

use Composer\Script\Event;

class ComposerScripts
{
    public function test(Event $event){
        $args = $event->getArguments();
        $args_dump = var_dump($args);
        $file = 'args.txt';
        file_put_contents($file, $args_dump);
    }
}