<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\Kata;
use App\Models\Kategori;
use App\Models\RiwayatKuis;
use App\Models\SoalKuis;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengunjungController extends Controller
{
    /**
     * Tampilkan beranda khusus pengunjung yang sudah login.
     */
    public function index(): View
    {
        $kataPopuler = Kata::populer()
            ->with('kategori')
            ->orderBy('kata_wemale')
            ->get();

        $kategoriList = Kategori::withCount('katas')
            ->orderBy('nama_kategori')
            ->get();

        $totalKata = Kata::count();
        $totalKategori = Kategori::count();

        // Kata hari ini (pilih kata populer atau kata pertama sebagai sorotan)
        $kataHariIni = Kata::with('kategori')
            ->where('is_populer', true)
            ->inRandomOrder()
            ->first() ?? Kata::with('kategori')->first();

        // Seluruh kamus untuk pencarian cepat dan modal interaktif
        $kamusData = Kata::with('kategori')
            ->get()
            ->mapWithKeys(fn (Kata $kata) => [
                $kata->kata_wemale => [
                    'word' => $kata->kata_wemale,
                    'meaning' => $kata->arti_indonesia,
                    'category' => $kata->kategori?->nama_kategori ?? 'Umum',
                    'example' => $kata->contoh ?? '',
                    'exampleTrans' => $kata->terjemahan_contoh ?? '',
                    'is_populer' => (bool) $kata->is_populer,
                ],
            ])
            ->toArray();

        return view('pengunjung.beranda-pengunjung', [
            'user' => Auth::user(),
            'kataPopuler' => $kataPopuler,
            'kategoriList' => $kategoriList,
            'totalKata' => $totalKata,
            'totalKategori' => $totalKategori,
            'kataHariIni' => $kataHariIni,
            'kamusData' => $kamusData,
        ]);
    }

    /**
     * Tampilkan halaman pengerjaan kuis bahasa Wemale untuk pengunjung.
     */
    public function halamanKuis(): View
    {
        $soalKuis = SoalKuis::where('is_aktif', true)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $riwayatKuis = RiwayatKuis::where('user_id', Auth::id())
            ->latest()
            ->limit(10)
            ->get();

        $totalKuisDikerjakan = RiwayatKuis::where('user_id', Auth::id())->count();
        $skorTertinggi = RiwayatKuis::where('user_id', Auth::id())->max('skor') ?? 0;

        return view('pengunjung.kuis', [
            'soalKuis' => $soalKuis,
            'riwayatKuis' => $riwayatKuis,
            'totalKuisDikerjakan' => $totalKuisDikerjakan,
            'skorTertinggi' => $skorTertinggi,
        ]);
    }

    /**
     * Evaluasi jawaban kuis yang dikirimkan pengunjung.
     */
    public function submitKuis(Request $request): JsonResponse
    {
        $request->validate([
            'jawaban' => ['required', 'array'],
            'jawaban.*' => ['nullable', 'string', 'in:A,B,C,D'],
        ]);

        $jawabanPengguna = $request->input('jawaban');
        $soalIds = array_keys($jawabanPengguna);

        $soalList = SoalKuis::whereIn('id', $soalIds)->get()->keyBy('id');

        $totalSoal = count($soalIds);
        $jawabanBenar = 0;
        $evaluasi = [];

        foreach ($jawabanPengguna as $soalId => $jawaban) {
            $soal = $soalList->get($soalId);
            if (! $soal) {
                continue;
            }

            $isCorrect = (strtoupper((string) $jawaban) === strtoupper($soal->kunci_jawaban));
            if ($isCorrect) {
                $jawabanBenar++;
            }

            $evaluasi[] = [
                'soal_id' => $soal->id,
                'pertanyaan' => $soal->pertanyaan,
                'jawaban_pengguna' => $jawaban,
                'kunci_jawaban' => $soal->kunci_jawaban,
                'is_benar' => $isCorrect,
                'pembahasan' => $soal->pembahasan,
            ];
        }

        $skor = $totalSoal > 0 ? (int) round(($jawabanBenar / $totalSoal) * 100) : 0;

        // Simpan riwayat kuis pengguna
        RiwayatKuis::create([
            'user_id' => Auth::id(),
            'total_soal' => $totalSoal,
            'jawaban_benar' => $jawabanBenar,
            'skor' => $skor,
        ]);

        // Catat aktivitas
        Aktivitas::create([
            'user_id' => Auth::id(),
            'tipe' => 'kuis',
            'deskripsi' => 'Menyelesaikan kuis Bahasa Wemale dengan skor '.$skor.'/100 ('.$jawabanBenar.'/'.$totalSoal.' benar).',
        ]);

        return response()->json([
            'success' => true,
            'skor' => $skor,
            'total_soal' => $totalSoal,
            'jawaban_benar' => $jawabanBenar,
            'evaluasi' => $evaluasi,
        ]);
    }

    /**
     * Simpan usulan kata baru dari pengunjung terdaftar (kontribusi komunitas).
     */
    public function usulkanKata(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kata_wemale' => ['required', 'string', 'max:100'],
            'arti_indonesia' => ['required', 'string', 'max:255'],
            'kategori_id' => ['nullable', 'exists:kategoris,id'],
            'contoh' => ['nullable', 'string', 'max:255'],
            'terjemahan_contoh' => ['nullable', 'string', 'max:255'],
        ], [
            'kata_wemale.required' => 'Kata Bahasa Wemale wajib diisi.',
            'arti_indonesia.required' => 'Arti Bahasa Indonesia wajib diisi.',
        ]);

        $user = Auth::user();

        // Catat aktivitas kontribusi
        Aktivitas::create([
            'user_id' => $user?->id,
            'tipe' => 'kontribusi',
            'deskripsi' => 'Pengguna "'.$user?->name.'" mengusulkan kata baru: "'.$validated['kata_wemale'].'" ('.$validated['arti_indonesia'].').',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Usulan kata "'.$validated['kata_wemale'].'" berhasil dikirim untuk ditinjau oleh administrator.',
        ]);
    }
}
