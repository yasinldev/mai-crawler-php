<?php
/**
 * @author     : 	yasinldev
 * @version   : 	1.0.0
 * @package   : 	helpers
 *
 * @param     : 	$url
 */

namespace helpers\parseURL;
class parsingURL{

    public function parseURL($url, $getURL)
    {
        $url = parse_url($url);

        //saving json
        fopen("../json/parsedURL.json", "w+") or die("Unable to open file!");

        $encode = json_encode(array(
            "scheme" => @$url['scheme'],
            "host" => @$url['host'],
            "path" => @$url['path'],
            "query" => @$url['query'],
            "fragment" => @$url['fragment']
        ), JSON_PRETTY_PRINT);

        file_put_contents("../json/parsedURL.json", $encode);

        if($getURL){
            $print_func = function() use ($url){
              $dec = json_decode("../json/parsedURL.json") or die("Unable to open file!");
              if($dec->host == $url['host']){
                  return $dec;
              }
              return false;
            };
        }
    }
}

// Path: helpers\parseURL.php
$call = new parsingURL();
$call->parseURL('https://github.com/');
