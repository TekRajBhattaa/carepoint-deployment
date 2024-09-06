import { useBlockProps, useInnerBlocksProps } from "@wordpress/block-editor";

export default function Save({ attributes }) {
    const blockProps = useBlockProps.save({
        className: "counter",
        style: {
            '--gridGap': `${attributes.gridGap}px`,
            '--minWidth': `${attributes.minWidth}px`
        }
    });
    const innerBlocksProps = useInnerBlocksProps.save(blockProps);

    return <div {...innerBlocksProps}></div>;
}
