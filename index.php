<?php

const DS = DIRECTORY_SEPARATOR;
define("RUN_PATH", realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

require_once RUN_PATH . "vendor/autoload.php";

/*** Processing ***/

$filename = RUN_PATH . "temp" . DS . "shortVCardList.vcf";

try {
    $vCards = \VCard_v3::parse($filename,true);

    var_dump($vCards);
} catch (\Exception $e) {
    echo "Fail: `{$e->getMessage()}` at {$e->getFile()}::{$e->getLine()}\n";
}


