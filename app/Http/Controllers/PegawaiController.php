<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $pegawais = Pegawai::with('atasan')->get();
        return view('pegawai.index', compact('pegawais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $atasans = Pegawai::all();
        return view('pegawai.create', compact('atasans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:pegawais,nip',
            'nama' => 'required',
            'password' => 'required|min:6',
        ]);

        Pegawai::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'password' => bcrypt($request->password),
            'atasan_id' => $request->atasan_id,
            'role' => 'pegawai',
        ]);

        return redirect()->route('pegawai.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $nip)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $nip)
    {
        $pegawai = Pegawai::findOrFail($nip);
        $atasans = Pegawai::where('nip', '!=', $nip)->get();
        return view('pegawai.edit', compact('pegawai', 'atasans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $nip)
    {
        $pegawai = Pegawai::findOrFail($nip);

        $request->validate([
            'nama' => 'required',
        ]);

        $pegawai->nama = $request->nama;
        $pegawai->atasan_id = $request->atasan_id;
        if ($request->filled('password')) {
            $pegawai->password = bcrypt($request->password);
        }
        $pegawai->save();

        return redirect()->route('pegawai.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $nip)
    {
        Pegawai::findOrFail($nip)->delete();
        return redirect()->route('pegawai.index');
    }
}
