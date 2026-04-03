<?php
$action = $_GET['action'] ?? 'index';

require_once "controllers/MessageController.php";
$controller = new MessageController();

switch ($action) {
    case 'chat':
        $controller->chat();
        break;

    case 'send':
        $controller->send();
        break;

    case 'create':
        $controller->createConversation();
        break;

    default:
        $controller->index();
        break;
}