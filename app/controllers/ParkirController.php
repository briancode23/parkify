<?php

class ParkirController extends Controller {

    public function __construct() {
        $this->requireRole(['admin', 'petugas']);
    }
    
    public function struk($id) {
        $parkirModel = $this->model('Parkir');
        $data = $parkirModel->getById($id);

        if (!$data) {
            $this->view('errors/404');
            return;
        }

        require_once '/app/libraries/fpdf/fpdf.php';

        $pdf = new FPDF('P', 'mm', [80, 200]);
        $pdf->AddPage();
        
        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,8,'STRUK PARKIR',0,1,'C');
        $pdf->Ln(3);

        $pdf->SetFont('Arial','',9);
        $pdf->Cell(0,5,'No Parkir : '.$data['id_parkir'],0,1);
        $pdf->Cell(0,5,'Plat      : '.$data['plat_nomor'],0,1);
        $pdf->Cell(0,5,'Jenis     : '.$data['jenis_kendaraan'],0,1);
        $pdf->Cell(0,5,'Area      : '.$data['nama_area'],0,1);

        $pdf->Ln(2);
        $pdf->Cell(0,5,'Masuk     : '.$data['waktu_masuk'],0,1);
        $pdf->Cell(0,5,'Keluar    : '.$data['waktu_keluar'],0,1);
        $pdf->Cell(0,5,'Durasi    : '.$data['durasi_jam'].' jam',0,1);

        $pdf->Ln(2);
        $pdf->Cell(0,5,'Tarif/Jam : Rp '.number_format($data['tarif_per_jam']),0,1);
        $pdf->Cell(0,5,'Total    : Rp '.number_format($data['biaya_total']),0,1);

        $pdf->Ln(3);
        $pdf->Cell(0,5,'Petugas  : '.$data['nama_lengkap'],0,1);
        $pdf->Ln(5);

        $pdf->Cell(0,5,'Terima kasih',0,1,'C');
        
        $pdf->Output('I', 'struk-parkir-'.$id.'.pdf');
        
        $this->logActivity($_SESSION['user']['id'], 'Cetak struk parkir ID '.$id);
        exit;
    }
    
    public function strukMasuk($id) {
        $parkir = $this->model('Parkir')->getMasukById($id);

        if (!$parkir) {
            $this->view('errors/404');
            return;
        }

        require_once '../app/libraries/fpdf/fpdf.php';

        $pdf = new FPDF('P','mm',[80,180]);
        $pdf->AddPage();

        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,8,'STRUK PARKIR MASUK',0,1,'C');
        $pdf->Ln(3);

        $pdf->SetFont('Arial','',9);
        $pdf->Cell(0,5,'No Parkir : '.$parkir['id_parkir'],0,1);
        $pdf->Cell(0,5,'Plat      : '.$parkir['plat_nomor'],0,1);
        $pdf->Cell(0,5,'Jenis     : '.$parkir['jenis_kendaraan'],0,1);
        $pdf->Cell(0,5,'Area      : '.$parkir['nama_area'],0,1);

        $pdf->Ln(2);
        $pdf->Cell(0,5,'Masuk     : '.$parkir['waktu_masuk'],0,1);
        $pdf->Cell(0,5,'Petugas   : '.$parkir['nama_lengkap'],0,1);

        $pdf->Ln(5);
        $pdf->Cell(0,5,'Simpan struk ini',0,1,'C');

        $this->logActivity($_SESSION['user']['id'], 'Cetak struk masuk ID '.$id);

        $pdf->Output('I','struk-masuk-'.$id.'.pdf');
        exit;
    }
    
    public function strukKeluar($id) {
        $parkir = $this->model('Parkir')->getKeluarById($id);

        if (!$parkir) {
            $this->view('errors/404');
            return;
        }

        require_once '../app/libraries/fpdf/fpdf.php';

        $pdf = new FPDF('P','mm',[80,200]);
        $pdf->AddPage();

        $pdf->SetFont('Arial','B',12);
        $pdf->Cell(0,8,'STRUK PARKIR KELUAR',0,1,'C');
        $pdf->Ln(3);

        $pdf->SetFont('Arial','',9);
        $pdf->Cell(0,5,'No Parkir : '.$parkir['id_parkir'],0,1);
        $pdf->Cell(0,5,'Plat      : '.$parkir['plat_nomor'],0,1);
        $pdf->Cell(0,5,'Jenis     : '.$parkir['jenis_kendaraan'],0,1);

        $pdf->Ln(2);
        $pdf->Cell(0,5,'Masuk     : '.$parkir['waktu_masuk'],0,1);
        $pdf->Cell(0,5,'Keluar    : '.$parkir['waktu_keluar'],0,1);
        $pdf->Cell(0,5,'Durasi    : '.$parkir['durasi_jam'].' jam',0,1);

        $pdf->Ln(2);
        $pdf->Cell(0,5,'Tarif/Jam : Rp '.number_format($parkir['tarif_per_jam']),0,1);
        $pdf->Cell(0,5,'Total    : Rp '.number_format($parkir['biaya_total']),0,1);

        $pdf->Ln(3);
        $pdf->Cell(0,5,'Petugas  : '.$parkir['nama_lengkap'],0,1);

        $this->logActivity($_SESSION['user']['id'], 'Cetak struk keluar ID '.$id);

        $pdf->Output('I','struk-keluar-'.$id.'.pdf');
        exit;
    }

    // LIST PARKIR AKTIF
    public function index() {
        $parkir = $this->model('Parkir')->getAktif();

        $this->view('parkir/index', [
            'title' => 'Parkir Aktif',
            'parkir' => $parkir
        ]);
    }

    // FORM MASUK
    public function masuk() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $this->model('Parkir')->kendaraanMasuk([
                'id_kendaraan' => $_POST['id_kendaraan'],
                'id_tarif'     => $_POST['id_tarif'],
                'id_user'      => $_SESSION['user']['id'],
                'id_area'      => $_POST['id_area']
            ]);

            $this->logActivity("Kendaraan masuk ID kendaraan " . $_POST['id_kendaraan']);

            $this->redirect('?url=parkir/index');
        }

        $this->view('parkir/masuk', ['title' => 'Kendaraan Masuk']);
    }

    // PROSES KELUAR
    public function keluar($id) {
    $parkirModel = $this->model('Parkir');

    $data = $parkirModel->getKeluarById($id);

    $masuk = strtotime($data['waktu_masuk']);
    $keluar = time();

    $durasiJam = ceil(($keluar - $masuk) / 3600);
    $total = $durasiJam * $data['tarif_per_jam'];

    $parkirModel->updateKeluar(
        $id,
        date('Y-m-d H:i:s', $keluar),
        $durasiJam,
        $total
    );

    $this->logActivity($_SESSION['user']['id'], 'Parkir keluar ID '.$id);

    $this->redirect('?url=parkir/strukKeluar/'.$id);
}

    
    public function tambah() {
        $this->auth(['admin','petugas']);
        echo "Form tambah parkir";
    }

    public function laporan() {
        $this->auth(['admin','owner']);
        echo "Laporan parkir";
    }
}
