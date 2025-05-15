import React, { useState, useEffect } from "react";
import MainLayout from "../Layouts/MainLayout";
import { useForm, usePage } from "@inertiajs/react";
import { toast } from "react-hot-toast";

export default function IzinPresensiForm({ acara }) {
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");

    const { data, setData, post, processing, errors } = useForm({
        acara_id: acara.id,
        anggota_id: acara.anggota_id,
        status: "izin",
        alasan: "",
        token: acara.token,
        latitude: acara.latitude,
        longitude: acara.longitude,
    });

    const handleSubmit = (e) => {
        e.preventDefault();
        setLoading(true);

        if (!data.alasan.trim()) {
            setError("Alasan izin wajib diisi");
            setLoading(false);
            return;
        }

        post(route("presensi.store"), {
            onSuccess: () => {
                toast.success("Izin berhasil dicatat");
                setLoading(false);
                // Redirect ke halaman riwayat presensi
                window.location.href = "/presensi";
            },
            onError: (errors) => {
                setLoading(false);
                if (errors.message) {
                    setError(errors.message);
                    toast.error(errors.message);
                } else {
                    setError("Terjadi kesalahan saat menyimpan izin");
                    toast.error("Terjadi kesalahan saat menyimpan izin");
                }
            },
        });
    };

    return (
        <MainLayout>
            <div className="max-w-4xl mx-auto py-8 px-4">
                <h1 className="text-2xl font-bold mb-6">Form Izin Kegiatan</h1>

                <div className="bg-white shadow-md rounded-lg p-6 mb-8 border border-yellow-300">
                    <h2 className="text-xl font-semibold mb-4 text-yellow-700">
                        Formulir Izin
                    </h2>

                    <div className="mb-6">
                        <p className="text-gray-700 mb-2">
                            <strong>Nama Acara:</strong> {acara.nama}
                        </p>
                        <p className="text-gray-700 mb-2">
                            <strong>Deskripsi:</strong> {acara.deskripsi}
                        </p>
                        <p className="text-gray-700 mb-2">
                            <strong>Waktu Mulai:</strong>{" "}
                            {new Date(acara.waktu_mulai).toLocaleString(
                                "id-ID",
                                {
                                    day: "numeric",
                                    month: "long",
                                    year: "numeric",
                                    hour: "numeric",
                                    minute: "numeric",
                                    hour24: true,
                                }
                            )}{" "}
                            WIB
                        </p>
                        <p className="text-gray-700 mb-4">
                            <strong>Waktu Selesai:</strong>{" "}
                            {new Date(acara.waktu_selesai).toLocaleString(
                                "id-ID",
                                {
                                    day: "numeric",
                                    month: "long",
                                    year: "numeric",
                                    hour: "numeric",
                                    minute: "numeric",
                                    hour24: true,
                                }
                            )}{" "}
                            WIB
                        </p>
                    </div>

                    {error && (
                        <div className="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                            <p>{error}</p>
                        </div>
                    )}

                    <form onSubmit={handleSubmit} className="space-y-4">
                        <div>
                            <label
                                htmlFor="alasan"
                                className="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Alasan Izin{" "}
                                <span className="text-red-500">*</span>
                            </label>
                            <textarea
                                id="alasan"
                                name="alasan"
                                rows="4"
                                className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                placeholder="Jelaskan alasan izin Anda"
                                value={data.alasan}
                                onChange={(e) =>
                                    setData("alasan", e.target.value)
                                }
                                required
                            ></textarea>
                            {errors.alasan && (
                                <p className="text-red-500 text-sm mt-1">
                                    {errors.alasan}
                                </p>
                            )}
                        </div>

                        <div className="flex justify-between">
                            <a
                                href="/presensi"
                                className="inline-block px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition"
                            >
                                Kembali
                            </a>
                            <button
                                type="submit"
                                disabled={processing || loading}
                                className="inline-block px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition disabled:opacity-75"
                            >
                                {processing || loading
                                    ? "Memproses..."
                                    : "Kirim Izin"}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </MainLayout>
    );
}
