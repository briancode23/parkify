<?php
class AreaController extends Controller {
    
    public function __construct() {
        $this->requireRole(['admin']);
    }
    
    public function store() {
        $areaModel = $this->model('Area');
        $data = $_POST;
        $userId = $_SESSION['user']['id'] ?? null;
        if ($areaModel->tambahArea($data)) {
            $this->logActivity($userId, "Menambahkan area parkir: " . $data['nama_area']);
            $this->redirect('?url=area/index');
        } else {
            // handle error
        }
    }

    public function update($id) {
        $areaModel = $this->model('Area');
        $data = $_POST;
        $userId = $_SESSION['user']['id'] ?? null;
        if ($areaModel->editArea($id, $data)) {
            $this->logActivity($userId, "Mengubah area parkir ID $id");
            $this->redirect('?url=area/index');
        } else {
            // handle error
        }
    }

    public function delete($id) {
        $areaModel = $this->model('Area');
        $areaModel->delete($id);
        $userId = $_SESSION['user']['id'] ?? null;
        $this->logActivity($userId, "Menghapus area parkir ID $id");

        $this->redirect('?url=area/index');
    }


    /*public function __construct {
        $this->auth(['$user']['admin');
    }*/

}