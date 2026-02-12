<?php
class DashboardController extends Controller
{

    public function __construct()
    {
        $this->requireLogin();

    }

    public function index()
    {
        $parkir = $this->model('Parkir');
        $user = $this->model('User');
        $area = $this->model('Area');

        $dataChart = $parkir->grafikHarian();

        $data = [
            'totalKendaraan' => $parkir->countAktif(),
            'totalUser' => $user->countAll(),
            'hariIni' => $parkir->countHariIni(),
            'hariIniOut' => $parkir->countHariIniOut(),
            'totalArea' => $area->countArea()
        ];

        $data['chartData'] = json_encode($dataChart);

        $role = $_SESSION['user']['role'];

        switch ($role) {
            case 'admin':
                $this->view('dashboard/admin/index', $data, ['title' => 'Dashboard Admin']);
                break;

            case 'petugas':
                $this->view('dashboard/petugas/index', $data, [
                    'title' => 'Dashboard Petugas'
                ]);
                break;

            case 'owner':
                $this->view('dashboard/owner/index', $data, ['title' => 'Dashboard Owner']);
                break;

            default:
                $this->view('errors/403');
        }
    }
}