<?php

require_once __DIR__ . '/../models/User.php';

class UserService {

    private $model;

    public function __construct() {
        $this->model = new User();
    }

    public function getUsers() {
        return $this->model->getAll();
    }

    public function getUser($id) {
        return $this->model->getById($id);
    }

    public function update($id, $data) {
        return $this->model->update($id, $data);
    }

    public function deleteUser($id) {
        $user = $this->model->getById($id);
        if (!$user) {
            return false;
        }
        if (!empty($user['anh_dai_dien'])) {
            $url = "http://localhost/website_oop/file-service/public/delete?file=" 
                . urlencode($user['anh_dai_dien']);

            @file_get_contents($url);
        }
        if (!empty($user['anh_nen'])) {
            $url = "http://localhost/website_oop/file-service/public/delete?file=" 
                . urlencode($user['anh_nen']);

            @file_get_contents($url);
        }
        return $this->model->delete($id);
    }

    public function create($data) {
        return $this->model->create($data);
    }
}