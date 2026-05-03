<?php

/* echo "<pre>"; */
/* print_r($_SERVER); */
/* die; */

require __DIR__ . '/../src/bootstrap.php';

$router->dispatch($request);
