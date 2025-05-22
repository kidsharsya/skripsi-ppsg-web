import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import tailwindcss from "tailwindcss";

export default defineConfig({
    plugins: [
        react(),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.jsx"],
            refresh: true,
        }),
    ],
    server: {
        host: true, // agar bisa diakses dari device lain
        port: 5173, // default Vite port, sesuaikan jika kamu ubah
        hmr: {
            protocol: "wss",
            host: "bba8-103-19-180-14.ngrok-free.app", // atau IP kamu, tergantung kondisi
            clientPort: 443,
        },
    },
    css: {
        postcss: {
            plugins: [tailwindcss()],
        },
    },
});
