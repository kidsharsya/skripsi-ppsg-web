import React from "react";
import { usePage, Link } from "@inertiajs/react";
import MainLayout from "../Layouts/MainLayout";

export default function ArsipRapatDetail() {
    const { arsip } = usePage().props;

    return (
        <MainLayout>
            <div className="max-w-3xl mx-auto mt-8 p-6 bg-white rounded-2xl shadow-md">
                <h1 className="text-2xl font-bold mb-4">{arsip.judul_rapat}</h1>
                <p className="text-black mb-4">
                    Tanggal Rapat:{" "}
                    {new Date(arsip.tanggal_rapat).toLocaleDateString("id-ID", {
                        day: "numeric",
                        month: "long",
                        year: "numeric",
                    })}
                </p>
                <div className="mb-4">
                    <h2 className="text-lg font-semibold mb-2">Notulensi</h2>
                    <p className="bg-gray-100 p-4 rounded-md whitespace-pre-line">
                        {arsip.notulensi}
                    </p>
                </div>
                {arsip.dokumentasi && (
                    <div>
                        <h2 className="text-lg font-semibold mb-2">
                            Dokumentasi
                        </h2>
                        <img
                            src={arsip.dokumentasi_url}
                            alt="Dokumentasi Rapat"
                            className="rounded-lg shadow-md max-w-full h-auto"
                        />
                    </div>
                )}
                <div className="mt-6">
                    <Link
                        href="/arsip-rapat"
                        className="text-blue-600 hover:underline"
                    >
                        ← Kembali ke Daftar Arsip
                    </Link>
                </div>
            </div>
        </MainLayout>
    );
}
