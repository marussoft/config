<?php

declare(strict_types=1);

namespace Marussia\Config\Exceptions;

class DirPathIsAlreadyInstalledException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Config directory path is already installed');
    }
}
