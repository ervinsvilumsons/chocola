<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Commands\ChocolaCommand;

$command = new ChocolaCommand();
$command->run();
