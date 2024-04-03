<?php

function viteJS() {
    $json = file_get_contents('manifest.json');
    $hash = json_decode($json, true);
    return asset($hash['index.html']['file']);
}

function viteCSS() { 
    $json = file_get_contents('manifest.json');
    $hash = json_decode($json, true);
    return asset($hash['index.css']['file']);
}

?>