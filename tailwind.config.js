import defaultTheme from 'tailwindcss/defaultTheme';
import { defineConfig } from 'tailwindcss';

export default defineConfig({
    darkMode: 'class',
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.ts',
        './resources/**/*.vue',
        './vendor/livewire/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Instrument Sans', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
});
