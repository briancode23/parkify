<?php
class PetugasController extends Controller {

    public function dashboard() {
        $this->role(['petugas']);
        $this->view('petugas/dashboard');
    }
}
