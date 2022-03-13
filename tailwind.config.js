module.exports = {
    content: [
        "./assets/**/*.{vue,js,ts,jsx,tsx}",
        "./ui/back/templates/**/*.{html,twig}",
        "./ui/front/templates/**/*.{html,twig}",
        "./ui/common/templates/**/*.{html,twig}",
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
