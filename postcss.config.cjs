module.exports = (ctx) => ({
    plugins: [
        require('@csstools/postcss-global-data')({
            files: [
                './web/app/themes/vdclassic/src/config/custom.css'
            ],
        }),
        require('postcss-nested'),
        require('postcss-media-minmax'),
        require('postcss-custom-media')({
            preserve: false,
        }),
        require('autoprefixer'),
        require('cssnano'),
    ],
});
