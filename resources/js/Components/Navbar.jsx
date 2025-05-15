import React, { useState } from "react";
import { Link, usePage, router } from "@inertiajs/react";

const Navbar = () => {
    const { auth } = usePage().props; // Ambil data user dari Inertia
    const [isOpen, setIsOpen] = useState(false);
    const [isDropdownOpen, setIsDropdownOpen] = useState(false);

    const toggleMenu = () => {
        setIsOpen(!isOpen);
    };

    const toggleDropdown = () => {
        setIsDropdownOpen(!isDropdownOpen);
    };

    // Fungsi logout
    const handleLogout = (e) => {
        e.preventDefault();
        router.post("/logout");
    };

    return (
        <nav className="bg-white shadow-lg">
            <div className="max-w-6xl mx-auto px-4">
                <div className="flex justify-between items-center h-16">
                    {/* Logo */}
                    <div className="flex items-center">
                        <img
                            src="/images/logo_ppsg.svg"
                            alt="Logo"
                            className="h-10 w-10"
                        />
                        <span className="ml-2 text-xl font-semibold">
                            PPSG Candisingo
                        </span>
                    </div>

                    {/* Desktop Menu */}
                    <div className="hidden md:flex items-center space-x-8">
                        <Link
                            href="/"
                            className="text-gray-700 hover:text-blue-600 transition duration-300"
                        >
                            Home
                        </Link>
                        <Link
                            href="/anggota"
                            className="text-gray-700 hover:text-blue-600 transition duration-300"
                        >
                            Anggota
                        </Link>
                        <Link
                            href="/keuangan"
                            className="text-gray-700 hover:text-blue-600 transition duration-300"
                        >
                            Keuangan
                        </Link>
                        <Link
                            href="/presensi"
                            className="text-gray-700 hover:text-blue-600 transition duration-300"
                        >
                            Presensi
                        </Link>

                        {/* Dropdown Desktop */}
                        <div className="relative group z-50">
                            <button
                                onClick={toggleDropdown}
                                className="text-gray-700 hover:text-blue-600 transition duration-300 flex items-center"
                            >
                                Arsip
                                <svg
                                    className="ml-2 w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        strokeWidth="2"
                                        d="M19 9l-7 7-7-7"
                                    />
                                </svg>
                            </button>
                            <div className="absolute left-0 w-48 bg-white rounded-md shadow-lg hidden group-hover:block z-50">
                                <Link
                                    href="/arsip-rapat"
                                    className="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-500 rounded-md hover:text-white"
                                >
                                    Rapat
                                </Link>
                                <Link
                                    href="/arsip-program-kerja"
                                    className="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-500 rounded-md hover:text-white"
                                >
                                    Program Kerja
                                </Link>
                            </div>
                        </div>

                        <Link
                            href="/profile"
                            className="text-gray-700 hover:text-blue-600 transition duration-300"
                        >
                            Profil
                        </Link>

                        {/* Tampilkan Nama Pengguna dan Logout */}
                        {auth.user ? (
                            <div className="flex items-center space-x-4">
                                <button
                                    onClick={handleLogout}
                                    className="text-gray-700 hover:text-red-600 transition duration-300"
                                >
                                    Logout
                                </button>
                            </div>
                        ) : (
                            <Link
                                href="/login"
                                className="text-gray-700 hover:text-blue-600 transition duration-300"
                            >
                                Login
                            </Link>
                        )}
                    </div>

                    {/* Mobile Menu Button */}
                    <div className="md:hidden flex items-center">
                        <button
                            onClick={toggleMenu}
                            className="outline-none mobile-menu-button"
                        >
                            <svg
                                className="w-6 h-6 text-gray-500"
                                fill="none"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                strokeWidth="2"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                {isOpen ? (
                                    <path d="M6 18L18 6M6 6l12 12" />
                                ) : (
                                    <path d="M4 6h16M4 12h16M4 18h16" />
                                )}
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {/* Mobile Menu */}
            <div className={`md:hidden ${isOpen ? "block" : "hidden"}`}>
                <div className="px-2 pt-2 pb-3 space-y-1 sm:px-3 bg-white shadow-lg">
                    <Link
                        href="/"
                        className="block px-3 py-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100"
                    >
                        Home
                    </Link>
                    <Link
                        href="/anggota"
                        className="block px-3 py-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100"
                    >
                        Anggota
                    </Link>
                    <Link
                        href="/keuangan"
                        className="block px-3 py-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100"
                    >
                        Keuangan
                    </Link>
                    <Link
                        href="/presensi"
                        className="block px-3 py-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100"
                    >
                        Presensi
                    </Link>

                    <div>
                        <button
                            onClick={toggleDropdown}
                            className="flex justify-between items-center w-full px-3 py-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100"
                        >
                            Arsip
                            <svg
                                className={`w-4 h-4 transition-transform duration-200 ${
                                    isDropdownOpen ? "transform rotate-180" : ""
                                }`}
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    strokeWidth="2"
                                    d="M19 9l-7 7-7-7"
                                />
                            </svg>
                        </button>
                        {isDropdownOpen && (
                            <div className="pl-4">
                                <Link
                                    href="/arsip-rapat"
                                    className="block px-3 py-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100"
                                >
                                    Rapat
                                </Link>
                                <Link
                                    href="/arsip-program-kerja"
                                    className="block px-3 py-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100"
                                >
                                    Program Kerja
                                </Link>
                            </div>
                        )}
                    </div>

                    <Link
                        href="/profile"
                        className="block px-3 py-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100"
                    >
                        Profil Saya
                    </Link>

                    {!auth.user && (
                        <Link
                            href="/login"
                            className="block px-3 py-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-gray-100"
                        >
                            Login
                        </Link>
                    )}

                    {auth.user && (
                        <div className="mt-4">
                            <span className="block px-3 py-2 rounded-md text-blue-800">
                                {auth.user.name}
                            </span>
                            <button
                                onClick={handleLogout}
                                className="block w-full px-3 py-2 rounded-md text-red-700 hover:bg-gray-100"
                            >
                                Logout
                            </button>
                        </div>
                    )}
                </div>
            </div>
        </nav>
    );
};

export default Navbar;
