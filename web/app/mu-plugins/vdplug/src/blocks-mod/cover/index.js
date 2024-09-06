import { registerBlockStyle, registerBlockVariation } from '@wordpress/blocks';
import { ReactComponent as icon } from './icon.svg';

registerBlockStyle('core/cover', [
    {
        name: "banner",
        label: "Banner",
    },
    {
        name: "banner-without-border",
        label: "Banner without border",
    },

]);

registerBlockVariation('core/cover', {
    name: 'hero',
    title: 'Hero',
    icon,
    description: 'Hero is the new header variation using cover block.',
    isDefault: false,
    attributes: {
        className: 'hero',
        providerNameSlug: 'hero',
        useFeaturedImage: false,
        url: '/app/mu-plugins/vdplug/static/example-1920.jpg',
        customOverlayColor: "#FFF",
        minHeight: 400,
        minHeightUnit: 'px',
        align: 'full',
        backgroundColor: 'gray',
        overlayColor: '#eee',
        hasParallax: false,
        dimRatio: 0
    },
    innerBlocks: [
        ['core/columns', {}, [
            ['core/column', {}, [
                ['core/paragraph', {
                    className: 'is-style-subheading',
                    content: 'Block Variations'
                }],
                ['core/heading', {
                    level: 1,
                    content: 'Hero Header Block.'
                }],
                ['core/buttons', {}, [
                    ['core/button', {
                        className: "is-style-fill",
                        text: "Read more"
                    }]
                ]]
            ]],
            ['core/column', {}, [
                ['core/image', {
                    'id': 15,
                    'sizeSlug': 'large',
                    'linkDestination': 'none'
                }]
            ]]
        ]],

    ],
    example: {
        attributes: {
            url: "/app/mu-plugins/vdplug/static/example-1920.jpg"
        }
    },
    allowedBlocks: [
        'core/columns',
        'core/column',
        'core/heading',
        'core/paragraph',
        'core/buttons',
        'core/button',
        'core/post-author',
        'core/post-date',
        'core/post-title',
        'core/post-terms',
        'verdure/bloginfo',
        'gravityforms/form'
    ],
    isActive: ['className']
});
