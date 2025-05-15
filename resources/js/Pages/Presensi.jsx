import React from "react";
import MainLayout from "../Layouts/MainLayout";
import { Link } from "@inertiajs/react";

export default function Presensi({ acaraAktif, riwayatPresensi }) {
    return (
        <MainLayout>
            <div className="max-w-4xl mx-auto py-8 px-4">
                <h1 className="text-2xl font-bold mb-6">Presensi Kegiatan</h1>

                {/* ✅ Acara Aktif */}
                {acaraAktif ? (
                    <div className="bg-white shadow-md rounded-lg p-4 mb-8 border border-green-300">
                        <h2 className="text-xl font-semibold mb-2 text-green-700">
                            Presensi Aktif
                        </h2>
                        <p className="text-gray-700">
                            <strong>Nama:</strong> {acaraAktif.nama}
                        </p>
                        <p className="text-gray-700">
                            <strong>Deskripsi:</strong> {acaraAktif.deskripsi}
                        </p>
                        <p className="text-gray-700">
                            <strong>Presensi Berakhir:</strong>{" "}
                            {new Date(acaraAktif.waktu_selesai).toLocaleString(
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

                        <div className="flex space-x-3 mt-4">
                            <Link
                                href={`/presensi/${acaraAktif.id}`}
                                className="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition"
                            >
                                Hadir
                            </Link>
                            <Link
                                href={`/presensi/${acaraAktif.id}/izin`}
                                className="inline-block bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 transition"
                            >
                                Izin
                            </Link>
                        </div>
                    </div>
                ) : (
                    <div className="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-8">
                        <p>Tidak ada acara aktif saat ini.</p>
                    </div>
                )}

                {/* ✅ Riwayat Presensi */}
                <h2 className="text-xl font-semibold mb-4">Riwayat Presensi</h2>

                {riwayatPresensi.length > 0 ? (
                    <div className="overflow-x-auto">
                        <table className="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                            <thead className="bg-gray-100">
                                <tr>
                                    <th className="text-left px-4 py-2">
                                        Nama Acara
                                    </th>
                                    <th className="text-left px-4 py-2">
                                        Deskripsi
                                    </th>
                                    <th className="text-left px-4 py-2">
                                        Waktu Kegiatan
                                    </th>
                                    <th className="text-left px-4 py-2">
                                        Status
                                    </th>
                                    <th className="text-left px-4 py-2">
                                        Waktu Presensi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {riwayatPresensi.map((item) => (
                                    <tr key={item.id} className="border-t">
                                        <td className="px-4 py-2">
                                            {item.nama_acara}
                                        </td>
                                        <td className="px-4 py-2">
                                            {item.deskripsi}
                                        </td>
                                        <td className="px-4 py-2">
                                            {new Date(
                                                item.waktu_mulai
                                            ).toLocaleString("id-ID", {
                                                day: "numeric",
                                                month: "long",
                                                year: "numeric",
                                                hour: "numeric",
                                                minute: "numeric",
                                                hour24: true,
                                            })}{" "}
                                            - <br />
                                            {new Date(
                                                item.waktu_selesai
                                            ).toLocaleString("id-ID", {
                                                day: "numeric",
                                                month: "long",
                                                year: "numeric",
                                                hour: "numeric",
                                                minute: "numeric",
                                                hour24: true,
                                            })}
                                        </td>
                                        <td className="px-4 py-2">
                                            <div>
                                                <span
                                                    className={`inline-block px-2 py-1 rounded text-sm ${
                                                        item.status === "Hadir"
                                                            ? "bg-green-200 text-green-800"
                                                            : item.status ===
                                                              "Izin"
                                                            ? "bg-yellow-200 text-yellow-800"
                                                            : "bg-red-200 text-red-800"
                                                    }`}
                                                >
                                                    {item.status}
                                                </span>
                                                {item.status === "Izin" &&
                                                    item.alasan && (
                                                        <div className="mt-1 text-xs text-gray-600 italic">
                                                            Alasan:{" "}
                                                            {item.alasan}
                                                        </div>
                                                    )}
                                            </div>
                                        </td>
                                        <td className="px-4 py-2">
                                            {item.status !== "Tidak Hadir" &&
                                            item.waktu_presensi
                                                ? new Date(
                                                      item.waktu_presensi
                                                  ).toLocaleString("id-ID", {
                                                      day: "numeric",
                                                      month: "long",
                                                      year: "numeric",
                                                      hour: "numeric",
                                                      minute: "numeric",
                                                      hour24: true,
                                                  })
                                                : "-"}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                ) : (
                    <p className="text-gray-600">Belum ada riwayat presensi.</p>
                )}
            </div>
        </MainLayout>
    );
}
