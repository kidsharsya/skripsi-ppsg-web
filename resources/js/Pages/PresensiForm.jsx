import React, { useState, useEffect } from "react";
import MainLayout from "../Layouts/MainLayout";
import { useForm, router } from "@inertiajs/react";
import {
    CheckCircle,
    AlertCircle,
    MapPin,
    Clock,
    XCircle,
    AlertTriangle,
} from "lucide-react";
import { motion, AnimatePresence } from "framer-motion";
// Import Leaflet components
import { MapContainer, TileLayer, Marker, Popup, useMap } from "react-leaflet";
import "leaflet/dist/leaflet.css";
import L from "leaflet";

// Fix for default marker icons in React Leaflet
delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl:
        "https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon-2x.png",
    iconUrl: "https://unpkg.com/leaflet@1.7.1/dist/images/marker-icon.png",
    shadowUrl: "https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png",
});

// Component to update map view when position changes
function SetViewOnChange({ coords }) {
    const map = useMap();
    useEffect(() => {
        if (coords?.latitude && coords?.longitude) {
            map.setView([coords.latitude, coords.longitude], map.getZoom());
        }
    }, [coords, map]);
    return null;
}

// Toast notification for success and non-token errors only
const Toast = ({ toast, onDismiss }) => {
    if (!toast) return null;

    const colors = {
        success: "bg-green-50 border-green-200 text-green-700",
        error: "bg-red-50 border-red-200 text-red-700",
        warning: "bg-yellow-50 border-yellow-200 text-yellow-700",
        info: "bg-blue-50 border-blue-200 text-blue-700",
    };

    return (
        <AnimatePresence>
            <motion.div
                className="fixed top-4 left-0 right-0 flex justify-center z-[1000]"
                initial={{ opacity: 0, y: -50 }}
                animate={{ opacity: 1, y: 0 }}
                exit={{ opacity: 0, y: -50 }}
            >
                <motion.div
                    className={`${
                        colors[toast.type]
                    } border rounded-lg shadow-lg p-4 flex items-center max-w-md w-full mx-4`}
                >
                    <div className="mr-3">{toast.icon}</div>
                    <div>
                        <h3 className="font-semibold">{toast.title}</h3>
                        <p className="text-sm mt-1">{toast.message}</p>
                    </div>
                    <button
                        onClick={onDismiss}
                        className="ml-auto text-gray-400 hover:text-gray-600"
                    >
                        <XCircle className="h-5 w-5" />
                    </button>
                </motion.div>
            </motion.div>
        </AnimatePresence>
    );
};

