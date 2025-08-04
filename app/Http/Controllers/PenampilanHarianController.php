<?php

namespace App\Http\Controllers;

use App\Models\PenampilanHarian;
use Illuminate\Http\Request;

class PenampilanHarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = PenampilanHarian::with('pegawai')->orderBy('tanggal', 'desc')->get();;
        return view('penampilan_harian.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pegawai = auth('pegawai')->user()->bawahan ?? collect();
        return view('penampilan_harian.create', compact('pegawai'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
            'tanggal' => 'required|date',
        ]);

        $tanggal = $request->tanggal;
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $penilaian = $request->penilaian ?? [];

        $validAtribut = [0, 25, 50, 75, 100];
        $validBiner = [0, 100];

        foreach ($penilaian as $nip => $data) {
            if (
                !in_array((int) $data['atribut_lengkap'], $validAtribut) ||
                !in_array((int) $data['seragam_sesuai_jadwal'], $validBiner) ||
                !in_array((int) $data['seragam_sesuai_aturan'], $validBiner) ||
                !in_array((int) $data['rapi'], $validBiner)
            ) {
                return redirect()->back()->with('error', "Nilai tidak valid untuk $nip");
            }

            PenampilanHarian::updateOrCreate(
                ['nip' => $nip, 'tanggal' => $tanggal],
                [
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'atribut_lengkap' => $data['atribut_lengkap'],
                    'seragam_sesuai_jadwal' => $data['seragam_sesuai_jadwal'],
                    'seragam_sesuai_aturan' => $data['seragam_sesuai_aturan'],
                    'rapi' => $data['rapi'],
                    'keterangan' => $data['keterangan'] ?? null,
                ]
            );
        }

        return redirect()->route('penampilan.index')->with('success', 'Penilaian berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
