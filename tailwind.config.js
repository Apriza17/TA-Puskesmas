/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                50:'#e9f7fb',100:'#d7eef8',200:'#b5e0f1',300:'#8ecfe9',
                400:'#66bde0',500:'#3ea7d4',600:'#2f89b1',700:'#276f90',
                800:'#1f5873',900:'#1a465b',
                }
            },
            boxShadow: {
                soft: '0 10px 30px rgba(16,24,40,.06)',
            },
            borderRadius: {
                xl2: '1.25rem'
            }
        },
    },
    plugins: [
        require('tailwindcss-animated')
    ],
};
