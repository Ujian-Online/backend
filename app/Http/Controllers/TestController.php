<?php

namespace App\Http\Controllers;

use App\AsesiSertifikasiUnitKompetensiElement;
use App\SertifikasiUnitKompentensi;
use App\UjianAsesiAsesor;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $ujianasesis = UjianAsesiAsesor::where('status', 'paket_soal_assigned')
            ->get();

        foreach($ujianasesis as $ujianasesi) {

        }
    }
}
