import React, { useState } from "react";
import MainLayout from "../Layouts/MainLayout";
import { useForm, usePage, router } from "@inertiajs/react";
import { User, Save, ArrowBigLeft, CheckCircle, XCircle } from "lucide-react";
import { motion, AnimatePresence } from "framer-motion";

export default function Profile({ anggota }) {
    const { data, setData, put, processing, errors, reset } = useForm({
        nama: anggota?.nama || "",
        tempat_tgl_lahir: anggota?.tempat_tgl_lahir || "",
        jenis_kelamin: anggota?.jenis_kelamin || "",
        agama: anggota?.agama || "",
        rt: anggota?.rt || "",
        gol_darah: anggota?.gol_darah || "",
        no_hp: anggota?.no_hp || "",
    });

    const { flash } = usePage(); // Mengambil flash message dari response
    const [alertInfo, setAlertInfo] = useState(null);
    const alertStyles = {
        success: "bg-green-100 border-l-4 border-green-500 text-green-700",
        error: "bg-red-100 border-l-4 border-red-500 text-red-700",
    };
    const showAlert = (type, title, message, icon) => {
        setAlertInfo({ type, title, message, icon });
        if (type === "success") {
            // Segera redirect tanpa menunggu
            setAlertInfo({ type, title, message, icon });
        }
    };

    const submit = (e) => {
        e.preventDefault();
        put(route("profile.update"), {
            onSuccess: () => {
                showAlert(
                    "success",
                    "Profil Berhasil Diperbarui",
                    "Perubahan profil Anda telah disimpan.",
                    <CheckCircle className="h-5 w-5" />
                );
            },
            onError: (errors) => {
                showAlert(
                    "error",
                    "Terjadi Kesalahan",
                    "Periksa kembali inputan Anda.",
                    <XCircle className="h-5 w-5" />
                );
            },
        });
    };

    return (
        <MainLayout>
            {/* Alert Notification */}
            <AnimatePresence>
                {alertInfo && (
                    <motion.div
                        key="alert"
                        className={`p-4 mb-4 rounded-lg max-w-4xl mx-auto ${
                            alertStyles[alertInfo.type]
                        }`}
                        initial={{ opacity: 0 }}
                        animate={{ opacity: 1 }}
                        exit={{ opacity: 0 }}
                    >
                        <div className=" items-center">
                            <div className="mr-2">{alertInfo.icon}</div>
                            <div>
                                <h4 className="font-bold">{alertInfo.title}</h4>
                                <p>{alertInfo.message}</p>
                            </div>
                        </div>
                    </motion.div>
                )}
            </AnimatePresence>
            <div className="max-w-4xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
                {/* Header Card */}
                <div className="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-t-xl p-6 shadow-md">
                    <div className="flex items-center">
                        <div className="bg-white p-3 rounded-full mr-4">
                            <User size={24} className="text-blue-600" />
                        </div>
                        <h1 className="text-2xl font-bold text-white">
                            Edit Profil
                        </h1>
                    </div>
                    <p className="mt-2 text-blue-100 pl-12">
                        Perbarui informasi pribadi Anda
                    </p>
                </div>

                {/* Form Card */}
                <div className="bg-white rounded-b-xl shadow-lg p-6">
                    <form onSubmit={submit} className="space-y-6">
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {/* Column 1 */}
                            <div className="space-y-6">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">
                                        Nama Lengkap
                                    </label>
                                    <input
                                        type="text"
                                        value={data.nama}
                                        onChange={(e) =>
                                            setData("nama", e.target.value)
                                        }
                                        className="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        placeholder="Masukkan nama lengkap"
                                    />
                                    {errors.nama && (
                                        <div className="text-red-500 text-sm mt-1">
                                            {errors.nama}
                                        </div>
                                    )}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">
                                        Tempat & Tanggal Lahir
                                    </label>
                                    <input
                                        type="text"
                                        value={data.tempat_tgl_lahir}
                                        onChange={(e) =>
                                            setData(
                                                "tempat_tgl_lahir",
                                                e.target.value
                                            )
                                        }
                                        className="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        placeholder="Contoh: Jakarta, 01 Januari 1990"
                                    />
                                    {errors.tempat_tgl_lahir && (
                                        <div className="text-red-500 text-sm mt-1">
                                            {errors.tempat_tgl_lahir}
                                        </div>
                                    )}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">
                                        Jenis Kelamin
                                    </label>
                                    <select
                                        value={data.jenis_kelamin}
                                        onChange={(e) =>
                                            setData(
                                                "jenis_kelamin",
                                                e.target.value
                                            )
                                        }
                                        className="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    >
                                        <option value="" disabled selected>
                                            Pilih Jenis Kelamin
                                        </option>
                                        <option value="Laki-laki">
                                            Laki-laki
                                        </option>
                                        <option value="Perempuan">
                                            Perempuan
                                        </option>
                                    </select>
                                    {errors.jenis_kelamin && (
                                        <div className="text-red-500 text-sm mt-1">
                                            {errors.jenis_kelamin}
                                        </div>
                                    )}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">
                                        Agama
                                    </label>
                                    <input
                                        type="text"
                                        value={data.agama}
                                        onChange={(e) =>
                                            setData("agama", e.target.value)
                                        }
                                        className="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        placeholder="Masukkan agama"
                                    />
                                    {errors.agama && (
                                        <div className="text-red-500 text-sm mt-1">
                                            {errors.agama}
                                        </div>
                                    )}
                                </div>
                            </div>

                            {/* Column 2 */}
                            <div className="space-y-6">
                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">
                                        RT
                                    </label>
                                    <select
                                        value={data.rt}
                                        onChange={(e) =>
                                            setData("rt", e.target.value)
                                        }
                                        className="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    >
                                        <option value="" disabled selected>
                                            Pilih RT
                                        </option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                    </select>
                                    {errors.rt && (
                                        <div className="text-red-500 text-sm mt-1">
                                            {errors.rt}
                                        </div>
                                    )}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">
                                        Golongan Darah
                                    </label>
                                    <select
                                        value={data.gol_darah}
                                        onChange={(e) =>
                                            setData("gol_darah", e.target.value)
                                        }
                                        className="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    >
                                        <option value="" disabled selected>
                                            Pilih Golongan Darah
                                        </option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                        <option value="O">Tidak tahu</option>
                                    </select>
                                    {errors.gol_darah && (
                                        <div className="text-red-500 text-sm mt-1">
                                            {errors.gol_darah}
                                        </div>
                                    )}
                                </div>

                                <div>
                                    <label className="block text-sm font-medium text-gray-700 mb-1">
                                        Nomor HP
                                    </label>
                                    <input
                                        type="text"
                                        value={data.no_hp}
                                        onChange={(e) =>
                                            setData("no_hp", e.target.value)
                                        }
                                        className="w-full border border-gray-300 px-4 py-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        placeholder="Contoh: 08123456789"
                                    />
                                    {errors.no_hp && (
                                        <div className="text-red-500 text-sm mt-1">
                                            {errors.no_hp}
                                        </div>
                                    )}
                                </div>
                            </div>
                        </div>

                        <div className="border-t border-gray-200 pt-6 flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-3">
                            <button
                                type="button"
                                onClick={() => router.visit("/profile")} // Mengarahkan ke /profile
                                className="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                <ArrowBigLeft size={16} className="mr-2" />
                                Kembali
                            </button>

                            <button
                                type="submit"
                                disabled={processing}
                                className="inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            >
                                <Save size={16} className="mr-2" />
                                {processing
                                    ? "Menyimpan..."
                                    : "Simpan Perubahan"}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </MainLayout>
    );
}
