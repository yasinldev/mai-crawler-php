<?php

namespace lib\scraping;

define("ROOT_2", dirname(__DIR__, 2)); // define root directory

require_once ROOT_2 . '/helpers/robotstxtReader.php';
require_once ROOT_2 . '/helpers/parseURL.php';
require_once  '../robots.php';

use helpers\parseURL\parsingURL;
use helpers\robotstxtReader;
use lib\readRobots as robots;

// İsmailYK dinlerken kod yazmak aşırı keyifli oluyor :D (TR)

class scrap{
    public array $banned_links = [];
    public array $meta = [];
    public array $links = [];
    public array $images = [];

    public function get_page($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($status == 200){
            return $output;
        }else{
            throw new \InvalidArgumentException("Invalid URL or URL not found");
        }
    }

    public function get_links($url, $href, $count, $robotdtxt): array{
        $html = $this->get_page($url);
        $url = parse_url($url);

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        if($robotdtxt){
            $robot = new robots\robots();
            $robot->get_page_details();
            $robot->curl_robots();
            $call = new robotstxtReader\readfile();
            $call->read_robots(true, false); // true = get comments, false = empty lines

            $file = file_get_contents(ROOT_2 . "/json/parsedURL.json");
            $json = json_decode($file, true);
            for($i = 0; $i < count($call->disallow); $i++){
                if($url['host'] == $json['host']){
                    array_unshift($this->banned_links, $url['host'] . $call->disallow[$i]);
                }
            }
        }

        for($int = 0; $int < sizeof($this->banned_links); $int++){
            if($this->banned_links[$int] == $url['scheme'] . '://' . $url['host'] . $href){
                return $this->links;
            }
        }

        if($href) {
            if ($count != 0 || $count != null) {
                $links = $xpath->query("//a/@href");
                $i = 0;
                foreach ($links as $link) {
                    if ($i == $count) {
                        break;
                    }
                    array_unshift($this->links, $link->nodeValue);
                    $i++;
                }
            } else {
                $href = $xpath->query("//a/@href");
                for ($i = 0; $i < $href->length; $i++) {
                    array_unshift($this->links, $href[$i]->nodeValue);
                }
            }
        }
        //checking url for / or not
        for($int = 0; $int < sizeof($this->links); $int++){
            if(@$this->links[$int][0] == "/"){
                $this->links[$int] = $url['scheme'] . '://' . $url['host'] . $this->links[$int];
            }
        }
        echo "<pre>";
        return $this->links;
    }

    public function get_image($url, $src): array{
        $html = $this->get_page($url);

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        if($src != null){
            $src = $xpath->query("//img/@src");
            foreach($src as $s) {
                array_unshift($this->images, $s->nodeValue);
            }
        }

        for($int = 0; $int < sizeof($this->images); $int++){
            if(@$this->images[$int][0] == "/"){
                $this->links[$int] = $url['scheme'] . '://' . $url['host'] . $this->images[$int];
            }
        }

        echo "<pre>";
        return $this->images;
    }

    public function get_meta($url): array{
        $html = $this->get_page($url);
        $url = parse_url($url);

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new \DOMXPath($dom);

        $meta = $xpath->query("//meta");
        foreach($meta as $m){
            array_unshift($this->meta, $m->getAttribute('content'));
        }

        echo "<pre>";
        return $this->meta;
    }
}

$scrap = new scrap();
print_r($scrap->get_links("https://stackoverflow.com/questions/75164111/fatal-exception-java-lang-nullpointerexception-crash-event", true, 0, true));