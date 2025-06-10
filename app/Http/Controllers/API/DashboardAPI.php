<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KotaModel;
use App\Models\SiswaModel;
use Illuminate\Support\Facades\DB;

class DashboardAPI extends Controller
{
    public function index() {
        $siswaKota = KotaModel::select('nama_kota')->whereHas('siswa')->withCount('siswa as value')->get();
        $siswaGender = SiswaModel::select('gender', DB::raw('COUNT(id_siswa) as total'))->groupBy('gender')->get();
        $siswaTahun = SiswaModel::select(DB::raw('COUNT(id_siswa) as total, YEAR(tgl_lagir) as tahun'))
        ->groupBy('tahun')
        ->orderBy('tahun')
        ->get();

        $genderChart = [
            'label' => [],
            'data' => []
        ];
        foreach($siswaGender as $gender) {
            $namaGender = $gender['gender'] === 'L' ? 'Laki-laki': 'Perempuan';
            array_push($genderChart['label'], $namaGender);
            array_push($genderChart['data'], $gender['total']);
        }

        $kotaChart = [
            'label' => [],
            'data' => []
        ];
        foreach($siswaKota as $kota) {
            $namaKota = $kota['nama_kota'];
            array_push($kotaChart['label'], $namaKota);
            array_push($kotaChart['data'], $kota['value']);
        }

        $tahunChart = [
            'label' => [],
            'data' => []
        ];
        foreach($siswaTahun as $tahun) {
            $siswaTahun = $tahun['YEAR(tgl_lahir)'];
            array_push($tahunChart['label'], $tahun['tahun']);
            array_push($tahunChart['label'], $tahun['total']);
        }

        return $this->responseSuccess([
            'siswaKota' => $kotaChart,
            'siswaGender' => $genderChart,
            'siswaTahun' => $tahunChart,
        ]);
    }
}
