/** @type {import('tailwindcss').Config} */
export default {
    important: true,
    darkMode: "class",
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                "app-primary": {
                    100: "#ccd4f9",
                    200: "#b1befb",
                    300: "#94a7fb",
                    400: "#8198fd",
                    500: "#8fa1fa",
                    600: "#415bc5",
                    700: "#2a42a1",
                    800: "#213cb1",
                    900: "#0f247d",
                },
                "app-secondary": {
                    100: "#59696b",
                    200: "#455b5e",
                    300: "#466468",
                    400: "#2b4649",
                    500: "#264b50",
                    600: "#235d64",
                    700: "#155e66",
                    800: "#096670",
                    900: "#004850",
                },
            },
        },
    },
    plugins: [],
};
