import React from "react";
import MainLayout from "../Layouts/MainLayout";
import { usePage } from "@inertiajs/react";

export default function RiwayatIuran() {
    const { riwayat } = usePage().props;

    return (
        <MainLayout>
            <h1 className="text-xl font-bold text-center mb-6 mt-8">
                Riwayat Kas Saya
            </h1>

            <div className="max-w-2xl mx-auto">
                {riwayat.length === 0 ? (
                    <div className="text-center text-gray-600 p-6 border border-dashed border-gray-300 rounded-lg bg-gray-50">
                        <p className="text-lg font-semibold mb-2">
                            Tidak ada riwayat kas
                        </p>
                        <p className="text-sm text-gray-500">
                            Belum ada catatan kas untuk RT Anda.
                        </p>
                    </div>
                ) : (
                    <div className="overflow-x-auto">
                        <table className="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
                            <thead>
                                <tr className="bg-gray-200 text-left">
                                    <th className="px-4 py-2 border">
                                        Tanggal Pertemuan
                                    </th>
                                    <th className="px-4 py-2 border">RT</th>
                                    <th className="px-4 py-2 border">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {riwayat.map((item) => (
                                    <tr
                                        key={item.id}
                                        className="hover:bg-gray-50"
                                    >
                                        <td className="border px-4 py-2">
                                            {new Date(
                                                item.tanggal_pertemuan
                                            ).toLocaleDateString("id-ID", {
                                                day: "numeric",
                                                month: "long",
                                                year: "numeric",
                                            })}
                                        </td>
                                        <td className="border px-4 py-2">
                                            {item.rt}
                                        </td>
                                        <td
                                            className={`border px-4 py-2 font-semibold ${
                                                item.status === "Sudah Bayar"
                                                    ? "text-green-600"
                                                    : "text-red-600"
                                            }`}
                                        >
                                            {item.status}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                )}
            </div>
        </MainLayout>
    );
}
