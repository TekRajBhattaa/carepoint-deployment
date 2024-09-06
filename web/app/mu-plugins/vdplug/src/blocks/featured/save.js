import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

function Save() {
    const blockProps = useBlockProps.save({ className: 'featured' });
    const innerBlocksProps = useInnerBlocksProps.save(blockProps);

    return (
        <div {...innerBlocksProps}>
            {innerBlocksProps.children}
        </div>
    );
}

export default Save;
