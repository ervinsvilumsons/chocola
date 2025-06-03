<?php

/**
 * @property string $errorMessage
 * @return void
 */
function error(string $errorMessage): void
{
    fwrite(STDERR, "\033[31m" . $errorMessage . "\033[0m");
}

/**
 * @property string $infoMessage
 * @return void
 */
function info(string $infoMessage): void
{
    echo $infoMessage;
}

