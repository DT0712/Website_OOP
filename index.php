<?php
$action = $_GET['action'] ?? 'index';

require_once "controllers/OrderController.php";

$controller = new OrderController();

if ($action == 'deposit') {
    $controller->deposit();
} elseif ($action == 'cancel') {
    $controller->cancel();
} else {
    $controller->index();
}