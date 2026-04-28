<?php

require_once __DIR__ . '/../controllers/UserController.php';

class Router {

    public static function handle() {

        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        $parts = explode('public/', $uri);
        $uri = end($parts);

        $method = $_SERVER['REQUEST_METHOD'];

        $controller = new UserController();

        // /users
        if ($uri === 'users') {

            if ($method === 'GET') {
                $controller->index();
                return;
            }

            if ($method === 'POST') {
                $controller->store();
                return;
            }
        }

        // /users/{id}
        if (preg_match('#^users/(\d+)$#', $uri, $matches)) {

            $id = $matches[1];

            if ($method === 'GET') {
                $controller->show($id);
                return;
            }

            if ($method === 'POST' || $method === 'PUT') {
                $controller->update($id);
                return;
            }

            if ($method === 'DELETE') {
                $controller->delete($id);
                return;
            }
        }

        http_response_code(404);
        echo json_encode(["error" => "Not Found"]);
    }
}