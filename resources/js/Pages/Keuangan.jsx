import React from "react";
import MainLayout from "../Layouts/MainLayout";
import { usePage } from "@inertiajs/react";
import { style } from "framer-motion/client";
import { Currency } from "lucide-react";

export default function Keuangan() {
    const { catatan, total_masuk, total_keluar, saldo_akhir } = usePage().props; // Ambil data dari controller
    // Fungsi untuk format rupiah seperti Laravel Filament
    const formatRupiah = (angka) => {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 2,
        }).format(angka);
    };

    return (
        <MainLayout>
            <div>
                <h1 className="text-center lg:text-2xl md:text-xl text-xl font-bold mt-8 mb-8">
                    Catatan Keuangan PPSG Candisingo
                </h1>
            </div>

            <div className="overflow-x-auto">
                <table className="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr className="bg-gray-200">
                            <th className="px-4 py-2 border-b text-left font-semibold">
                                Tanggal
                            </th>
                            <th className="px-4 py-2 border-b text-left font-semibold">
                                Deskripsi
                            </th>
                            <th className="px-4 py-2 border-b text-left font-semibold">
                                Masuk (Rp)
                            </th>
                            <th className="px-4 py-2 border-b text-left font-semibold">
                                Keluar (Rp)
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {catatan.length === 0 ? (
                            <tr>
                                <td
                                    colSpan="4"
                                    className="text-center py-4 text-gray-500"
                                >
                                    Tidak ada data keuangan.
                                </td>
                            </tr>
                        ) : (
                            catatan.map((item) => (
                                <tr key={item.id} className="hover:bg-gray-100">
                                    <td className="border px-4 py-2">
                                        {new Date(
                                            item.tanggal
                                        ).toLocaleDateString("id-ID", {
                                            day: "numeric",
                                            month: "long",
                                            year: "numeric",
                                        })}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {item.deskripsi}
                                    </td>
                                    <td className="border px-4 py-2 text-green-600 font-semibold">
                                        {item.masuk
                                            ? formatRupiah(item.masuk)
                                            : "-"}
                                    </td>
                                    <td className="border px-4 py-2 text-red-600 font-semibold">
                                        {item.keluar
                                            ? formatRupiah(item.keluar)
                                            : "-"}
                                    </td>
                                </tr>
                            ))
                        )}
                    </tbody>
                    <tfoot className="bg-gray-100 font-semibold">
                        <tr>
                            <td
                                colSpan="2"
                                className="border px-4 py-2 text-right"
                            >
                                Total
                            </td>
                            <td className="border px-4 py-2 text-green-700">
                                {formatRupiah(total_masuk)}
                            </td>
                            <td className="border px-4 py-2 text-red-700">
                                {formatRupiah(total_keluar)}
                            </td>
                        </tr>
                        <tr>
                            <td
                                colSpan="2"
                                className="border px-4 py-2 text-right"
                            >
                                Saldo Akhir
                            </td>
                            <td
                                colSpan="2"
                                className="border px-4 py-2 font-bold text-blue-700"
                            >
                                {formatRupiah(saldo_akhir)}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </MainLayout>
    );
}
