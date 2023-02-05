<?php

namespace helpers\parseURL;

@define("ROOT", dirname(__DIR__, 1)); // define root directory

class parsingURL{

    public function parseURL($url)
    {
        $url = parse_url($url);

        //saving json
        fopen(ROOT . "/json/parsedURL.json", "w+") or die("Unable to open file!");

        $encode = json_encode(array(
            "scheme" => @$url['scheme'],
            "host" => @$url['host'],
            "path" => @$url['path'],
            "query" => @$url['query'],
            "fragment" => @$url['fragment']
        ), JSON_PRETTY_PRINT);

        file_put_contents(ROOT . "/json/parsedURL.json", $encode);

    }
}

// Path: helpers\parseURL.php
$call = new parsingURL();
$call->parseURL('https://github.com/');
