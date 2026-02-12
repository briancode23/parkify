<?php

class AuthController extends Controller {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            $userModel = $this->model('User');
            $user = $userModel->findByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id_user'],
                    'nama' => $user['nama_lengkap'],
                    'role' => $user['role']
                ];
                
                session_regenerate_id(true);
                $this->logActivity($user['id_user'], 'Login ke sistem');
                $this->redirect('?url=dashboard/index');
                return;
            }

            $this->view('auth/login', [
                'error' => 'Username atau password salah'
            ]);
            return;
        }

        $this->view('auth/login');
    }

    public function logout() {

        $user = $_SESSION['user']['id'] ?? null;

        if ($user) {
            $this->logActivity($user, 'Logout dari sistem');
        }

        session_unset();
        session_destroy();

        $this->redirect('?url=auth/login');
    }


    // tampilkan form register
    public function store() {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('?url=auth/create');
        }

        // ambil input
        $nama = trim($_POST['nama'] ?? '');
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] ?? '';
        $allowedRoles = ['admin',
            'petugas'];
            
        $errors = [];

        // ===== VALIDASI =====
        if ($nama === '') {
            $errors['nama'] = 'Nama wajib diisi';
        }

        if ($username === '') {
            $errors['username'] = 'Username wajib diisi';
        }

        if (strlen($password) < 6) {
            $errors['password'] = 'Password minimal 6 karakter';
        }

        if (!in_array($role, $allowedRoles)) {
            $errors['role'] = 'Role tidak valid';
        }

        $userModel = $this->model('User');

        if ($username && $userModel->findByUsername($username)) {
            $errors['username'] = 'Username sudah digunakan';
        }

        // ===== JIKA ADA ERROR =====
        if (!empty($errors)) {
            $this->view('auth/register', [
                'errors' => $errors,
                'old' => [
                    'nama' => $nama,
                    'username' => $username,
                    'role' => $role
                ]
            ]);
            return;
        }

        // ===== SIMPAN =====
        $userModel->create([
            'nama' => $nama,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role
        ]);

        $this->redirect('?url=auth/login');
    }

}