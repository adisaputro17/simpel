<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($jenis)
    {
        $user = Auth::guard('pegawai')->user();
        $query = Penilaian::where('jenis', $jenis);

        if ($jenis === 'kerja_sama') {
            $query->where('dari', $user->nip);
        } elseif (in_array($jenis, ['objektif', 'inovasi'])) {
            $bawahan = $user->bawahan->pluck('nip');
            $query->whereIn('nip', $bawahan);
        }

        $data = $query->get();
        return view("penilaian.$jenis.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($jenis)
    {
        $user = Auth::guard('pegawai')->user();
        if ($jenis === 'kerja_sama') {
            $pegawai = Pegawai::where('nip', '!=', $user->nip)->get();
        } else {
            $pegawai = $user->bawahan;
        }

        return view("penilaian.$jenis.create", compact('pegawai', 'jenis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $jenis)
    {
        $request->validate([
            'nip' => 'required|exists:pegawais,nip|different:dari',
            'nilai' => 'required|in:25,50,75,100',
            'bulan' => 'required',
            'tahun' => 'required',
        ]);

        // Cek apakah data sudah ada
        $query = Penilaian::where([
            'nip' => $request->nip,
            'jenis' => $jenis,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ]);
        
        if ($jenis === 'kerja_sama') {
            $query->where('dari', auth('pegawai')->user()->nip);
        }
        
        $exists = $query->exists();
        
        if ($exists) {
        return redirect()->route("penilaian.index", $jenis)->with('error', 'Penilaian untuk pegawai ini pada bulan dan tahun tersebut sudah ada.');
        }

        Penilaian::create([
            'jenis' => $jenis,
            'nip' => $request->nip,
            'dari' => $jenis === 'kerja_sama' ? Auth::guard('pegawai')->user()->nip : null,
            'nilai' => $request->nilai,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route("penilaian.index", $jenis)->with('success', 'Penilaian disimpan.');
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
    public function edit($jenis, $id)
    {
        $item = Penilaian::where('jenis', $jenis)->findOrFail($id);
        $user = Auth::guard('pegawai')->user();

        if ($jenis === 'kerja_sama') {
            $pegawai = Pegawai::where('nip', '!=', $user->nip)->get();
        } else {
            $pegawai = $user->bawahan;
        }

        return view("penilaian.$jenis.edit", compact('item', 'pegawai', 'jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $jenis, $id)
    {
        $item = Penilaian::where('jenis', $jenis)->findOrFail($id);

        $request->validate([
            'nip' => 'required|exists:pegawais,nip|different:dari',
            'nilai' => 'required|in:25,50,75,100',
            'bulan' => 'required',
            'tahun' => 'required',
        ]);

        // Cek apakah data sudah ada
        $query = Penilaian::where([
            'nip' => $request->nip,
            'jenis' => $jenis,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
        ]);
        
        if ($jenis === 'kerja_sama') {
            $query->where('dari', auth('pegawai')->user()->nip);
        }
        
        $exists = $query->exists();
        
        if ($exists) {
        return redirect()->route("penilaian.index", $jenis)->with('error', 'Penilaian untuk pegawai ini pada bulan dan tahun tersebut sudah ada.');
        }


        $item->update([
            'nip' => $request->nip,
            'dari' => $jenis === 'kerja_sama' ? Auth::guard('pegawai')->user()->nip : null,
            'nilai' => $request->nilai,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route("penilaian.index", $jenis)->with('success', 'Penilaian diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($jenis, $id)
    {
        $item = Penilaian::where('jenis', $jenis)->findOrFail($id);
        $item->delete();

        return redirect()->route("penilaian.index", $jenis)->with('success', 'Penilaian dihapus.');
    }
}
