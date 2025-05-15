import React from "react";

const StatisticSection = ({ homeContent, stats }) => {
    return (
        <section className="py-16 bg-gradient-to-b from-white to-gray-50">
            <div className="max-w-6xl mx-auto px-4">
                <div className="text-3xl font-bold text-center mb-12">
                    {homeContent?.section2 || "Pencapaian Kami"}
                </div>
                <div className="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                    <div className="bg-white p-6 rounded-lg shadow-lg border-t-4 border-blue-600 transform hover:-translate-y-1 transition-all">
                        <div className="text-5xl font-extrabold text-blue-600 mb-2">
                            {stats.anggotaAktif}
                        </div>
                        <p className="text-gray-700 font-medium">
                            Anggota Aktif
                        </p>
                    </div>
                    <div className="bg-white p-6 rounded-lg shadow-lg border-t-4 border-blue-600 transform hover:-translate-y-1 transition-all">
                        <div className="text-5xl font-extrabold text-blue-600 mb-2">
                            {stats.programKerja}
                        </div>
                        <p className="text-gray-700 font-medium">
                            Program Kerja
                        </p>
                    </div>
                    <div className="bg-white p-6 rounded-lg shadow-lg border-t-4 border-blue-600 transform hover:-translate-y-1 transition-all">
                        <div className="text-5xl font-extrabold text-blue-600 mb-2">
                            {stats.rapatTerlaksana}
                        </div>
                        <p className="text-gray-700 font-medium">
                            Rapat Terlaksana
                        </p>
                    </div>
                    <div className="bg-white p-6 rounded-lg shadow-lg border-t-4 border-blue-600 transform hover:-translate-y-1 transition-all">
                        <div className="text-5xl font-extrabold text-blue-600 mb-2">
                            {stats.rtTerlibat}
                        </div>
                        <p className="text-gray-700 font-medium">RT Terlibat</p>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default StatisticSection;
