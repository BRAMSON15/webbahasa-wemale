<?php

namespace App\Http\Controllers;

use App\Models\Kata;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    /**
     * Tampilkan beranda utama dengan daftar kata populer.
     */
    public function index()
    {
        $kataPopuler = Kata::populer()
            ->orderBy('kata_wemale')
            ->get();

        // Struktur data siap pakai untuk JavaScript (objek kata -> detail)
        $kamusData = $kataPopuler->mapWithKeys(fn (Kata $kata) => [
            $kata->kata_wemale => [
                'word' => $kata->kata_wemale,
                'meaning' => $kata->arti_indonesia,
                'example' => $kata->contoh ?? '',
                'exampleTrans' => $kata->terjemahan_contoh ?? '',
            ],
        ])->toArray();

        return view('beranda', [
            'kataPopuler' => $kataPopuler,
            'kamusData' => $kamusData,
        ]);
    }

    /**
     * Cari kata dalam kamus Wemale-Indonesia.
     * Mengembalikan JSON untuk dipakai oleh pencarian di beranda.
     */
    public function cari(Request $request): JsonResponse
    {
        $request->validate([
            'q' => ['required', 'string', 'min:1'],
        ]);

        $hasil = Kata::cari($request->string('q'))
            ->with('kategori')
            ->limit(20)
            ->get()
            ->map(fn (Kata $kata) => [
                'kata' => $kata->kata_wemale,
                'arti' => $kata->arti_indonesia,
                'contoh' => $kata->contoh,
                'terjemahan' => $kata->terjemahan_contoh,
                'kategori' => $kata->kategori?->nama_kategori,
            ]);

        return response()->json([
            'query' => $request->string('q')->toString(),
            'total' => $hasil->count(),
            'hasil' => $hasil,
        ]);
    }
}
