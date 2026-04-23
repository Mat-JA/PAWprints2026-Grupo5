<?php

/* echo "<pre>"; */
/* print_r($_SERVER); */
/* die; */

use Src\Router;

require __DIR__ . '/../vendor/autoload.php';

$miRouter = new Router();
$miRouter->rutear();
