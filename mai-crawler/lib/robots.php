<?php

namespace lib\readRobots;

use helpers\robotstxtReader;

@define("ROOT", dirname(__DIR__, 1)); // define root directory

class robots extends robotstxtReader\readfile{
    public $host;
    public $scheme;


    public function get_page_details(){
        fopen(ROOT . "/json/parsedURL.json", "r") or die("Unable to open file!");
        $file = file_get_contents(ROOT . "/json/parsedURL.json");
        $decode = json_decode($file, true);

        $this->host = $decode['host'];
        $this->scheme = $decode['scheme'];
    }

    public function curl_robots(){
        $host = $this->host;
        $sheme = $this->scheme;
        $url = "$sheme://".$host."/robots.txt";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        fopen(ROOT . "/json/robots/robots.txt", "w+") or die("Unable to open file!");
        if($status == 200){
            file_put_contents(ROOT . "/json/robots/robots.txt", $output);
        }else{
            file_put_contents(ROOT . "/json/robots/robots.txt", "No robots.txt file found");
        }
    }

}

$class = new robots();
$class->get_page_details();
$class->curl_robots();
