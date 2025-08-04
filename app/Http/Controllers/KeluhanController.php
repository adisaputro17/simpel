<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use App\Models\Layanan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class KeluhanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Keluhan::with('layanan', 'dariPegawai', 'kepadaPegawai')->latest()->get();
        // return response()->json($data);

        return view('keluhan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $layanans = Layanan::all();
        $pegawais = Pegawai::all();
        return view('keluhan.create', compact('layanans', 'pegawais'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tanggal' => 'required|date',
            'bulan' => 'required|string',
            'tahun' => 'required|string',
            'jenis_layanan' => 'required|in:internal,eksternal',
            'layanan_id' => 'required|exists:layanans,id',
            'dari' => 'nullable|exists:pegawais,nip',
            'sumber' => 'nullable|string',
            'kepada' => 'required|exists:pegawais,nip',
            'jenis_permasalahan' => 'required|in:internal,eksternal',
            'deskripsi' => 'required|string',
        ]);
        Keluhan::create($data);
        return redirect()->route('keluhan.index')->with('success', 'Keluhan berhasil ditambahkan');
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
        $item = Keluhan::findOrFail($id);
        $layanans = Layanan::all();
        $pegawais = Pegawai::all();
        return view('keluhan.create', compact('item', 'layanans', 'pegawais'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Keluhan::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('keluhan.index')->with('success', 'Data keluhan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Keluhan::findOrFail($id)->delete();
        return redirect()->route('keluhan.index')->with('success', 'Data keluhan berhasil dihapus.');
    }
}
