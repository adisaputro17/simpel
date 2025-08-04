<?php

namespace App\Http\Controllers;

use App\Models\TugasTambahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasTambahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('pegawai')->user();

        if ($user->bawahan()->exists()) {
            $data = TugasTambahan::whereIn('nip', $user->bawahan->pluck('nip'))->get();
        } else {
            $data = TugasTambahan::where('nip', $user->nip)->get();
        }

        return view('tugas_tambahan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::guard('pegawai')->user();
        $bawahan = $user->bawahan;
        return view('tugas_tambahan.create', compact('bawahan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|exists:pegawais,nip',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'keterangan' => 'required'
        ]);

        TugasTambahan::create([
            'nip' => $request->nip,
            'tanggal' => $request->tanggal,
            'bulan' => date('m', strtotime($request->tanggal)),
            'tahun' => date('Y', strtotime($request->tanggal)),
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('tugas_tambahan.index')->with('success', 'Data berhasil ditambahkan.');
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
        $item = TugasTambahan::findOrFail($id);
        $bawahan = Auth::guard('pegawai')->user()->bawahan;
        return view('tugas_tambahan.edit', compact('item', 'bawahan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = TugasTambahan::findOrFail($id);

        $request->validate([
            'nip' => 'required|exists:pegawais,nip',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'keterangan' => 'required'
        ]);

        $item->update([
            'nip' => $request->nip,
            'tanggal' => $request->tanggal,
            'bulan' => date('m', strtotime($request->tanggal)),
            'tahun' => date('Y', strtotime($request->tanggal)),
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('tugas_tambahan.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = TugasTambahan::findOrFail($id);
        $item->delete();

        return redirect()->route('tugas_tambahan.index')->with('success', 'Data berhasil dihapus.');
    }
}
