import React from "react";
import MainLayout from "../Layouts/MainLayout";
import { usePage } from "@inertiajs/react";

export default function ArsipProgramKerja() {
    const { arsipProgramKerja } = usePage().props;

    return (
        <MainLayout>
            <h1 className="text-xl font-bold text-center mt-8 mb-6">
                Arsip Program Kerja
            </h1>

            <div className="max-w-5xl mx-auto overflow-x-auto">
                {arsipProgramKerja.length > 0 ? (
                    <table className="min-w-full bg-white border border-gray-300 rounded-lg text-sm">
                        <thead className="bg-gray-200">
                            <tr>
                                <th className="px-4 py-2 border">
                                    Nama Kegiatan
                                </th>
                                <th className="px-4 py-2 border">Tanggal</th>
                                <th className="px-4 py-2 border">Proposal</th>
                                <th className="px-4 py-2 border">LPJ</th>
                                <th className="px-4 py-2 border">
                                    Dokumentasi
                                </th>
                                <th className="px-4 py-2 border">
                                    Dokumen Lain
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {arsipProgramKerja.map((item) => (
                                <tr key={item.id} className="hover:bg-gray-50">
                                    <td className="border px-4 py-2">
                                        {item.nama_kegiatan}
                                    </td>
                                    <td className="border px-4 py-2">
                                        {new Date(
                                            item.tanggal_kegiatan
                                        ).toLocaleDateString("id-ID", {
                                            day: "numeric",
                                            month: "long",
                                            year: "numeric",
                                        })}
                                    </td>
                                    <td className="border px-4 py-2 text-blue-600 underline">
                                        <a
                                            href={item.proposal}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            Lihat Proposal
                                        </a>
                                    </td>
                                    <td className="border px-4 py-2 text-blue-600 underline">
                                        <a
                                            href={item.lpj}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            Lihat LPJ
                                        </a>
                                    </td>
                                    <td className="border px-4 py-2 text-blue-600 underline">
                                        <a
                                            href={item.dokumentasi}
                                            target="_blank"
                                            rel="noopener noreferrer"
                                        >
                                            Lihat Dokumentasi
                                        </a>
                                    </td>
                                    <td className="border px-4 py-2 text-blue-600 underline">
                                        {item.dokumen_lain ? (
                                            <a
                                                href={item.dokumen_lain}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                            >
                                                Lihat Dokumen Lain
                                            </a>
                                        ) : (
                                            <span className="text-gray-400 italic">
                                                Tidak Ada
                                            </span>
                                        )}
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                ) : (
                    <div className="text-center text-gray-500 mt-10">
                        Tidak ada arsip program kerja tersedia.
                    </div>
                )}
            </div>
        </MainLayout>
    );
}
