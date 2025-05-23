import React from "react";

const HeroSection = ({ homeContent }) => {
    return (
        <>
            {/* Hero Section */}
            <section className="text-white py-24 text-center relative overflow-hidden">
                <div className="absolute inset-0">
                    <div
                        className="absolute inset-0 bg-center bg-cover"
                        style={{
                            backgroundImage: homeContent.banner_image
                                ? `url(/storage/public/${homeContent.banner_image})`
                                : "url('/api/placeholder/1200/400')",
                        }}
                    ></div>
                    <div className="absolute inset-0 bg-gradient-to-b from-black/70 via-black/50 to-black/30"></div>
                </div>
                <div className="container mx-auto px-4 relative z-10">
                    <h1 className="text-4xl font-bold mb-2 tracking-tight leading-tight drop-shadow-md">
                        {homeContent.hero_title || "PPSG Candisingo"}
                    </h1>
                    <div className="h-1 w-24 bg-yellow-400 mx-auto my-6"></div>
                    <p className="text-xl mt-4 max-w-2xl mx-auto font-light drop-shadow-md">
                        {homeContent.hero_subtitle ||
                            "Bersatu, Berkarya, Berkontribusi untuk Desa"}
                    </p>
                </div>
            </section>

            {/* Tentang Organisasi Section */}
            <section className="max-w-6xl mx-auto px-4 py-16 relative">
                <div className="absolute -top-10 left-1/2 transform -translate-x-1/2 w-20 h-20 rounded-full bg-white shadow-lg flex items-center justify-center">
                    <div className="text-blue-600 text-3xl font-bold">?</div>
                </div>
                <div className="text-3xl font-bold mb-8 text-center">
                    {homeContent?.section1 || "Tentang Organisasi"}
                </div>
                <div className="bg-white rounded-xl shadow-xl p-8 border-l-4 border-blue-600 mb-10">
                    <p className="text-gray-700 text-lg leading-relaxed">
                        {homeContent.deskripsi ||
                            "PPSG Candisingo adalah organisasi kepemudaan yang bertujuan untuk menghimpun, mengarahkan, dan memberdayakan potensi generasi muda di wilayah Candisingo. Kami aktif dalam kegiatan sosial, keagamaan, dan pembangunan masyarakat demi kemajuan desa."}
                    </p>
                </div>

                <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {/* VISI */}
                    <div className="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div className="bg-gradient-to-r from-blue-600 to-blue-800 h-16 flex items-center justify-center">
                            <h3 className="text-xl font-bold text-white">
                                VISI
                            </h3>
                        </div>
                        <div className="p-6">
                            <p className="text-gray-700 leading-relaxed">
                                {homeContent.visi ||
                                    "Mewujudkan generasi muda yang berkarakter, inovatif, dan berkontribusi aktif bagi pembangunan desa Candisingo yang mandiri, maju, dan bermartabat."}
                            </p>
                            <div className="mt-4 flex items-start bg-blue-50 p-4 rounded-lg">
                                <div className="w-8 h-8 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center mr-3 mt-1">
                                    <span className="text-white text-sm">
                                        💭
                                    </span>
                                </div>
                                <p className="text-blue-800 italic text-sm">
                                    "Keberhasilan sejati adalah ketika generasi
                                    muda mampu menjadi agen perubahan yang
                                    bermanfaat bagi lingkungannya."
                                </p>
                            </div>
                        </div>
                    </div>

                    {/* MISI */}
                    <div className="bg-white rounded-xl shadow-lg overflow-hidden">
                        <div className="bg-gradient-to-r from-blue-600 to-blue-800 h-16 flex items-center justify-center">
                            <h3 className="text-xl font-bold text-white">
                                MISI
                            </h3>
                        </div>
                        <div className="p-6">
                            <ul className="space-y-3">
                                {homeContent.misi &&
                                Array.isArray(homeContent.misi) &&
                                homeContent.misi.length > 0 ? (
                                    homeContent.misi.map((item, index) => (
                                        <li key={index} className="flex">
                                            <div className="w-6 h-6 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center mr-3 mt-1">
                                                <span className="text-white text-xs">
                                                    {index + 1}
                                                </span>
                                            </div>
                                            <p className="text-gray-700">
                                                {item.value}
                                            </p>
                                        </li>
                                    ))
                                ) : (
                                    <>
                                        <li className="flex">
                                            <div className="w-6 h-6 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center mr-3 mt-1">
                                                <span className="text-white text-xs">
                                                    1
                                                </span>
                                            </div>
                                            <p className="text-gray-700">
                                                Menghimpun dan membina potensi
                                                generasi muda di wilayah
                                                Candisingo
                                            </p>
                                        </li>
                                        <li className="flex">
                                            <div className="w-6 h-6 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center mr-3 mt-1">
                                                <span className="text-white text-xs">
                                                    2
                                                </span>
                                            </div>
                                            <p className="text-gray-700">
                                                Melaksanakan kegiatan yang
                                                membangun karakter, ketrampilan,
                                                dan jiwa sosial
                                            </p>
                                        </li>
                                        <li className="flex">
                                            <div className="w-6 h-6 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center mr-3 mt-1">
                                                <span className="text-white text-xs">
                                                    3
                                                </span>
                                            </div>
                                            <p className="text-gray-700">
                                                Membangun jejaring kerjasama
                                                yang sinergis dengan berbagai
                                                pihak
                                            </p>
                                        </li>
                                        <li className="flex">
                                            <div className="w-6 h-6 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center mr-3 mt-1">
                                                <span className="text-white text-xs">
                                                    4
                                                </span>
                                            </div>
                                            <p className="text-gray-700">
                                                Mengembangkan inovasi sosial
                                                yang bermanfaat bagi masyarakat
                                            </p>
                                        </li>
                                        <li className="flex">
                                            <div className="w-6 h-6 rounded-full bg-blue-600 flex-shrink-0 flex items-center justify-center mr-3 mt-1">
                                                <span className="text-white text-xs">
                                                    5
                                                </span>
                                            </div>
                                            <p className="text-gray-700">
                                                Berkontribusi aktif dalam
                                                pembangunan desa Candisingo
                                            </p>
                                        </li>
                                    </>
                                )}
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
        </>
    );
};

export default HeroSection;
