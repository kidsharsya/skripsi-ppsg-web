import React from "react";
import { Link, usePage } from "@inertiajs/react";
import MainLayout from "../Layouts/MainLayout";

export default function ArsipRapat() {
    const { arsipRapat } = usePage().props;

    return (
        <MainLayout>
            <h1 className="text-xl font-bold text-center mt-8 mb-6">
                Daftar Arsip Rapat
            </h1>

            <div className="max-w-4xl mx-auto overflow-x-auto">
                {arsipRapat.length > 0 ? (
                    <table className="min-w-full bg-white border border-gray-300 rounded-lg">
                        <thead className="bg-gray-200">
                            <tr>
                                <th className="text-left px-4 py-2 border">
                                    Kegiatan
                                </th>
                                <th className="text-left px-4 py-2 border">
                                    Tanggal Rapat
                                </th>
                                <th className="text-center px-4 py-2 border">
                                    Detail
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {arsipRapat.map((arsip) => (
                                <tr key={arsip.id} className="hover:bg-gray-50">
                                    <td className="border px-4 py-2">
                                        {arsip.judul_rapat}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {new Date(
                                            arsip.tanggal_rapat
                                        ).toLocaleDateString("id-ID", {
                                            day: "numeric",
                                            month: "long",
                                            year: "numeric",
                                        })}
                                    </td>
                                    <td className="border px-4 py-2 text-center">
                                        <Link
                                            href={`/arsip-rapat/${arsip.id}`}
                                            className="text-blue-600 hover:underline"
                                        >
                                            Lihat Detail
                                        </Link>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                ) : (
                    <div className="text-center text-gray-500 mt-10">
                        Tidak ada arsip rapat tersedia.
                    </div>
                )}
            </div>
        </MainLayout>
    );
}
