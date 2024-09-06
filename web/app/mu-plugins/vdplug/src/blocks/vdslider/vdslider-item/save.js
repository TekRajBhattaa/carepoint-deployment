import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

export default function save() {
    const blockProps = useBlockProps.save({
        className: 'swiper-item swiper-slide',
    });
    const innerBlocksProps = useInnerBlocksProps.save(blockProps);

    return <div {...innerBlocksProps}></div>;
}
