<?php

include 'helpers/robotstxtReader.php';
include 'helpers/parseURL.php';

use helpers\robotstxtReader\readfile;
use helpers\parseURL\parsingURL;

$call = new readfile();
$parse = new parsingURL();

$parse->parseURL('www.google.com', true);
$call->read_robots(true, false);