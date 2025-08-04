<?php

namespace App\Http\Controllers;

use App\Models\IzinKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IzinKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard('pegawai')->user();

        // Jika atasan, tampilkan bawahannya
        if ($user->bawahan()->exists()) {
            $izinKeluar = IzinKeluar::whereIn('nip', $user->bawahan->pluck('nip'))->get();
        } else {
            $izinKeluar = IzinKeluar::where('nip', $user->nip)->get();
        }

        return view('izin_keluar.index', compact('izinKeluar'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::guard('pegawai')->user();
        $bawahan = $user->bawahan()->get();
        return view('izin_keluar.create', compact('bawahan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|exists:pegawais,nip',
            'tanggal' => 'required|date',
            'jam_keluar' => 'required',
            'jam_kembali' => 'required',
            'keterangan' => 'required'
        ]);

        IzinKeluar::create([
            'nip' => $request->nip,
            'tanggal' => $request->tanggal,
            'bulan' => date('m', strtotime($request->tanggal)),
            'tahun' => date('Y', strtotime($request->tanggal)),
            'jam_keluar' => $request->jam_keluar,
            'jam_kembali' => $request->jam_kembali,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('izin_keluar.index')->with('success', 'Data berhasil ditambahkan.');
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
        $izinKeluar = IzinKeluar::findOrFail($id);
        $user = Auth::guard('pegawai')->user();
        $bawahan = $user->bawahan()->get();
        
        return view('izin_keluar.edit', compact('izinKeluar', 'bawahan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $izinKeluar = IzinKeluar::findOrFail($id);
        
        $request->validate([
            'nip' => 'required|exists:pegawais,nip',
            'tanggal' => 'required|date',
            'jam_keluar' => 'required',
            'jam_kembali' => 'required',
            'keterangan' => 'required',
        ]);
        
        $izinKeluar->update([
            'nip' => $request->nip,
            'tanggal' => $request->tanggal,
            'bulan' => date('m', strtotime($request->tanggal)),
            'tahun' => date('Y', strtotime($request->tanggal)),
            'jam_keluar' => $request->jam_keluar,
            'jam_kembali' => $request->jam_kembali,
            'keterangan' => $request->keterangan,
        ]);
        
        return redirect()->route('izin_keluar.index')->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $izinKeluar = IzinKeluar::findOrFail($id);
        $izinKeluar->delete();
        
        return redirect()->route('izin_keluar.index')->with('success', 'Data berhasil dihapus.');
    }
}
