module.exports = {
    content: [
        "./assets/**/*.{vue,js,ts,jsx,tsx}",
        "./templates/**/*.{html,twig}",
        "./vendor/symfony/twig-bridge/Resources/views/Form/tailwind_2_layout.html.twig"
    ],
    theme: {
        extend: {}
    },
    variants: {},
    plugins: [
        require('daisyui'),
        require('@tailwindcss/forms'),
    ]
}
