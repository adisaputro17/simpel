<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;
use App\Models\IzinKeluar;
use Carbon\Carbon;
use App\Models\Penilaian;
use App\Models\TugasTambahan;
use App\Models\PenampilanHarian;
use App\Models\Layanan;
use App\Models\Keluhan;
use Illuminate\Support\Facades\Auth;



class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    
        $nip = Auth::check() ? Auth::user()->nip : null;
        $totalPegawai = Pegawai::where('atasan_id', $nip)->count(); 

        $totalTugas = TugasTambahan::where('nip', $nip)->count();

        $totalIzin  = IzinKeluar::where('nip', $nip)->count();
  

        $bulan_awal = sprintf("%02d", $request->input('bulan_awal'));
        $bulan_akhir = sprintf("%02d", $request->input('bulan_akhir'));
        $tahun = $request->input('tahun');
        $pegawais = Pegawai::all();

       
        $data = $pegawais->map(function ($pegawai) use ($bulan_awal, $bulan_akhir, $tahun) {

     
            $nilaiAbsensi = 100;
            $nilaiAbsensiBobot = 100 * 0.3;

     
            $nilaiApel = 100;
            $nilaiApelBobot = 100 * 0.3;

       
            $izin = IzinKeluar::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->get();

            
            $totalJam = $izin->sum(function ($item) {
                $keluar = Carbon::parse($item->jam_keluar);
                $kembali = Carbon::parse($item->jam_kembali);
                return $keluar->diffInMinutes($kembali) / 60; // hasil jam
            });
            $nilaiIzinKeluar = max(0, round(((150 - $totalJam) / 150) * 100, 2));
            $nilaiIzinKeluarBobot = $nilaiIzinKeluar * 0.4;

            $totalNilaiKehadiran = $nilaiAbsensiBobot + $nilaiApelBobot + $nilaiIzinKeluarBobot;
            $totalNilaiKehadiranBobot = $totalNilaiKehadiran * 0.2;

          
            $nilaiKinerja = 100;
            $nilaiKinerjaBobot = 100 * 0.2;

   
            $penilaianObjektif = Penilaian::where('nip', $pegawai->nip)
                ->where('jenis', 'objektif')
                ->where('tahun', $tahun)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->pluck('nilai'); 

            $nilaiObjektif = $penilaianObjektif->count() > 0 
                ? round($penilaianObjektif->avg(), 2)
                : 0;
            $nilaiObjektifBobot = $nilaiObjektif * 0.45;


    
            $tugasTambahan = TugasTambahan::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->get();

          
            $totalJam = $tugasTambahan->sum(function ($item) {
                $mulai = Carbon::parse($item->jam_mulai);
                $selesai = Carbon::parse($item->jam_selesai);
                return $mulai->diffInMinutes($selesai) / 60; // hasil jam
            });
            $nilaiTugasTambahan = max(0, round(($totalJam / 150) * 100, 2));
            $nilaiTugasTambahanBobot = $nilaiTugasTambahan * 0.35;

            $totalNilaiKinerja = $nilaiKinerjaBobot + $nilaiObjektifBobot + $nilaiTugasTambahanBobot;
            $totalNilaiKinerjaBobot = $totalNilaiKinerja * 0.25;


  
            $penilaianKerjaSama = Penilaian::where('nip', $pegawai->nip)
                ->where('jenis', 'kerja_sama')
                ->where('tahun', $tahun)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->pluck('nilai'); 

            $nilaiKerjaSama = $penilaianKerjaSama->count() > 0 
                ? round($penilaianKerjaSama->avg(), 2)
                : 0;
            $nilaiKerjaSamaBobot = $nilaiKerjaSama * 0.15;


     
            $penilaianInovasi = Penilaian::where('nip', $pegawai->nip)
                ->where('jenis', 'inovasi')
                ->where('tahun', $tahun)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->pluck('nilai'); 

            $nilaiInovasi = $penilaianInovasi->count() > 0 
                ? round($penilaianInovasi->avg(), 2)
                : 0;
            $nilaiInovasiBobot = $nilaiInovasi * 0.15;

       
            $atributLengkap = PenampilanHarian::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->pluck('atribut_lengkap');
            
            $nilaiAtributLengkap = $atributLengkap->count() > 0 
                ? round($atributLengkap->avg(), 2)
                : 0;
            $nilaiAtributLengkapBobot = $nilaiAtributLengkap * 0.25;

            $seragamSesuaiJadwal = PenampilanHarian::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->pluck('seragam_sesuai_jadwal');

            $nilaiSeragamSesuaiJadwal = $seragamSesuaiJadwal->count() > 0 
                ? round($seragamSesuaiJadwal->avg(), 2)
                : 0;
            $nilaiSeragamSesuaiJadwalBobot = $nilaiSeragamSesuaiJadwal * 0.25;

            $seragamSesuaiAturan = PenampilanHarian::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->pluck('seragam_sesuai_aturan');

            $nilaiSeragamSesuaiAturan = $seragamSesuaiAturan->count() > 0 
                ? round($seragamSesuaiAturan->avg(), 2)
                : 0;
            $nilaiSeragamSesuaiAturanBobot = $nilaiSeragamSesuaiAturan * 0.25;

            $rapi = PenampilanHarian::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->pluck('rapi');

            $nilaiRapi = $rapi->count() > 0 
                ? round($rapi->avg(), 2)
                : 0;
            $nilaiRapiBobot = $nilaiRapi * 0.25;

            $nilaiPenampilan = $nilaiAtributLengkapBobot + $nilaiSeragamSesuaiJadwalBobot + $nilaiSeragamSesuaiAturanBobot + $nilaiRapiBobot;
            $nilaiPenampilanBobot = $nilaiPenampilan * 0.10;

            // komplain
            $jumlahKeluhan = Keluhan::where('kepada', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->count();

            $layanans = Layanan::where('tahun', $tahun)->get();

            $totalLayanan = 0;
            for ($bulan = $bulan_awal; $bulan <= $bulan_akhir; $bulan++) {
                $kolom = 'bulan_' . str_pad($bulan, 2, '0', STR_PAD_LEFT);
                foreach ($layanans as $layanan) {
                    $totalLayanan += (int) $layanan->$kolom;
                }
            }

 
            if ($totalLayanan === 0) {
                $nilaiKomplain = 100;
            } else {
                $nilaiKomplain = 100 -($jumlahKeluhan / $totalLayanan) * 100;
            }
            $nilaiKomplainBobot = $nilaiKomplain * 0.15;

            // total nilai
            $totalNilai = $totalNilaiKehadiranBobot + $totalNilaiKinerjaBobot + $nilaiKerjaSamaBobot + $nilaiInovasiBobot + $nilaiPenampilanBobot + $nilaiKomplainBobot;

            return [
                'nip' => $pegawai->nip,
                'nama' => $pegawai->nama,
                'nilai_absensi' => $nilaiAbsensi,
                'nilai_absensi_bobot' => $nilaiAbsensiBobot,
                'nilai_apel' => $nilaiApel,
                'nilai_apel_bobot' => $nilaiApelBobot,
                'nilai_izin_keluar' => $nilaiIzinKeluar,
                'nilai_izin_keluar_bobot' => $nilaiIzinKeluarBobot,
                'total_nilai_kehadiran' => $totalNilaiKehadiran,
                'total_nilai_kehadiran_bobot' => $totalNilaiKehadiranBobot,
                'nilai_kinerja' => $nilaiKinerja,
                'nilai_kinerja_bobot' => $nilaiKinerjaBobot,
                'nilai_objektif' => $nilaiObjektif,
                'nilai_objektif_bobot' => $nilaiObjektifBobot,
                'nilai_tugas_tambahan' => $nilaiTugasTambahan,
                'nilai_tugas_tambahan_bobot' => $nilaiTugasTambahanBobot,
                'total_nilai_kinerja' => $totalNilaiKinerja,
                'total_nilai_kinerja_bobot' => $totalNilaiKinerjaBobot,
                'nilai_kerja_sama' => $nilaiKerjaSama,
                'nilai_kerja_sama_bobot' => $nilaiKerjaSamaBobot,
                'nilai_inovasi' => $nilaiInovasi,
                'nilai_inovasi_bobot' => $nilaiInovasiBobot,
                'nilai_atribut_lengkap' => $nilaiAtributLengkap,
                'nilai_atribut_lengkap_bobot' => $nilaiAtributLengkapBobot,
                'nilai_seragam_sesuai_jadwal' => $nilaiSeragamSesuaiJadwal,
                'nilai_seragam_sesuai_jadwal_bobot' => $nilaiSeragamSesuaiJadwalBobot,
                'nilai_seragam_sesuai_aturan' => $nilaiSeragamSesuaiAturan,
                'nilai_seragam_sesuai_aturan_bobot' => $nilaiSeragamSesuaiAturanBobot,
                'nilai_rapi' => $nilaiRapi,
                'nilai_rapi_bobot' => $nilaiRapiBobot,
                'nilai_penampilan' => $nilaiPenampilan,
                'nilai_penampilan_bobot' => $nilaiPenampilanBobot,
                'jumlah_keluhan' => $jumlahKeluhan,
                'total_layanan' => $totalLayanan,
                'nilai_komplain' => $nilaiKomplain,
                'nilai_komplain_bobot' => $nilaiKomplainBobot,
                'total_nilai' => $totalNilai,
            ];
        });



        return view('dashboard.index', compact('data', 'bulan_awal', 'bulan_akhir', 'tahun', 'totalPegawai','totalTugas','totalIzin'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
