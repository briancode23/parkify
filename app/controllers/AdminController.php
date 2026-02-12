<?php
class AdminController extends Controller {
    public function __construct() {
        $this->requireRole('admin');
    }

    public function index() {
        $this->view('admin/index');
    }

    public function dashboard() {
        $this->role(['admin']);
        $this->view('dashboard/admin');
    }
}