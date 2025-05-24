import React from "react";
import { Link } from "@inertiajs/react";
import MainLayout from "@/Layouts/MainLayout";
import {
    User,
    MapPin,
    Calendar,
    Phone,
    Heart,
    Flag,
    Users,
} from "lucide-react";

export default function Profile({ anggota }) {
    if (!anggota) {
        return (
            <MainLayout>
                <div className="max-w-2xl mx-auto lg:mt-10 text-center bg-white p-8 rounded-xl shadow-lg">
                    <h1 className="text-2xl font-bold text-gray-800 mb-4">
                        Data Anggota Belum Tersedia
                    </h1>
                    <p className="text-gray-600 mb-6">
                        Akun Anda belum memiliki data anggota. Silakan hubungi
                        pengurus untuk melengkapi informasi profil Anda.
                    </p>
                </div>
            </MainLayout>
        );
    }
    // Function untuk mengubah status keanggotaan menjadi properti warna yang sesuai
    const getStatusColors = (status) => {
        switch (status?.toLowerCase()) {
            case "aktif":
                return {
                    bg: "bg-green-500",
                    text: "text-white",
                    border: "border-green-600",
                    shadow: "shadow-green-200",
                };
            case "pasif":
                return {
                    bg: "bg-yellow-500",
                    text: "text-white",
                    border: "border-yellow-600",
                    shadow: "shadow-yellow-200",
                };
            default:
                return {
                    bg: "bg-red-500",
                    text: "text-white",
                    border: "border-red-600",
                    shadow: "shadow-red-200",
                };
        }
    };

    const statusColors = getStatusColors(anggota.status_keanggotaan);

    return (
        <MainLayout>
            <div className="max-w-4xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
                {/* Banner & Profile Header */}
                <div className="relative">
                    <div className="h-20 w-full bg-gradient-to-r from-blue-500 to-purple-600 rounded-t-2xl"></div>

                    <div className="absolute left-0 right-0 -bottom-16 flex justify-center">
                        <div className="h-28 w-28 rounded-full bg-white p-1 shadow-lg">
                            <div className="h-full w-full rounded-full bg-gray-200 flex items-center justify-center">
                                <User size={48} className="text-gray-500" />
                            </div>
                        </div>
                    </div>
                </div>

                {/* Profile Content */}
                <div className="bg-white rounded-b-2xl shadow-lg mt-8 p-8">
                    <div className="text-center mb-8 pt-4">
                        <h1 className="text-3xl font-bold text-gray-800">
                            {anggota.nama || "Nama Anggota"}
                        </h1>

                        {/* Status Keanggotaan yang lebih menonjol */}
                        <div className="mt-5">
                            <div
                                className={`mx-auto max-w-fit ${statusColors.bg} ${statusColors.text} px-4 py-3 rounded-lg shadow-lg ${statusColors.shadow} border-b-4 ${statusColors.border} flex items-center justify-center transform transition-all hover:scale-105`}
                            >
                                <div
                                    className={`mr-2 h-3 w-3 rounded-full bg-white animate-pulse`}
                                ></div>
                                <span className="font-bold text-sm uppercase tracking-wider">
                                    Status Keanggotaan:{" "}
                                    {anggota.status_keanggotaan ||
                                        "Tidak Diketahui"}
                                </span>
                            </div>
                        </div>
                    </div>

                    {/* Informasi Anggota dalam Card */}
                    <div className="mt-8 p-6 bg-gray-50 rounded-xl border border-gray-100 shadow-sm">
                        <h2 className="text-xl font-semibold text-gray-700 mb-4 pb-2 border-b border-gray-200">
                            Informasi Pribadi
                        </h2>

                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {/* Kolom Kiri */}
                            <div className="space-y-6">
                                <div className="flex items-start">
                                    <div className="flex-shrink-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                                        <MapPin className="h-5 w-5 text-blue-600" />
                                    </div>
                                    <div className="ml-4">
                                        <h2 className="text-lg font-medium text-gray-800">
                                            Tempat & Tanggal Lahir
                                        </h2>
                                        <p className="mt-1 text-gray-600">
                                            {anggota.tempat_tgl_lahir || "-"}
                                        </p>
                                    </div>
                                </div>

                                <div className="flex items-start">
                                    <div className="flex-shrink-0 flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-100">
                                        <Users className="h-5 w-5 text-indigo-600" />
                                    </div>
                                    <div className="ml-4">
                                        <h2 className="text-lg font-medium text-gray-800">
                                            Jenis Kelamin
                                        </h2>
                                        <p className="mt-1 text-gray-600">
                                            {anggota.jenis_kelamin || "-"}
                                        </p>
                                    </div>
                                </div>

                                <div className="flex items-start">
                                    <div className="flex-shrink-0 flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100">
                                        <Calendar className="h-5 w-5 text-purple-600" />
                                    </div>
                                    <div className="ml-4">
                                        <h2 className="text-lg font-medium text-gray-800">
                                            Agama
                                        </h2>
                                        <p className="mt-1 text-gray-600">
                                            {anggota.agama || "-"}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {/* Kolom Kanan */}
                            <div className="space-y-6">
                                <div className="flex items-start">
                                    <div className="flex-shrink-0 flex h-10 w-10 items-center justify-center rounded-lg bg-green-100">
                                        <Flag className="h-5 w-5 text-green-600" />
                                    </div>
                                    <div className="ml-4">
                                        <h2 className="text-lg font-medium text-gray-800">
                                            RT
                                        </h2>
                                        <p className="mt-1 text-gray-600">
                                            {anggota.rt || "-"}
                                        </p>
                                    </div>
                                </div>

                                <div className="flex items-start">
                                    <div className="flex-shrink-0 flex h-10 w-10 items-center justify-center rounded-lg bg-red-100">
                                        <Heart className="h-5 w-5 text-red-600" />
                                    </div>
                                    <div className="ml-4">
                                        <h2 className="text-lg font-medium text-gray-800">
                                            Golongan Darah
                                        </h2>
                                        <p className="mt-1 text-gray-600">
                                            {anggota.gol_darah || "-"}
                                        </p>
                                    </div>
                                </div>

                                <div className="flex items-start">
                                    <div className="flex-shrink-0 flex h-10 w-10 items-center justify-center rounded-lg bg-yellow-100">
                                        <Phone className="h-5 w-5 text-yellow-600" />
                                    </div>
                                    <div className="ml-4">
                                        <h2 className="text-lg font-medium text-gray-800">
                                            Nomor HP
                                        </h2>
                                        <p className="mt-1 text-gray-600">
                                            {anggota.no_hp || "-"}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div className="mt-10 flex justify-center space-x-4">
                        <Link
                            href="/profile/edit"
                            className="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-medium rounded-lg hover:from-blue-700 hover:to-indigo-700 transition shadow-md flex items-center"
                        >
                            <span>Edit Profil</span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                className="h-5 w-5 ml-2"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                            >
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </Link>
                        <Link
                            href="/riwayat-iuran"
                            className="px-6 py-3 bg-gradient-to-r from-green-600 to-teal-600 text-white font-medium rounded-lg hover:from-green-700 hover:to-teal-700 transition shadow-md flex items-center"
                        >
                            <span>Riwayat Kas Saya</span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                className="h-5 w-5 ml-2"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth={2}
                                    d="M9 17v-2a4 4 0 014-4h4m0 0l-5-5m5 5l-5 5"
                                />
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
