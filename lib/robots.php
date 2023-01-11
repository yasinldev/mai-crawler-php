<?php

namespace lib\readRobots;

class robots{
    public $host;
    public $scheme;

    public array $disallow = [];
    public array $allow = [];

    public function get_page_details(){
        fopen("../json/parsedURL.json", "r") or die("Unable to open file!");
        $file = file_get_contents("../json/parsedURL.json");
        $decode = json_decode($file, true);

        $this->host = $decode['host'];
        $this->scheme = $decode['scheme'];
    }

    public function read_robots(){
        $host = $this->host;
        $sheme = $this->scheme;
        $url = "$sheme://".$host."/robots.txt";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        fopen("../json/robots/robots.txt", "w+") or die("Unable to open file!");
        if($status == 200){
            file_put_contents("../json/robots/robots.txt", $output);
        }else{
            file_put_contents("../json/robots/robots.txt", "No robots.txt file found");
        }
    }

    public function save_settings(){
        $fl = fopen("../json/robots/robots.txt", "r") or die("Unable to open file!");
        $file = file_get_contents("../json/robots/robots.txt");
        $count = 0;
        while(($line = fgets($fl)) !== false){
            $count++;
        }
        for($i = 0; $i < $count; $i++) {
            if(explode("#", $file)[$i] == "Comment"){
                continue;
            }
            if (strpos($file, "Disallow: ") !== false) {
                $disallow = explode("Disallow: ", $file);
                @$this->disallow[] = $disallow[$i];
            } elseif (strpos($file, "Allow: ") !== false) {
                $allow = explode("Allow: ", $file);
                @$this->allow[] = $allow[$i];
            }
        }
        echo "<pre>";
        print_r($this->disallow);
        echo "</pre>";
    }
}

$class = new robots();
$class->get_page_details();
$class->read_robots();
$class->save_settings();