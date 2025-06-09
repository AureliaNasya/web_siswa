<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminModel;
use App\Models\KotaModel;
use App\Models\SiswaModel;
use Illuminate\Support\Facades\DB;

class DashboardAPI extends Controller
{
    public function index() {
        $siswaKota = KotaModel::select('nama_kota')->whereHas('siswa')->withCount('siswa as value')->get(['nama']);
        $siswaGender = SiswaModel::select('gender', DB::raw('COUNT(id_siswa) as total'))->groupBy('gender')->get();
        $siswaTahun = SiswaModel::selece(DB::raw('COUNT(id_siswa) as total, YEAR(tgl_lagir) as tahun'))
        ->groupBy(DB::raw('YEAR(tgl_lahir)'))
        ->orderBy(DB::raw('YEAR(tgl_lahir)'))
        ->get();

        $arrayGender = [
            'label' => [],
            'data' => []
        ];
        $arrayKota = [
            'label' => [],
            'data' => []
        ];
        $arrayTahunLahir = [
            'label' => [],
            'data' => []
        ];

        foreach($siswaGender as $gender) {
            $namaGender = $gender['gender'] === 'L' ? 'Laki-laki': 'Perempuan';
            array_push($arrayGender['label'], $namaGender);
            array_push($arrayGender['data'], $gender['total']);
        }
        foreach($siswaKota as $kota) {
            $namaKota = $kota['nama_kota'];
            array_push($arrayKota['label'], $namaKota);
            array_push($arrayKota['data'], $kota['value']);
        }
        foreach($siswaTahun as $tahun) {
            array_push($arrayTahunLahir['label'], $tahun['tahun']);
            array_push($arrayTahunLahir['label'], $tahun['total']);
        }

        return $this->responseSuccess([
            'siswaKota' => $arrayKota,
            'siswaGender' => [
                'label' => $arrayGender['label'],
                'data' => $arrayGender['data']
            ],
            'siswaTahun' => $arrayTahunLahir
        ]);
    }
}
