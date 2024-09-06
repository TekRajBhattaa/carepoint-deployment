import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

function save() {
    const blockProps = useBlockProps.save({ className: 'box' });

    return (
        <div {...blockProps}>
            <InnerBlocks.Content />
        </div>
    );
}

export default save;
