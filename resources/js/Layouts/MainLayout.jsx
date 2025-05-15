import React from "react";
import { usePage } from "@inertiajs/inertia-react";
import Navbar from "../Components/Navbar";
import Footer from "../Components/Footer";
import { Toaster } from "react-hot-toast";

export default function MainLayout({ children }) {
    return (
        <div className="min-h-screen flex flex-col">
            <Navbar />
            <main className="flex-grow w-full max-w-6xl mx-auto py-4 sm:py-6 px-2 sm:px-4">
                {children}
                <Toaster />
            </main>
            <Footer />
        </div>
    );
}
