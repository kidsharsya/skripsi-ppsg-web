import React, { useState } from "react";
import MainLayout from "../Layouts/MainLayout";
import { usePage } from "@inertiajs/react";

export default function Keuangan() {
    const { catatan, total_masuk, total_keluar, saldo_akhir } = usePage().props;
    const [sortOrder, setSortOrder] = useState("terbaru"); // 'terbaru' atau 'terlama'

    // Fungsi untuk format rupiah seperti Laravel Filament
    const formatRupiah = (angka) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 2,
        }).format(angka);
    };

    // Fungsi untuk mengelompokkan data berdasarkan bulan
    const groupByMonth = (data) => {
        const grouped = {};

        data.forEach((item) => {
            const date = new Date(item.tanggal);
            const monthYear = date.toLocaleDateString("id-ID", {
                month: "long",
                year: "numeric",
            });
            const sortKey = date.getFullYear() * 100 + date.getMonth(); // untuk sorting

            if (!grouped[monthYear]) {
                grouped[monthYear] = {
                    masuk: [],
                    keluar: [],
                    totalMasuk: 0,
                    totalKeluar: 0,
                    sortKey: sortKey,
                };
            }

            if (item.masuk && item.masuk > 0) {
                grouped[monthYear].masuk.push(item);
                grouped[monthYear].totalMasuk += parseFloat(item.masuk);
            }

            if (item.keluar && item.keluar > 0) {
                grouped[monthYear].keluar.push(item);
                grouped[monthYear].totalKeluar += parseFloat(item.keluar);
            }
        });

        return grouped;
    };

    // Fungsi untuk menghitung saldo kumulatif per bulan
    const calculateCumulativeBalance = (groupedData) => {
        // Sort bulan berdasarkan tanggal
        const sortedMonths = Object.entries(groupedData).sort(
            (a, b) => a[1].sortKey - b[1].sortKey
        );

        let cumulativeBalance = 0;
        const monthsWithBalance = {};

        sortedMonths.forEach(([monthYear, data]) => {
            // Hitung saldo bulan ini = saldo sebelumnya + masuk - keluar
            cumulativeBalance =
                cumulativeBalance + data.totalMasuk - data.totalKeluar;

            monthsWithBalance[monthYear] = {
                ...data,
                saldoBulanIni: cumulativeBalance,
            };
        });

        return monthsWithBalance;
    };

    const groupedData = groupByMonth(catatan);
    const groupedDataWithBalance = calculateCumulativeBalance(groupedData);

    // Fungsi untuk mengurutkan data berdasarkan pilihan user
    const getSortedData = () => {
        const entries = Object.entries(groupedDataWithBalance);

        if (sortOrder === "terbaru") {
            return entries.sort((a, b) => b[1].sortKey - a[1].sortKey); // Terbaru dulu
        } else {
            return entries.sort((a, b) => a[1].sortKey - b[1].sortKey); // Terlama dulu
        }
    };

    return (
        <MainLayout>
            <div>
                <h1 className="text-center lg:text-2xl md:text-xl text-xl font-bold mt-8 mb-4">
                    Catatan Keuangan PPSG Candisingo
                </h1>

                {/* Summary Total */}
                {Object.keys(groupedDataWithBalance).length > 0 && (
                    <div className="mt-8 bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                        <div className="bg-blue-100 px-4 py-3 font-semibold text-center text-blue-800">
                            RINGKASAN TOTAL
                        </div>
                        <div className="p-6">
                            <div className="grid md:grid-cols-3 gap-4 text-center">
                                <div className="bg-green-50 p-4 rounded-lg">
                                    <div className="text-sm text-gray-600 mb-1">
                                        Total Pemasukan
                                    </div>
                                    <div className="text-xl font-bold text-green-700">
                                        {formatRupiah(total_masuk)}
                                    </div>
                                </div>
                                <div className="bg-red-50 p-4 rounded-lg">
                                    <div className="text-sm text-gray-600 mb-1">
                                        Total Pengeluaran
                                    </div>
                                    <div className="text-xl font-bold text-red-700">
                                        {formatRupiah(total_keluar)}
                                    </div>
                                </div>
                                <div className="bg-blue-50 p-4 rounded-lg">
                                    <div className="text-sm text-gray-600 mb-1">
                                        Saldo Akhir
                                    </div>
                                    <div
                                        className={`text-xl font-bold ${
                                            saldo_akhir >= 0
                                                ? "text-blue-700"
                                                : "text-red-700"
                                        }`}
                                    >
                                        {formatRupiah(saldo_akhir)}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                )}

                {/* Tombol Pengurutan Minimalis */}
                <div className="flex justify-start mb-6 mt-6">
                    <div className="flex items-center gap-2 bg-gray-100 rounded-full px-2 py-1">
                        <button
                            onClick={() => setSortOrder("terbaru")}
                            className={`text-sm px-3 py-1 rounded-full transition-colors ${
                                sortOrder === "terbaru"
                                    ? "bg-blue-500 text-white"
                                    : "text-gray-600 hover:bg-white hover:text-black"
                            }`}
                        >
                            Terbaru
                        </button>
                        <button
                            onClick={() => setSortOrder("terlama")}
                            className={`text-sm px-3 py-1 rounded-full transition-colors ${
                                sortOrder === "terlama"
                                    ? "bg-blue-500 text-white"
                                    : "text-gray-600 hover:bg-white hover:text-black"
                            }`}
                        >
                            Terlama
                        </button>
                    </div>
                </div>
            </div>

            <div className="space-y-6">
                {Object.keys(groupedDataWithBalance).length === 0 ? (
                    <div className="text-center py-8 text-gray-500">
                        Tidak ada data keuangan.
                    </div>
                ) : (
                    // Gunakan fungsi getSortedData() untuk pengurutan
                    getSortedData().map(([monthYear, data]) => (
                        <div
                            key={monthYear}
                            className="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm"
                        >
                            {/* Header Bulan */}
                            <div className="bg-orange-100 text-gray-800 px-4 py-3 font-semibold text-center">
                                {monthYear}
                            </div>

                            <div className="grid md:grid-cols-2 gap-0">
                                {/* Kolom Uang Masuk */}
                                <div className="border-r border-gray-200">
                                    <div className="bg-gray-50 px-4 py-2 font-semibold text-center text-green-700">
                                        Uang Masuk
                                    </div>

                                    <div className="overflow-x-auto">
                                        <table className="w-full">
                                            <thead>
                                                <tr className="bg-gray-100">
                                                    <th className="px-4 py-2 text-left text-sm font-medium text-gray-700">
                                                        Tanggal
                                                    </th>
                                                    <th className="px-4 py-2 text-left text-sm font-medium text-gray-700">
                                                        Deskripsi
                                                    </th>
                                                    <th className="px-4 py-2 text-left text-sm font-medium text-gray-700">
                                                        Uang Masuk
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {data.masuk.length === 0 ? (
                                                    <tr>
                                                        <td
                                                            colSpan="3"
                                                            className="px-4 py-2 text-center text-gray-500 text-sm"
                                                        >
                                                            Tidak ada data uang
                                                            masuk
                                                        </td>
                                                    </tr>
                                                ) : (
                                                    data.masuk.map((item) => (
                                                        <tr
                                                            key={`masuk-${item.id}`}
                                                            className="hover:bg-gray-50"
                                                        >
                                                            <td className="border-b px-4 py-2 text-sm">
                                                                {new Date(
                                                                    item.tanggal
                                                                ).toLocaleDateString(
                                                                    "id-ID",
                                                                    {
                                                                        day: "numeric",
                                                                        month: "long",
                                                                        year: "numeric",
                                                                    }
                                                                )}
                                                            </td>
                                                            <td className="border-b px-4 py-2 text-sm">
                                                                {item.deskripsi}
                                                            </td>
                                                            <td className="border-b px-4 py-2 text-sm font-semibold text-green-600">
                                                                {formatRupiah(
                                                                    item.masuk
                                                                )}
                                                            </td>
                                                        </tr>
                                                    ))
                                                )}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                {/* Kolom Uang Keluar */}
                                <div>
                                    <div className="bg-gray-50 px-4 py-2 font-semibold text-center text-red-700">
                                        Uang Keluar
                                    </div>

                                    <div className="overflow-x-auto">
                                        <table className="w-full">
                                            <thead>
                                                <tr className="bg-gray-100">
                                                    <th className="px-4 py-2 text-left text-sm font-medium text-gray-700">
                                                        Tanggal
                                                    </th>
                                                    <th className="px-4 py-2 text-left text-sm font-medium text-gray-700">
                                                        Deskripsi
                                                    </th>
                                                    <th className="px-4 py-2 text-left text-sm font-medium text-gray-700">
                                                        Uang Keluar
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {data.keluar.length === 0 ? (
                                                    <tr>
                                                        <td
                                                            colSpan="3"
                                                            className="px-4 py-2 text-center text-gray-500 text-sm"
                                                        >
                                                            Tidak ada data uang
                                                            keluar
                                                        </td>
                                                    </tr>
                                                ) : (
                                                    data.keluar.map((item) => (
                                                        <tr
                                                            key={`keluar-${item.id}`}
                                                            className="hover:bg-gray-50"
                                                        >
                                                            <td className="border-b px-4 py-2 text-sm">
                                                                {new Date(
                                                                    item.tanggal
                                                                ).toLocaleDateString(
                                                                    "id-ID",
                                                                    {
                                                                        day: "numeric",
                                                                        month: "long",
                                                                        year: "numeric",
                                                                    }
                                                                )}
                                                            </td>
                                                            <td className="border-b px-4 py-2 text-sm">
                                                                {item.deskripsi}
                                                            </td>
                                                            <td className="border-b px-4 py-2 text-sm font-semibold text-red-600">
                                                                {formatRupiah(
                                                                    item.keluar
                                                                )}
                                                            </td>
                                                        </tr>
                                                    ))
                                                )}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {/* Summary untuk bulan ini */}
                            <div className="bg-gray-50 border-t border-gray-200 px-4 py-3">
                                <div className="grid grid-cols-2 gap-4 text-sm">
                                    <div className="text-center">
                                        <span className="text-gray-600">
                                            Total Masuk:{" "}
                                        </span>
                                        <span className="font-semibold text-green-700">
                                            {formatRupiah(data.totalMasuk)}
                                        </span>
                                    </div>
                                    <div className="text-center">
                                        <span className="text-gray-600">
                                            Total Keluar:{" "}
                                        </span>
                                        <span className="font-semibold text-red-700">
                                            {formatRupiah(data.totalKeluar)}
                                        </span>
                                    </div>
                                </div>
                                <div className="text-center mt-3">
                                    <span className="text-gray-700">
                                        Saldo Bulan Ini:{" "}
                                    </span>
                                    <span
                                        className={`font-bold ${
                                            data.saldoBulanIni >= 0
                                                ? "text-blue-700"
                                                : "text-red-700"
                                        }`}
                                    >
                                        {formatRupiah(data.saldoBulanIni)}
                                    </span>
                                </div>
                            </div>
                        </div>
                    ))
                )}
            </div>
        </MainLayout>
    );
}
