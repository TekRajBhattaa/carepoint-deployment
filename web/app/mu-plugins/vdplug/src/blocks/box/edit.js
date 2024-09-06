import {
    InnerBlocks,
    useBlockProps,
} from '@wordpress/block-editor';

function Edit() {
    const blockProps = useBlockProps({ className: 'box' });

    return (
        <div {...blockProps}>
            <InnerBlocks />
        </div>
    );
}

export default Edit;
