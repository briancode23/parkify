<?php

require_once 'core/Controller.php';
require_once 'app/models/User.php';

class UserController extends Controller {
private $userModel;
public function __construct() {
    $this->userModel = new User();
}

    public function index() {
        $userModel = new User();
        $users = $userModel->getAll();

        $this->view('user/index', [
            'users' => $users
        ]);
    }
    
    public function detail($id) {
        $data['user'] = $this->userModel->getById($id);
        
        if (!$data['user']) {
            echo "User tidak ditemukan";
            return;
        }
        
        echo "<h3>Default User</h3>";
        echo "ID :" . $data['user']['id'] . "<br>";
        echo "Nama :" . $data['user']['name'] . "<br>";
        echo "Email :" . $data['user']['email'] . "<br>";
    }
}
