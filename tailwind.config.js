module.exports = {
    content: [
        "./assets/**/*.{vue,js,ts,jsx,tsx}",
        "./ui/back/templates/**/*.{html,twig}",
        "./ui/front/templates/**/*.{html,twig}",
        "./ui/common/templates/**/*.{html,twig}"
    ],
    theme: {
        extend: {}
    },
    variants: {},
    plugins: [
        require('daisyui')
    ]
}
