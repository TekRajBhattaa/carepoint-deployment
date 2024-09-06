import {
    useBlockProps,
    useInnerBlocksProps,
} from '@wordpress/block-editor';

const ALLOWED_BLOCKS = [
    'core/heading',
    'core/image',
    'core/paragraph',
    'core/buttons',
    'core/button'
];

const TEMPLATE = [
    ['core/image', {
        className: "featured__media",
        alt: '',
        href: '#',
        supports: { className: false }
    }],
    ['core/group',
        {
            className: 'featured__content',
            align: 'full'
        },
        [
            ['core/heading', {
                level: 3,
                placeholder: 'Headline',
                lock: {
                    move: false,
                    remove: true
                },
            }],
            ['core/paragraph', {
                placeholder: 'Subheading',
                className: "is-style-subheading",
            }],
            ['core/paragraph', {
                placeholder: 'Teaser Content',
                className: 'featured__desc',
                lock: {
                    move: false,
                    remove: true
                }
            }],
            ['core/buttons', {}, [
                ['core/button', {
                    className: "is-style-outline",
                    text: "Read more",
                    lock: {
                        move: true,
                        remove: false
                    }
                }]
            ]]
        ]
    ]
];

const LAYOUT = {
    type: 'default',
    alignments: [],
};

function Edit() {
    const blockProps = useBlockProps({ className: 'featured' });
    const innerBlocksProps = useInnerBlocksProps(blockProps, {
        allowedBlocks: ALLOWED_BLOCKS,
        template: TEMPLATE,
        templateInsertUpdatesSelection: true,
        __experimentalLayout: LAYOUT,
        templateLock: false,
    });

    return (
        <div {...innerBlocksProps}></div>
    );
}

export default Edit;
