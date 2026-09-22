import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
            fonts: [
                {
                    family: "Instrument Sans",
                    alias: "sans",
                    provider: "google",
                    variable: "--font-sans",
                    weights: [400, 500, 600, 700],
                    styles: ["normal"],
                    subsets: ["latin"],
                    display: "swap",
                    preload: true,
                    fallbacks: [],
                    optimizedFallbacks: false,
                },
            ],
        }),
        tailwindcss(),
    ],
});
