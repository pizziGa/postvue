<?php

function viteJS() {
    $json = file_get_contents('dist/manifest.json');
    $hash = json_decode($json, true);
    return asset('dist/'.$hash['index.html']['file']);
}

function viteCSS() { 
    $json = file_get_contents('dist/manifest.json');
    $hash = json_decode($json, true);
    return asset('dist/'.$hash['index.css']['file']);
}

?>