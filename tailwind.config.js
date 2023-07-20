const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    a1: "#0095D9",
                    a2: "#2F80ED",
                    v1: "#FF161F",
                    v2: "#F04124",
                    prfA1: "#000E4B",
                },
                fill: {
                    base: "#F7F7F7",
                },
                gray: {
                    1: "#333333",
                    2: "#4F4F4F",
                    3: "#828282",
                    4: "#BDBDBD",
                    5: "#E0E0E0",
                    6: "#F2F2F2",
                    7: "#D6E4EE",
                    8: "#757575",
                },
                feedback: {
                    green: {
                        1: "#219653",
                        2: "#27AE60",
                    },
                    purple: "#BB6BD9",
                    orange: "#E59146",
                    fill: {
                        green: "#E7FFF1",
                        purple: "#FAECFF",
                        orange: "#FFF8F2",
                        blue: "#E9F8FF",
                    },
                },
                alert: {
                    success: {
                        fill: "#EBFBEE",
                        base: "#2B8A3E",
                    },
                    error: {
                        fill: "#FBDBDB",
                        base: "#8E1014",
                    },
                },
                input: {
                    error: "#CD191E",
                },
            },
            fontSize: {
                32: "2rem",
                "1.5xl": "1.375rem",
            },
            fontFamily: {
                poppins: ["Poppins"],
                "open-sans": ["'Open Sans', 'sans-serif'"],
            },
            container: {
                center: true,
                padding: "1.5rem",
            },
            gridTemplateColumns: {
                "main-expanded": "231px 1fr",
                "main-colapsed": "80px 1fr",
            },
            gridTemplateRows: {
                "main-mobile": "1fr 70px",
                "table-view": "84px 6fr 1fr",
            },
            screens: {
                xl: "1280px",
                "2xl": "1280px",
            },
        },
    },
    plugins: [],
};
