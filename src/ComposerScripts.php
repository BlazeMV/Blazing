<?php

namespace Blazing;

class ComposerScripts {
    
    public static function createTest(){
        $txt = fopen("test.txt","wb");
        fclose($txt);
    }
    
    public static function afterInstall(){
        unlink("composer.json");
        copy("\vendor\blaze\blazing\composer.json", "composer.json");
    }
}