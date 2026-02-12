<?php
class Controller
{
    protected function view($view, $data = []) {
        extract($data);
        require "app/views/$view.php";
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    protected function model($model) {
        $modelFile = 'app/models/' . $model . '.php';

        if (!file_exists($modelFile)) {
            // die("Model {$model} tidak ditemukan!");
            http_response_code(404);
            require 'app/views/errors/404.php';
            exit;
        }

        require_once $modelFile;

        if (!class_exists($model)) {
            // die("Class {$model} tidak didefinisikan!");
            http_response_code(404);
            require 'app/views/errors/404.php';
            exit;
        }

        return new $model;
    }

    protected function requireLogin() {
        if (!isset($_SESSION['user'])) {
            $this->redirect('?url=auth/login');
            exit;
        }
    }

    /*protected function logActivity($id_user, $aktivitas) {

    if (empty($id_user)) {
        return; // jangan sampai fatal error
    }

    $this->model('Log')->add($id_user, $aktivitas);
    }*/

    protected function logActivity($id_user, $aktivitas) {

        if (empty($id_user)) {
            return;
        }

        $this->model('Log')->add((int) $id_user, $aktivitas);
    }



    protected function requireRole($roles) {
        $this->requireLogin();

        // $roles bisa string atau array
        if (is_string($roles)) {
            $roles = [$roles];
        }

        if (!in_array($_SESSION['user']['role'], $roles)) {
            // role tidak punya akses
            $this->redirect('?url=error/forbidden');
            exit;
        }

    }


}