import React from "react";
import MainLayout from "../Layouts/MainLayout";
import { usePage } from "@inertiajs/react";

export default function Anggota() {
    const { anggotas, jumlahRt, jumlahGender } = usePage().props; // Mendapatkan data anggota dari props

    return (
        <MainLayout>
            {/* Judul */}
            <div>
                <h1 className="text-center lg:text-2xl md:text-xl text-xl font-bold mt-8 mb-8">
                    Data Anggota PPSG Candisingo
                </h1>
            </div>

            {/* Statistik Jumlah Anggota */}
            <div className="w-full mb-12">
                <div className="bg-white shadow-lg rounded-2xl p-6">
                    {/* Jumlah Per RT */}
                    <h3 className="text-center font-bold text-lg text-blue-900 mb-4">
                        Jumlah Anggota Per RT
                    </h3>
                    <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4">
                        {["01", "02", "03", "04", "05", "06"].map((rt) => (
                            <div
                                key={rt}
                                className="border-2 border-blue-900 text-blue-900 rounded-xl px-4 py-4 text-center hover:shadow-md transition duration-200"
                            >
                                <div className="text-sm font-semibold tracking-wide">
                                    RT {rt}
                                </div>
                                <div className="text-2xl font-extrabold">
                                    {jumlahRt[rt] || 0}
                                </div>
                            </div>
                        ))}
                    </div>

                    {/* Jumlah Gender */}
                    <h3 className="text-center font-bold text-lg text-blue-900 mt-8 mb-4">
                        Jumlah Berdasarkan Gender
                    </h3>
                    <div className="grid grid-cols-2 gap-4 max-w-md mx-auto mb-4">
                        {["Laki-laki", "Perempuan"].map((gender) => (
                            <div
                                key={gender}
                                className="border-2 border-blue-900 text-blue-900 rounded-xl px-4 py-4 text-center hover:shadow-md transition duration-200"
                            >
                                <div className="text-sm font-semibold tracking-wide">
                                    {gender}
                                </div>
                                <div className="text-2xl font-extrabold">
                                    {jumlahGender[gender] || 0}
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </div>

            {/* Tabel Responsif */}
            <h2 className="text-center font-bold text-lg text-blue-900 mt-12 mb-4">
                Daftar Keseluruhan Anggota
            </h2>
            <div className="overflow-x-auto">
                <table className="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr className="bg-gray-200">
                            <th className="px-4 py-2 border-b font-semibold text-left">
                                No
                            </th>
                            <th className="px-4 py-2 border-b font-semibold text-left">
                                Nama
                            </th>
                            {/* <th className="px-4 py-2 border-b font-semibold text-left">
                                Tempat Tgl Lahir
                            </th> */}
                            <th className="px-4 py-2 border-b font-semibold text-left">
                                Jenis Kelamin
                            </th>
                            <th className="px-4 py-2 border-b font-semibold text-left">
                                Agama
                            </th>
                            <th className="px-4 py-2 border-b font-semibold text-left">
                                RT
                            </th>
                            {/* <th className="px-4 py-2 border-b font-semibold text-left">
                                Golongan Darah
                            </th> */}
                            <th className="px-4 py-2 border-b font-semibold text-left">
                                No HP
                            </th>
                            <th className="px-4 py-2 border-b font-semibold text-left">
                                Status Keanggotaan
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {anggotas.map((anggota, index) => (
                            <tr key={anggota.id} className="hover:bg-gray-100">
                                <td className="border px-4 py-2">
                                    {index + 1}
                                </td>
                                <td className="border px-4 py-2">
                                    {anggota.nama}
                                </td>
                                {/* <td className="border px-4 py-2">
                                    {anggota.tempat_tgl_lahir}
                                </td> */}
                                <td className="border px-4 py-2">
                                    {anggota.jenis_kelamin}
                                </td>
                                <td className="border px-4 py-2">
                                    {anggota.agama}
                                </td>
                                <td className="border px-4 py-2">
                                    {anggota.rt}
                                </td>
                                {/* <td className="border px-4 py-2">
                                    {anggota.gol_darah}
                                </td> */}
                                <td className="border px-4 py-2">
                                    {anggota.no_hp}
                                </td>
                                <td className="border px-4 py-2 text-center">
                                    {/* Perbaikan untuk tampilan mobile dengan menyesuaikan ukuran dan padding */}
                                    <span
                                        className={`inline-block w-full md:w-auto px-2 py-1 rounded-md text-xs md:text-sm font-medium
                                        ${
                                            anggota.status_keanggotaan ===
                                            "aktif"
                                                ? "bg-green-100 text-green-800"
                                                : anggota.status_keanggotaan ===
                                                  "pasif"
                                                ? "bg-yellow-100 text-yellow-800"
                                                : "bg-red-100 text-red-800"
                                        }`}
                                    >
                                        {anggota.status_keanggotaan
                                            .charAt(0)
                                            .toUpperCase() +
                                            anggota.status_keanggotaan.slice(1)}
                                    </span>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </MainLayout>
    );
}
