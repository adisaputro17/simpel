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
use GuzzleHttp\Client;


class DashboardController extends Controller
{
    
    function getPresensiApel($bulan_awal, $bulan_akhir, $tahun) {
        $username = 'client';
        $password = 'K0m1nf0@ASNDIGITAL113';
        $basicAuth = base64_encode("$username:$password");
        
        $start_date = "{$tahun}-{$bulan_awal}-01";
        $last_day = date('t', strtotime("{$tahun}-{$bulan_akhir}-01"));
        $end_date = "{$tahun}-{$bulan_akhir}-{$last_day}";

        $client = new Client();
        
        $response = $client->request('GET', 'https://asndigital.kedirikota.go.id/webservice/presensi_pegawai',
        [
            'headers' => [
                'Authorization' => 'Basic ' . $basicAuth,
            ],
            'query' => [
                'skpd_id'    => 107,
                'start_date' => $start_date,
                'end_date'   => $end_date,
            ],
        ]);
        
        if ($response->getStatusCode() === 200) {
            $json = json_decode($response->getBody(), true);
            
            if (!empty($json['success']) && !empty($json['data']['data'])) {
                return collect($json['data']['data'])->map(function ($item) {
                    $item['presentase_hadir'] = (float) $item['presentase_hadir'];
                    return $item;
                })->keyBy('nip')->toArray();
            }
            
            return [];
        } else {
            return [];
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bulan_awal  = (int) $request->input('bulan_awal', date('n'));
        $bulan_akhir = (int) $request->input('bulan_akhir', date('n'));
        $tahun       = (int) $request->input('tahun', date('Y'));
        
        $bulan_awal  = sprintf("%02d", $bulan_awal);
        $bulan_akhir = sprintf("%02d", $bulan_akhir);
        $pegawais = Pegawai::where('nip', '!=', '196705061992021003')->orderBy('nip', 'asc')->get();
        $totalPegawai = $pegawais->count() - 1;

        $presensiApel = $this->getPresensiApel($bulan_awal, $bulan_akhir, $tahun);

        $jumlahHariAtribut = PenampilanHarian::whereBetween('bulan', [$bulan_awal, $bulan_akhir])
            ->where('tahun', $tahun)
            ->distinct('tanggal')
            ->count('tanggal');
       
        $data = $pegawais->map(function ($pegawai) use ($bulan_awal, $bulan_akhir, $tahun, $totalPegawai, $presensiApel, $jumlahHariAtribut) {            
            $nilaiAbsensi = 100;
            $nilaiAbsensiBobot = 100 * 0.3;

            $nilaiApel = $presensiApel[$pegawai->nip]['presentase_hadir'] ?? 0;
            $nilaiApelBobot = round($nilaiApel * 0.3, 2);

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
            $nilaiIzinKeluarBobot = round($nilaiIzinKeluar * 0.4, 2);

            $totalNilaiKehadiran = $nilaiAbsensiBobot + $nilaiApelBobot + $nilaiIzinKeluarBobot;
            $totalNilaiKehadiranBobot = round($totalNilaiKehadiran * 0.2, 2);

            $nilaiKinerja = 100;
            $nilaiKinerjaBobot = 100 * 0.2;
   
            $penilaianObjektif = Penilaian::where('nip', $pegawai->nip)
                ->where('jenis', 'objektif')
                ->where('tahun', $tahun)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->pluck('nilai'); 

            $nilaiObjektif = $penilaianObjektif->count() > 0 ? round($penilaianObjektif->avg(), 2) : 0;
            $nilaiObjektifBobot = round($nilaiObjektif * 0.45, 2);

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
            $nilaiTugasTambahanBobot = round($nilaiTugasTambahan * 0.35, 2);

            $totalNilaiKinerja = $nilaiKinerjaBobot + $nilaiObjektifBobot + $nilaiTugasTambahanBobot;
            $totalNilaiKinerjaBobot = round($totalNilaiKinerja * 0.25, 2);
  
            $penilaianKerjaSama = Penilaian::where('nip', $pegawai->nip)
                ->where('jenis', 'kerja_sama')
                ->where('tahun', $tahun)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->pluck('nilai'); 

            $nilaiKerjaSama = $totalPegawai > 0 ? round($penilaianKerjaSama->sum() / $totalPegawai, 2) : 0;
            $nilaiKerjaSamaBobot = round($nilaiKerjaSama * 0.15, 2);

            $penilaianInovasi = Penilaian::where('nip', $pegawai->nip)
                ->where('jenis', 'inovasi')
                ->where('tahun', $tahun)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->pluck('nilai'); 

            $nilaiInovasi = $penilaianInovasi->count() > 0 ? round($penilaianInovasi->avg(), 2) : 0;
            $nilaiInovasiBobot = round($nilaiInovasi * 0.15, 2);

            $atributLengkap = PenampilanHarian::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->pluck('atribut_lengkap');

            $nilaiAtributLengkap = $atributLengkap->count() > 0 ? round($atributLengkap->avg(), 2) : 0;
            $nilaiAtributLengkapBobot = round($nilaiAtributLengkap * 0.25, 2);

            /*$atributLengkap = PenampilanHarian::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->sum('atribut_lengkap');
            
            $nilaiAtributLengkap = $jumlahHariAtribut > 0 ? round($atributLengkap / $jumlahHariAtribut, 2) : 0;
            $nilaiAtributLengkapBobot = round($nilaiAtributLengkap * 0.25, 2);*/

            $seragamSesuaiJadwal = PenampilanHarian::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->pluck('seragam_sesuai_jadwal');

            $nilaiSeragamSesuaiJadwal = $seragamSesuaiJadwal->count() > 0 ? round($seragamSesuaiJadwal->avg(), 2) : 0;
            $nilaiSeragamSesuaiJadwalBobot = round($nilaiSeragamSesuaiJadwal * 0.25, 2);

            /*$seragamSesuaiJadwal = PenampilanHarian::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->sum('seragam_sesuai_jadwal');

            $nilaiSeragamSesuaiJadwal = $jumlahHariAtribut > 0 ? round($seragamSesuaiJadwal / $jumlahHariAtribut, 2) : 0;
            $nilaiSeragamSesuaiJadwalBobot = round($nilaiSeragamSesuaiJadwal * 0.25, 2);*/

            $seragamSesuaiAturan = PenampilanHarian::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->pluck('seragam_sesuai_aturan');

            $nilaiSeragamSesuaiAturan = $seragamSesuaiAturan->count() > 0 ? round($seragamSesuaiAturan->avg(), 2) : 0;
            $nilaiSeragamSesuaiAturanBobot = round($nilaiSeragamSesuaiAturan * 0.25, 2);

            /*$seragamSesuaiAturan = PenampilanHarian::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->sum('seragam_sesuai_aturan');

            $nilaiSeragamSesuaiAturan = $jumlahHariAtribut > 0 ? round($seragamSesuaiAturan / $jumlahHariAtribut, 2) : 0;
            $nilaiSeragamSesuaiAturanBobot = round($nilaiSeragamSesuaiAturan * 0.25, 2);*/

            $rapi = PenampilanHarian::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->pluck('rapi');

            $nilaiRapi = $rapi->count() > 0 ? round($rapi->avg(), 2) : 0;
            $nilaiRapiBobot = round($nilaiRapi * 0.25, 2);

            /*$rapi = PenampilanHarian::where('nip', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->sum('rapi');

            $nilaiRapi = $jumlahHariAtribut > 0 ? round($rapi / $jumlahHariAtribut, 2) : 0;
            $nilaiRapiBobot = round($nilaiRapi * 0.25, 2);*/

            $nilaiPenampilan = $nilaiAtributLengkapBobot + $nilaiSeragamSesuaiJadwalBobot + $nilaiSeragamSesuaiAturanBobot + $nilaiRapiBobot;
            $nilaiPenampilanBobot = round($nilaiPenampilan * 0.10, 2);

            // komplain
            $jumlahKeluhan = Keluhan::where('kepada', $pegawai->nip)
                ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                ->where('tahun', $tahun)
                ->count();
                
            $layanans = Layanan::where('tahun', $tahun)
                ->whereIn('id', function($query) use ($pegawai, $bulan_awal, $bulan_akhir, $tahun) {
                    $query->select('layanan_id')
                        ->from('keluhans')
                        ->where('kepada', $pegawai->nip)
                        ->whereBetween('bulan', [$bulan_awal, $bulan_akhir])
                        ->where('tahun', $tahun)
                        ->distinct();
                })->get();

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
                $nilaiKomplain = round(100 - ($jumlahKeluhan / $totalLayanan) * 100, 2);
            }
            $nilaiKomplainBobot = round($nilaiKomplain * 0.15, 2);

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
        })->sortByDesc('total_nilai')->values();

        return view('dashboard.index', compact('data'));
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
