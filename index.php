<?php

namespace fyreplace;

use fyreplace\util\Settings;

include "vendor/autoload.php";

$path = explode("/", substr($_SERVER['REQUEST_URI'], 1));
$controller = $path[0];

unset($path[0]);

$path_string = implode("/", $path);

$found_controller = null;
$controllers = Settings::getArray("controllers");
foreach ($controllers as $qualified => $match) {
    if ($match === $controller) {
        /** @var Controller $found_controller */
        $found_controller = Settings::get("controller_namespace") . '\\' . $qualified;
        break;
    }
}
//Set to default controller if no controller was specified
if(is_null($found_controller)){
    $found_controller = Settings::get("controller_namespace") . '\\' . Settings::get("default_controller");
}

$result = $found_controller::getView($path_string, $_REQUEST);
//Run result action until View is returned
while ($result instanceof Result) {
    $result = $result->doAction();
}

//Render View
print $result->render();
