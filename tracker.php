<?php

error_reporting(E_ALL || E_STRICT);
ini_set('display_errors', true);

$localeDir = 'locale';

$od = opendir($localeDir);
$langs = []; // Array of languages straight from the language files
$messages = []; // Array of the possible messages used in any language file

while (false !== ($curFile = readdir($od))) {
    if (is_file($localeDir . DIRECTORY_SEPARATOR . $curFile)) {
        // Pull in each $lang from the language files and store them in an array
        include($localeDir . DIRECTORY_SEPARATOR . $curFile);
        $langs[$curFile] = $lang;
    }
}

foreach ($langs as $langArray)
{
    // Loop through all the language files to get a complete list of messages defined
    foreach ($langArray as $curLang => $value) { // curLang: Not just a Canadian Winter Olympic sport
        if (!in_array($curLang, $messages)) {
            $messages[] = $curLang;
        }
    }
}

$out = '';

foreach ($langs as $langName => $langArray) {
    // Loop through all the language files and compare their messages to the master array
    if ($langName == 'en_US.php') {
        $out .= $langName . ' (These are presumed to be retired but are still present in other language files)' . PHP_EOL;
    } else {
        $out .= $langName . PHP_EOL;
    }
    foreach ($messages as $message) {
        if (!isset($langArray[$message])) {
            $out .= '* Missing ' . $message . PHP_EOL;
        }
    }
    $out .= PHP_EOL;
}

// Write the summary out to out.txt
file_put_contents('out.txt', $out);
