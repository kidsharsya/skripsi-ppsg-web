import React, { useState } from "react";

const PengurusSection = ({ homeContent, pengurus }) => {
    const [activeTab, setActiveTab] = useState("utama");

    const pengurusUtama = pengurus.filter((p) => p.is_pengurus_utama);
    const pengurusLain = pengurus.filter((p) => !p.is_pengurus_utama);

    return (
        <section className="py-16 bg-gray-50">
            <div className="max-w-6xl mx-auto px-4">
                {/* Header dengan styling yang lebih profesional */}
                <div className="text-center mb-6">
                    <h2 className="text-3xl font-bold text-gray-800 mb-6">
                        {homeContent?.section3 || "Struktur Pengurus"}
                    </h2>
                    <div className="h-1 w-24 bg-blue-600 mx-auto"></div>
                </div>

                {/* Tab Navigation */}
                <div className="flex justify-center mb-10">
                    <div className="inline-flex bg-white p-1 rounded-lg shadow-sm">
                        <button
                            onClick={() => setActiveTab("utama")}
                            className={`px-5 py-2 rounded-md transition-all ${
                                activeTab === "utama"
                                    ? "bg-blue-600 text-white shadow-sm"
                                    : "text-gray-700 hover:bg-gray-100"
                            }`}
                        >
                            Pengurus Utama
                        </button>
                        <button
                            onClick={() => setActiveTab("lainnya")}
                            className={`px-5 py-2 rounded-md transition-all ${
                                activeTab === "lainnya"
                                    ? "bg-blue-600 text-white shadow-sm"
                                    : "text-gray-700 hover:bg-gray-100"
                            }`}
                        >
                            Pengurus Lainnya
                        </button>
                    </div>
                </div>

                {activeTab === "utama" ? (
                    <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-4xl mx-auto">
                        {pengurusUtama.map((pengurus, index) => (
                            <div
                                key={index}
                                className="group bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all flex flex-col items-center px-6 py-6"
                            >
                                <div className="mb-4">
                                    <img
                                        src={
                                            pengurus.foto
                                                ? `/storage/${pengurus.foto}`
                                                : "/images/default-profile.png"
                                        }
                                        alt={pengurus.nama}
                                        className="w-32 h-32 rounded-full object-cover shadow-md ring-2 ring-blue-100"
                                    />
                                </div>
                                <div className="text-center">
                                    <h3 className="font-bold text-lg text-gray-800">
                                        {pengurus.nama}
                                    </h3>
                                    <div className="mt-2">
                                        <span className="px-4 py-1 bg-blue-50 text-blue-600 rounded-full text-sm font-medium inline-block">
                                            {pengurus.jabatan}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                ) : (
                    <div className="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
                        <div className="overflow-x-auto">
                            <table className="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr className="bg-blue-600 text-white">
                                        <th
                                            scope="col"
                                            className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                                        >
                                            Jabatan
                                        </th>
                                        <th
                                            scope="col"
                                            className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider"
                                        >
                                            Nama
                                        </th>
                                    </tr>
                                </thead>
                                <tbody className="divide-y divide-gray-200">
                                    {pengurusLain.map((anggota, index) => (
                                        <tr
                                            key={index}
                                            className={
                                                index % 2 === 0
                                                    ? "bg-white"
                                                    : "bg-blue-50"
                                            }
                                        >
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <span className="text-sm font-medium text-gray-800">
                                                    {anggota.jabatan}
                                                </span>
                                            </td>
                                            <td className="px-6 py-4 whitespace-nowrap">
                                                <div className="text-sm text-gray-700">
                                                    {anggota.nama}
                                                </div>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                )}

                {/* Mobile View Toggle Button - Hanya untuk tampilan responsif */}
                <div className="mt-8 flex justify-center md:hidden">
                    <button
                        onClick={() =>
                            setActiveTab(
                                activeTab === "utama" ? "lainnya" : "utama"
                            )
                        }
                        className="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg shadow-sm transition-all flex items-center text-sm"
                    >
                        <span>
                            {activeTab === "utama"
                                ? "Lihat Pengurus Lainnya"
                                : "Kembali ke Pengurus Utama"}
                        </span>
                        <svg
                            className="w-4 h-4 ml-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth={2}
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    );
};

export default PengurusSection;
