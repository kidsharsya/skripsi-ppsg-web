<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use App\Models\Acara;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PresensiController extends Controller
{
    public function store(Request $request)
    {
        $request->merge([
            'anggota_id' => Auth::user()->anggota->id,
        ]);

        $validator = Validator::make($request->all(), [
            'acara_id' => 'required|exists:acaras,id',
            'anggota_id' => 'required|exists:anggotas,id',
            'token' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'status' => 'required|in:hadir,izin',
            'alasan' => 'required_if:status,izin|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $acara = Acara::find($request->acara_id);

        // Validasi token
        if ($request->token !== $acara->token) {
            return back()->withErrors(['message' => 'Token tidak valid.']);
        }

        // Validasi waktu
        if (Carbon::now()->gt(Carbon::parse($acara->waktu_selesai))) {
            return back()->withErrors(['message' => 'Token sudah kedaluwarsa, presensi telah ditutup']);
        }

        // Hitung jarak lokasi
        $distance = $this->calculateDistance(
            $acara->latitude,
            $acara->longitude,
            $request->latitude,
            $request->longitude
        );

        if ($distance > 0.02) {
            return back()->withErrors(['message' => 'Tidak dapat presensi! Kamu berada di luar area lokasi acara']);
        }

        // Cek apakah sudah presensi
        $existing = Presensi::where('acara_id', $request->acara_id)
            ->where('anggota_id', $request->anggota_id)
            ->first();

        if ($existing && in_array($existing->status, ['hadir', 'izin'])) {
            return back()->withErrors(['message' => 'Kamu sudah melakukan presensi']);
        }

        if ($existing) {
            $existing->update([
                'waktu_presensi' => now(),
                'status' => $request->status,
                'alasan' => $request->status === 'izin' ? $request->alasan : null,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
            return back()->with('success', 'Presensi berhasil diperbarui');
        }

        // Jika presensi belum ada (seharusnya tidak terjadi karena sudah auto generate)
        Presensi::create([
            'acara_id' => $request->acara_id,
            'anggota_id' => $request->anggota_id,
            'waktu_presensi' => now(),
            'status' => $request->status,
            'alasan' => $request->status === 'izin' ? $request->alasan : null,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return back()->with('success', 'Presensi berhasil dicatat');
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function riwayatPresensi()
    {
        $user = Auth::user();

        if (!$user->anggota) {
            return Inertia::render('Presensi', [
                'riwayatPresensi' => [],
                'acaraAktif' => null,
            ]);
        }

        $anggotaId = $user->anggota->id;

        // Acara aktif yang belum presensi
        $acaraAktif = Acara::where('waktu_mulai', '<=', now())
            ->where('waktu_selesai', '>=', now())
            ->whereHas('presensis', function ($query) use ($anggotaId) {
                $query->where('anggota_id', $anggotaId)
                    ->where('status', 'Tidak Hadir');
            })->first();

        $acaras = Acara::with(['presensis' => function ($query) use ($anggotaId) {
            $query->where('anggota_id', $anggotaId);
        }])->get();

        $riwayat = $acaras->map(function ($acara) {
            $presensi = $acara->presensis->first();

            return [
                'id' => $acara->id,
                'nama_acara' => $acara->nama,
                'deskripsi' => $acara->deskripsi,
                'waktu_mulai' => $acara->waktu_mulai,
                'waktu_selesai' => $acara->waktu_selesai,
                'status' => ucfirst($presensi?->status ?? 'Tidak Hadir'),
                'waktu_presensi' => $presensi?->waktu_presensi,
                'alasan' => $presensi?->alasan,
            ];
        })->filter(fn ($item) => $item['status'] !== null);

        return Inertia::render('Presensi', [
            'acaraAktif' => $acaraAktif,
            'riwayatPresensi' => $riwayat->sortByDesc('waktu_mulai')->values(),
        ]);
    }
}
