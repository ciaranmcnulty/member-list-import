<?php

require 'vendor/autoload.php';

$importer = new Importer(new JsonMembersList($argv[2]), new CsvImportFile($argv[1]));

$importer->import();