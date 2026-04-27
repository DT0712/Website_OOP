<?php
session_start();

require_once "controllers/AdminUserController.php";

$page = $_GET['page'] ?? 'dashboard';

switch ($page) {

    case 'user_management':
        (new AdminUserController())->index();
        break;

    case 'user_detail':
        (new AdminUserController())->show();
        break;

    case 'user_edit':
        (new AdminUserController())->edit();
        break;

    case 'user_delete':
        (new AdminUserController())->delete();
        break;

    case 'user_create':
        (new AdminUserController())->create();
        break;

    case 'user_store':
        (new AdminUserController())->store();
        break;

    default:
        require "dashboard.php";
}