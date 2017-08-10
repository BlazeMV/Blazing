<?php

namespace Blazing;

class ComposerScripts {
    
    public static function createTest(){
        $txt = fopen("test.txt","wb");
        fclose($txt);
    }
}