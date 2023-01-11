<?php

namespace helpers\robotstxtReader;

class readfile{
    public array $comments = array();
    public array $disallow = array();
    public array $allow = array();
    public string $useragent = "";
    public int $crawl_delay = 0;

    public function read_robots($comments, $emptyLines){
        $fl = fopen("../json/robots/robots.txt", "r") or die("Unable to open file!");
        $ofile = file("../json/robots/robots.txt") or die("Unable to open file!");
        $count = 0;
        while((fgets($fl)) !== false){
            $count++;
        }

        for($int = 0; $int < $count; $int++) {
            if ($comments) { // if comments are allowed
                if (strpos($ofile[$int], "#") !== false) {
                    $this->comments[] = $ofile[$int];
                }
            }
            if ($emptyLines) { // if empty lines are allowed
                if ($ofile[$int] == "") {
                    $this->comments[] = "Empty line";
                }
            }
            if(strpos($ofile[$int], "User-agent: ") !== false){ // if user-agent is found
                $this->useragent = explode("User-agent: ", $ofile[$int])[1];
            }
            if(strpos($ofile[$int], "Crawl-delay: ") !== false){ // if crawl-delay is found
                $this->crawl_delay = explode("Crawl-delay: ", $ofile[$int])[1];
            }
            if(strpos($ofile[$int], "Disallow: ") !== false){ // if disallow is found
                $this->disallow[] = explode("Disallow: ", $ofile[$int])[1];
            }
            if(strpos($ofile[$int], "Allow: ") !== false){ // if allow is found
                $this->allow[] = explode("Allow: ", $ofile[$int])[1];
            }
        }
        // JSON encode rules
        fopen("../json/robots/robots.json", "w+") or die("Unable to open file!");
        $json = json_encode($this, JSON_PRETTY_PRINT);
        if(file_put_contents("../json/robots/robots.json", $json)){
            return true;
        } else{
            throw new \InvalidArgumentException("Unable to write to file");
        }
    }
}
$call = new readfile();
$call->read_robots(true, false);
