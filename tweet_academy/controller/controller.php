<?php
include_once '../classes/CONTROLLER.php';
include_once '../scripts/global/handleErrors.php';

try {
    session_start();
    $controller = new CONTROLLER();
    $controller->handleRequest();
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
