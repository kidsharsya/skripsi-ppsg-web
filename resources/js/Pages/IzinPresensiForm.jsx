import React, { useState, useEffect } from "react";
import MainLayout from "../Layouts/MainLayout";
import { useForm, usePage } from "@inertiajs/react";
import { toast } from "react-hot-toast";

export default function IzinPresensiForm({ acara }) {
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState("");
    const [isSubmitted, setIsSubmitted] = useState(false);

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
                setIsSubmitted(true);

                // Delay untuk memberikan feedback visual yang lebih baik
                setTimeout(() => {
                    toast.success("Izin berhasil dicatat!", {
                        duration: 4000,
                        position: "top-center",
                        style: {
                            background: "#10B981",
                            color: "#fff",
                            fontSize: "16px",
                            fontWeight: "600",
                            padding: "16px 24px",
                            borderRadius: "8px",
                            boxShadow: "0 10px 25px rgba(16, 185, 129, 0.3)",
                        },
                        iconTheme: {
                            primary: "#fff",
                            secondary: "#10B981",
                        },
                    });

                    // Delay tambahan sebelum redirect untuk memastikan user melihat notifikasi
                    setTimeout(() => {
                        window.location.href = "/presensi";
                    }, 2000);
                }, 800);
            },
            onError: (errors) => {
                setLoading(false);
                setIsSubmitted(false);
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

                    {/* Success state indicator */}
                    {isSubmitted && (
                        <div className="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                            <div className="flex items-center">
                                <svg
                                    className="w-5 h-5 mr-2 animate-spin"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        className="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        strokeWidth="4"
                                    ></circle>
                                    <path
                                        className="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                                <p>
                                    Izin sedang diproses... Mohon tunggu
                                    sebentar
                                </p>
                            </div>
                        </div>
                    )}

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
                                disabled={isSubmitted}
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
                                className={`inline-block px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition ${
                                    isSubmitted
                                        ? "opacity-50 pointer-events-none"
                                        : ""
                                }`}
                            >
                                Kembali
                            </a>
                            <button
                                type="submit"
                                disabled={processing || loading || isSubmitted}
                                className="inline-block px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition disabled:opacity-75"
                            >
                                {isSubmitted
                                    ? "Memproses Izin..."
                                    : processing || loading
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
