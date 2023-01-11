# Mai Crawler for PHP
-- --
## Overview
Mai Crawler is PHP based a fast low-level web crawling and web scraping framework, used to crawl websites and extract structured data from their pages. It can be used for a wide range of purposes, from data mining to monitoring and automated testing.

Mai Crawler PHP Version maintained by <a href="https://github.com/yasinldev">yasinldev</a> and other Mai Team Members.

## For ``C`` and ``VLang`` Versions
Mai Crawler is also being developing for C and VLang, but this development process is not yet open to users. We will soon share C and VLang versions as public repository.

## Installation
You can install Mai Crawler using Composer. Run this command:

    composer require yasinldev/mai-crawler

## Basic Usage
<b>Parsing URL</b><br><br>
Note: The crawler auto write parsed url in parsedURL.json file. If you want to use single url, you can use parseURL() function.

```php
include 'vendor/autoload.php';
use mai-crawler-php\helpers\parseURL.php

$parse = new parseURL();
$parse->parseURL('github.com', false);
```
and earch url in parsedURL.json file. or you can use anon getURL() function.
```php
$parse->parseURL('github.com', true);
```
<b>Reading Robots.txt</b><br><br>
Crawler auto read robots.txt file and write in robots.json file. If you want to read robots.txt file, you can use read_robots() function.
```php
include 'vendor/autoload.php';
use mai-crawler-php\helpers\robotstxtReader.php

$robot = new robots();
$robot->read_robots(false, false); // First parameter is saving comments, second parameter is saving empty lines.
```
if you want getting robots.txt parameters, you can use class parameters.
```php
$robot->useragent;
$robot->disallow;
$robot->allow;
$robot->crawl_delay;
$robot->comment //if you allowed comments
```
<br>
<b>More information will be added soon.</b>

## About JSON folder
In this folder, you can find the JSON files that you need to use the Mai Crawler. You can use the JSON files in the ``examples`` folder to test the Mai Crawler.

## Requirements
* PHP 7.4 or higher
* PHP cURL extension
* PHP JSON extension
* Web server (Apache, Nginx, etc.)
* Composer ``https://getcomposer.org/`` ``optional``
