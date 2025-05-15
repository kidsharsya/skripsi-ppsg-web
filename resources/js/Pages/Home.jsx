import React, { useState } from "react";
import MainLayout from "../Layouts/MainLayout";
import HeroSection from "@/Components/HeroSection";
import StatistikSection from "@/Components/StatistikSection";
import PengurusSection from "../Components/PengurusSection";
import GaleriSection from "../Components/GaleriSection";

export default function Home({ homeContent, stats, pengurus, galeri }) {
    return (
        <MainLayout>
            {/* Hero Section - Menggunakan data dari backend */}
            <HeroSection homeContent={homeContent} />

            {/* Statistik dengan highlight dan icon */}
            <StatistikSection homeContent={homeContent} stats={stats} />

            {/* Struktur Kepengurusan dengan model tampilan pengurus utama dan tombol lihat selengkapnya */}
            <PengurusSection homeContent={homeContent} pengurus={pengurus} />

            {/* Galeri Dokumentasi dengan desain yang lebih menarik */}
            <GaleriSection homeContent={homeContent} galeri={galeri} />

            {/* Lokasi dengan judul yang lebih menarik */}
            <section className="py-16 px-4">
                <div className="max-w-6xl mx-auto">
                    <div className="text-3xl font-bold text-center mb-3">
                        {homeContent?.section6 || "Lokasi Kami"}
                    </div>
                    <div className="h-1 w-24 bg-blue-600 mx-auto mb-6"></div>
                    <div className="relative shadow-xl rounded-xl overflow-hidden">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1976.51089281773!2d110.48502059999998!3d-7.787514599999991!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5a83270f27cd%3A0xd834882284d41a11!2sDusun%20Candisingo!5e0!3m2!1sid!2sid!4v1745944817665!5m2!1sid!2sid"
                            width="100%"
                            height="450"
                            style={{ border: 0 }}
                            allowFullScreen=""
                            loading="lazy"
                            referrerPolicy="no-referrer-when-downgrade"
                            className="z-10"
                        ></iframe>
                        <div className="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-gray-800 to-transparent p-6 text-white z-20">
                            <div className="flex items-center space-x-4">
                                <div className="rounded-full bg-white p-3">
                                    <span className="text-blue-600 text-xl">
                                        📍
                                    </span>
                                </div>
                                <div>
                                    <h3 className="font-bold text-xl">
                                        Sekretariat PPSG Candisingo
                                    </h3>
                                    <p>
                                        Dusun Candisingo, Madurejo, Prambanan,
                                        Sleman, Yogyakarta
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </MainLayout>
    );
}
