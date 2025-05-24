import React, { useState } from "react";

const GaleriSection = ({ homeContent, galeri }) => {
    const [selectedImage, setSelectedImage] = useState(null);

    // Filter active gallery items
    const activeGaleri = galeri.filter((item) => item.is_active);

    // Handle image click to open modal
    const openModal = (image) => {
        setSelectedImage(image);
    };

    // Close modal
    const closeModal = () => {
        setSelectedImage(null);
    };

    return (
        <section className="bg-gray-100 py-16">
            <div className="max-w-7xl mx-auto px-4 sm:px-6">
                {/* Section Header */}
                <div className="text-center mb-16">
                    <h2 className="text-3xl font-bold mb-3">
                        {homeContent?.section4 || "Galeri Dokumentasi"}
                    </h2>
                    <div className="h-1 w-24 bg-blue-600 mx-auto"></div>
                </div>

                {/* Gallery Grid - 1 column on mobile, 3 columns on desktop */}
                <div className="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                    {activeGaleri.map((item, i) => (
                        <div
                            key={i}
                            className="group cursor-pointer relative overflow-hidden rounded-xl shadow-lg transform transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                            onClick={() => openModal(item)}
                        >
                            <div className="aspect-w-16 aspect-h-12 h-64 md:h-72 w-full">
                                <img
                                    src={item.image_url}
                                    alt={`Dokumentasi ${item.judul}`}
                                    className="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                                />
                            </div>

                            {/* Gradient overlay visible on hover */}
                            <div className="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end">
                                <div className="p-4 text-white w-full">
                                    <h3 className="font-bold text-lg md:text-xl">
                                        {item.judul}
                                    </h3>
                                    {item.deskripsi && (
                                        <p className="text-sm text-gray-200 mt-1 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                            {item.deskripsi.length > 80
                                                ? `${item.deskripsi.substring(
                                                      0,
                                                      80
                                                  )}...`
                                                : item.deskripsi}
                                        </p>
                                    )}
                                </div>
                            </div>
                        </div>
                    ))}
                </div>

                {/* Pagination for large galleries (optional) */}
                {activeGaleri.length > 9 && (
                    <div className="mt-12 flex justify-center">
                        <nav className="flex items-center space-x-2">
                            <button className="px-3 py-1 bg-white rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                                Prev
                            </button>
                            <button className="px-3 py-1 bg-blue-600 rounded text-white">
                                1
                            </button>
                            <button className="px-3 py-1 bg-white rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                                2
                            </button>
                            <button className="px-3 py-1 bg-white rounded border border-gray-300 text-gray-700 hover:bg-gray-50">
                                Next
                            </button>
                        </nav>
                    </div>
                )}

                {/* Modal for image preview */}
                {selectedImage && (
                    <div
                        className="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80"
                        onClick={closeModal}
                    >
                        <div
                            className="relative max-w-4xl w-full bg-white rounded-lg overflow-hidden shadow-2xl"
                            onClick={(e) => e.stopPropagation()}
                        >
                            <div className="relative aspect-w-16 aspect-h-9">
                                <img
                                    src={`${selectedImage.image_url}`}
                                    alt={selectedImage.judul}
                                    className="w-full h-full object-contain"
                                />
                            </div>
                            <div className="p-4 bg-white">
                                <h3 className="text-xl font-bold text-gray-900">
                                    {selectedImage.judul}
                                </h3>
                                {selectedImage.deskripsi && (
                                    <p className="mt-2 text-gray-600">
                                        {selectedImage.deskripsi}
                                    </p>
                                )}
                                <button
                                    className="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                    onClick={closeModal}
                                >
                                    Tutup
                                </button>
                            </div>
                            <button
                                className="absolute top-2 right-2 w-8 h-8 flex items-center justify-center rounded-full bg-white/80 text-gray-800 hover:bg-white"
                                onClick={closeModal}
                            >
                                ✕
                            </button>
                        </div>
                    </div>
                )}
            </div>
        </section>
    );
};

export default GaleriSection;
