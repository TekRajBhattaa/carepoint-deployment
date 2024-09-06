/**
 * THIS FILE DOES NOT USE WEBPACK
 * domReady didn't work even the correct dependencies are added?!
 */

const allowedEmbedVariants = [
    'youtube',
    'facebook',
    'twitter',
    'vimeo',
    'instagram',
    'pocket-casts'
];

wp.domReady(() => {
    const embedVariants = wp.blocks.getBlockVariations('core/embed');
    if (Array.isArray(embedVariants)) {
        embedVariants.forEach(variant => {
            if (!allowedEmbedVariants.includes(variant.name)) {
                wp.blocks.unregisterBlockVariation('core/embed', variant.name);
            }
        });
    }
    else {
        console.warn('No embed variants found!');
    }
})
