import { useBlockProps, InspectorControls,useInnerBlocksProps } from "@wordpress/block-editor";
import { BaseControl, PanelBody, PanelRow, TextControl } from '@wordpress/components';
export default function Edit({ attributes, setAttributes, isSelected }) {
    const blockProps = useBlockProps({
        className: "counter",
        style: {
            '--gridGap': `${attributes.gridGap}px`,
            '--minWidth': `${attributes.minWidth}px`
        }
    },
    {
        allowedBlocks: ["verdure/counter-item"]
    }
    );
    const innerBlocksProps = useInnerBlocksProps(blockProps, {
        template: [
            ["verdure/counter-item", {
                placeholder: "Counter Item"
            }]
        ],
    });

    const inspectorControls = (
        <InspectorControls>
            <PanelBody title='Counter Settings'>
                <PanelRow>
                    <BaseControl>
                        <TextControl
                            label='Grid Columns'
                            value={attributes.gridColumns}
                            type="number"
                            onChange={newValue => setAttributes({ gridColumns: parseInt(newValue, 10) })}
                        />
                    </BaseControl>
                </PanelRow>
                <PanelRow>
                    <BaseControl>
                        <TextControl
                            label='Grid min. width'
                            value={attributes.minWidth}
                            type="number"
                            onChange={newValue => setAttributes({ minWidth: parseInt(newValue, 10) })}
                        />
                    </BaseControl>
                </PanelRow>
            </PanelBody>
        </InspectorControls>
    )

    return <>
        {isSelected && inspectorControls}

        <div {...innerBlocksProps} />
    </>
}
