import { useBlockProps, useInnerBlocksProps } from '@wordpress/block-editor';

function Save({ attributes }) {
    const { postLayout } = attributes;
    const blockProps = useBlockProps.save({
        className: `gridcols gridcols--${postLayout}`,
        style: {
            '--gridLayoutGap': attributes.gridLayoutGap.toString() + 'px',
            ...(attributes.gridMaxColumns ? { '--gridColumnCount': attributes.gridColumnCount.toString() } : {}),
            '--gridItemMinWidth': attributes.gridItemMinWidth.toString() + 'px',
            '--gridItemMaxWidth': attributes.gridMaxColumns ? 'calc((100% - var(--totalGapWidth)) / var(--gridColumnCount))' : attributes.gridItemMaxWidth.toString() + 'px'
        }
    });
    const innerBlocksProps = useInnerBlocksProps.save(blockProps);

    return (
        <div {...innerBlocksProps}>
            <div className='gridcols__inner'>{innerBlocksProps.children}</div>
        </div>
    );
}

export default Save;
