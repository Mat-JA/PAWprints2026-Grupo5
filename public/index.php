<?php

/* echo "<pre>"; */
/* print_r($_SERVER); */
/* die; */

require __DIR__ . '/../vendor/autoload.php';

use App\Router;


$miRouter = new Router();
$miRouter->rutear();
