<?php

// fixed settings
const XML_FILENAME = 'config.xml';

// get patch filename from argument
if(!array_key_exists(1, $argv) || $argv[1] === '--help') {
    echo "Usage: php deploy.php patch-X.MPQ \n" .
         "Caution, patch filenames are case sensitive.\n";
    exit;
}
$patchFilename = $argv[1];

// parse .env
if(!file_exists('.env')) {
    echo "Env file .env does not exist.\n";
    exit;
}
$env = parse_ini_file('.env');

// check if XML file exists
$configFilename = $env['PUBLIC_DIRECTORY'] . '/' . XML_FILENAME;
if(!file_exists($configFilename)) {
    echo "Serverside config.xml file does not exist.\n";
    exit;
}

// calculate new patch checksum
$checksum = md5_file($env['SOURCE_DIRECTORY'] . '/' . $patchFilename);

// get current patch checksum
$xml = simplexml_load_file($configFilename);
$xmlPatchNode = $xml->xpath('patches/patch[file = \''.$patchFilename.'\']')[0]->md5;
$currentChecksum = (string) $xml->xpath('patches/patch[file = \''.$patchFilename.'\']')[0]->md5;
if($currentChecksum === $checksum) {
    echo "Checksums of both patches (the active and the new ones) are the same.\n";
    exit;
}
echo "Checksum (old): " . $currentChecksum . "\n";
echo "Checksum (new): " . $checksum . "\n"; 

// set XML to maintenance mode
$xml->mode = "maintenance";
$xml->asXml($configFilename);

// copy the patch to the public directory
copy($env['SOURCE_DIRECTORY'] . '/' . $patchFilename, $env['PUBLIC_DIRECTORY'] . '/' . $patchFilename);

// update XML with new checksum and set mode available mode 
$xml->mode = "available";
$xml->lastUpdate = date(DATE_ISO8601);
$xml->xpath('patches/patch[file = \''.$patchFilename.'\']')[0]->md5 = $checksum;
$xml->asXml($configFilename);

echo "Patch ".$patchFilename." successfully deployed, checksum: ".$checksum." \n";