export default function PresensiForm({ acara, error, success }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        token: "",
        status: "hadir",
        latitude: "",
        longitude: "",
        acara_id: acara.id,
        anggota_id: acara.anggota_id,
    });

    const [coords, setCoords] = useState({ latitude: "", longitude: "" });
    const [locationStatus, setLocationStatus] = useState("loading");
    const [toast, setToast] = useState(null);
    const [tokenError, setTokenError] = useState(null);
    const [mapReady, setMapReady] = useState(false);

    const showToast = (type, title, message, icon, duration = 3000) => {
        setToast({ type, title, message, icon });

        if (duration) {
            setTimeout(() => setToast(null), duration);
        }
    };

    const dismissToast = () => {
        setToast(null);
    };

    const showTokenError = (title, message, icon) => {
        setTokenError({ title, message, icon });
    };

    const dismissTokenError = () => {
        setTokenError(null);
    };

    useEffect(() => {
        if (navigator.geolocation) {
            const watchId = navigator.geolocation.watchPosition(
                (position) => {
                    const { latitude, longitude } = position.coords;
                    setCoords({ latitude, longitude });
                    setData((prevData) => ({
                        ...prevData,
                        latitude: latitude,
                        longitude: longitude,
                    }));
                    setLocationStatus("success");
                    setMapReady(true);

                    // No longer show this toast
                    // showToast("info", "Lokasi Ditemukan", ...)
                },
                (error) => {
                    console.error(error);
                    setLocationStatus("error");
                    showToast(
                        "error",
                        "Gagal Deteksi Lokasi",
                        "Pastikan GPS aktif dan izin lokasi diberikan.",
                        <AlertCircle className="h-5 w-5 text-red-500" />,
                        0
                    );
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0,
                }
            );

            return () => {
                navigator.geolocation.clearWatch(watchId);
            };
        } else {
            setLocationStatus("unsupported");
            showToast(
                "error",
                "Browser Tidak Didukung",
                "Browser Anda tidak mendukung fitur geolocation.",
                <AlertCircle className="h-5 w-5 text-red-500" />,
                0
            );
        }
    }, []);

    useEffect(() => {
        if (error) {
            showToast(
                "error",
                "Terjadi Kesalahan",
                error,
                <XCircle className="h-5 w-5 text-red-500" />,
                0
            );
        }
        if (success) {
            showToast(
                "success",
                "Sukses",
                success,
                <CheckCircle className="h-5 w-5 text-green-500" />,
                3000
            );
        }
    }, [error, success]);

    const submit = (e) => {
        e.preventDefault();

        // Clear any existing token error
        dismissTokenError();

        if (!coords.latitude || !coords.longitude) {
            showToast(
                "warning",
                "Lokasi Belum Tersedia",
                "Tunggu hingga lokasi Anda berhasil terdeteksi.",
                <AlertTriangle className="h-5 w-5 text-yellow-500" />,
                3000
            );
            return;
        }

        post(route("presensi.store"), {
            preserveScroll: true,
            onSuccess: () => {
                showToast(
                    "success",
                    "Presensi Berhasil!",
                    "Terima kasih sudah melakukan presensi.",
                    <CheckCircle className="h-5 w-5 text-green-500" />,
                    2000
                );
                reset();
                setTimeout(() => {
                    router.visit("/presensi");
                }, 2000);
            },
            onError: (errors) => {
                if (errors.message) {
                    let title = "Gagal Presensi";
                    let icon = <XCircle className="h-5 w-5 text-red-500" />;

                    if (errors.message.includes("Token tidak valid")) {
                        title = "Token Salah";
                        icon = <AlertCircle className="h-5 w-5 text-red-500" />;
                        // Show token error inline instead of toast
                        showTokenError(title, errors.message, icon);
                    } else if (
                        errors.message.includes(
                            "Token sudah kedaluwarsa, presensi telah ditutup"
                        )
                    ) {
                        title = "Presensi Ditutup";
                        icon = <Clock className="h-5 w-5 text-red-500" />;
                        // Show token error inline instead of toast
                        showTokenError(title, errors.message, icon);
                    } else if (
                        errors.message.includes(
                            "Tidak dapat presensi! Kamu berada di luar area lokasi acara"
                        )
                    ) {
                        title = "Di Luar Area";
                        icon = <MapPin className="h-5 w-5 text-red-500" />;
                        showToast("error", title, errors.message, icon, 0);
                    } else if (
                        errors.message.includes("Kamu sudah melakukan presensi")
                    ) {
                        title = "Sudah Presensi";
                        icon = <AlertCircle className="h-5 w-5 text-red-500" />;
                        showToast("error", title, errors.message, icon, 0);
                    } else {
                        showToast("error", title, errors.message, icon, 0);
                    }
                } else {
                    showToast(
                        "error",
                        "Input Tidak Valid",
                        "Pastikan input terisi dengan benar!",
                        <AlertCircle className="h-5 w-5 text-red-500" />,
                        0
                    );
                }
            },
        });
    };

    return (
        <MainLayout>
            {/* Toast for success and non-token errors only */}
            <Toast toast={toast} onDismiss={dismissToast} />

            <div className="max-w-4xl mx-auto py-8 px-4">
                <h1 className="text-2xl font-bold mb-6">
                    Presensi: {acara.nama}
                </h1>

                {/* Group 1: Lokasi dan Token */}
                <div className="flex flex-col md:flex-row gap-6">
                    {/* Location Map */}
                    <div className="w-full md:w-1/2 bg-white p-5 rounded-lg shadow-md">
                        <h3 className="text-lg font-semibold mb-3 flex items-center">
                            <MapPin className="h-5 w-5 mr-2 text-green-600" />
                            Lokasi Anda
                        </h3>

                        <div className="h-[250px] rounded overflow-hidden border">
                            {mapReady && coords.latitude && coords.longitude ? (
                                <MapContainer
                                    center={[coords.latitude, coords.longitude]}
                                    zoom={15}
                                    style={{ height: "100%", width: "100%" }}
                                >
                                    <TileLayer
                                        attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                                        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                                    />
                                    <Marker
                                        position={[
                                            coords.latitude,
                                            coords.longitude,
                                        ]}
                                    >
                                        <Popup>Anda di sini</Popup>
                                    </Marker>
                                    <SetViewOnChange coords={coords} />
                                </MapContainer>
                            ) : (
                                <div className="h-full flex items-center justify-center bg-gray-50">
                                    <div className="text-center">
                                        <div className="w-6 h-6 border-2 border-gray-300 border-t-green-500 rounded-full animate-spin mx-auto mb-2"></div>
                                        <p className="text-gray-600 text-sm">
                                            Mengambil lokasi...
                                        </p>
                                    </div>
                                </div>
                            )}
                        </div>

                        {coords.latitude && coords.longitude && (
                            <div className="text-xs text-gray-500 flex justify-between mt-2">
                                <span>Lat: {coords.latitude.toFixed(6)}</span>
                                <span>Long: {coords.longitude.toFixed(6)}</span>
                            </div>
                        )}
                    </div>

                    {/* Token Presensi */}
                    <div className="w-full md:w-1/2 bg-white p-5 rounded-lg shadow-md">
                        <form onSubmit={submit} className="space-y-5">
                            <div>
                                <label className="block mb-3 font-semibold text-gray-700">
                                    Token Presensi
                                </label>
                                <input
                                    type="text"
                                    value={data.token}
                                    onChange={(e) =>
                                        setData("token", e.target.value)
                                    }
                                    className="w-full border rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Masukkan token"
                                    required
                                />
                                {errors.token && (
                                    <p className="text-red-500 text-sm mt-1">
                                        {errors.token}
                                    </p>
                                )}

                                {/* Inline token error message */}
                                {tokenError && (
                                    <div className="mt-2 p-3 bg-red-50 border border-red-200 rounded-md flex items-start">
                                        <div className="mr-2 mt-0.5">
                                            {tokenError.icon}
                                        </div>
                                        <div>
                                            <h4 className="font-medium text-red-700">
                                                {tokenError.title}
                                            </h4>
                                            <p className="text-sm text-red-600">
                                                {tokenError.message}
                                            </p>
                                        </div>
                                        <button
                                            onClick={dismissTokenError}
                                            className="ml-auto text-red-400 hover:text-red-600"
                                        >
                                            <XCircle className="h-4 w-4" />
                                        </button>
                                    </div>
                                )}
                            </div>

                            <div className="bg-gray-50 rounded p-3">
                                <div className="flex items-center text-sm text-gray-600 gap-2">
                                    {locationStatus === "loading" && (
                                        <>
                                            <div className="w-4 h-4 border-2 border-gray-300 border-t-green-500 rounded-full animate-spin"></div>
                                            <span>Mengambil lokasi...</span>
                                        </>
                                    )}
                                    {locationStatus === "success" && (
                                        <div className="flex items-center text-green-600">
                                            <CheckCircle className="h-4 w-4 mr-1" />
                                            <span>Lokasi ditemukan</span>
                                        </div>
                                    )}
                                    {locationStatus === "error" && (
                                        <div className="flex items-center text-red-600">
                                            <XCircle className="h-4 w-4 mr-1" />
                                            <span>
                                                Gagal mendapatkan lokasi
                                            </span>
                                        </div>
                                    )}
                                    {locationStatus === "unsupported" && (
                                        <div className="flex items-center text-red-600">
                                            <AlertCircle className="h-4 w-4 mr-1" />
                                            <span>
                                                Browser tidak mendukung
                                                Geolocation
                                            </span>
                                        </div>
                                    )}
                                </div>
                            </div>

                            <button
                                type="submit"
                                disabled={
                                    processing || locationStatus !== "success"
                                }
                                className={`w-full flex items-center justify-center gap-2 px-4 py-3 rounded-md font-semibold text-white transition ${
                                    processing || locationStatus !== "success"
                                        ? "bg-gray-400 cursor-not-allowed"
                                        : "bg-green-600 hover:bg-green-700"
                                }`}
                            >
                                {processing ? (
                                    <>
                                        <div className="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                        <span>Memproses...</span>
                                    </>
                                ) : (
                                    <>
                                        <CheckCircle className="h-5 w-5" />
                                        <span>Kirim Presensi</span>
                                    </>
                                )}
                            </button>
                        </form>
                    </div>
                </div>

                {/* Group 2: Panduan & Informasi */}
                <div className="flex flex-col md:flex-row gap-6 mt-6">
                    {/* Panduan Presensi */}
                    <div className="w-full md:w-1/2 bg-white p-5 rounded-lg shadow-md">
                        <h3 className="text-lg font-semibold border-b mb-3 pb-2">
                            Panduan Presensi
                        </h3>
                        <ul className="space-y-2 text-sm text-gray-700">
                            {[
                                "Aktifkan GPS dan izinkan lokasi browser.",
                                "Masukkan token yang valid.",
                                "Pastikan dalam radius 20 meter dari lokasi.",
                                "Verifikasi posisi Anda di peta.",
                            ].map((item, idx) => (
                                <li
                                    key={idx}
                                    className="flex items-start gap-2"
                                >
                                    <CheckCircle className="h-4 w-4 text-green-600 mt-1" />
                                    <span>{item}</span>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Informasi Kegiatan */}
                    <div className="w-full md:w-1/2 bg-white p-5 rounded-lg shadow-md">
                        <h3 className="text-lg font-semibold mb-3 border-b pb-2">
                            Informasi Kegiatan
                        </h3>
                        <div className="space-y-3 text-sm text-gray-700">
                            <div>
                                <span className="font-medium text-gray-900 block mb-1">
                                    Deskripsi:
                                </span>
                                <p className="text-gray-700 break-words">
                                    {acara.deskripsi}
                                </p>
                            </div>
                            <div>
                                <span className="font-medium text-gray-900 block mb-1">
                                    Waktu Mulai:
                                </span>
                                <p className="text-gray-700">
                                    {new Date(acara.waktu_mulai).toLocaleString(
                                        "id-ID",
                                        {
                                            day: "numeric",
                                            month: "long",
                                            year: "numeric",
                                            hour: "2-digit",
                                            minute: "2-digit",
                                            hourCycle: "h23",
                                        }
                                    )}{" "}
                                    WIB
                                </p>
                            </div>
                            <div>
                                <span className="font-medium text-gray-900 block mb-1">
                                    Waktu Selesai:
                                </span>
                                <p className="text-gray-700">
                                    {new Date(
                                        acara.waktu_selesai
                                    ).toLocaleString("id-ID", {
                                        day: "numeric",
                                        month: "long",
                                        year: "numeric",
                                        hour: "2-digit",
                                        minute: "2-digit",
                                        hourCycle: "h23",
                                    })}{" "}
                                    WIB
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
