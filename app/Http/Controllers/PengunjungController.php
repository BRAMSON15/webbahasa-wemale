<?php

namespace App\Http\Controllers;

use App\Models\Aktivitas;
use App\Models\Kata;
use App\Models\Kategori;
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
