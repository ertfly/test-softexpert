<?php

use Helpers\DatabaseHelper;
use Helpers\RouterHelper;

require_once getenv('PATH_VENDOR');

RouterHelper::start();
//After that line do not insert any code
DatabaseHelper::closeInstance();
