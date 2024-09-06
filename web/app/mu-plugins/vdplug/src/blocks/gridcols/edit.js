import {
    BlockControls,
    useBlockProps,
    useInnerBlocksProps,
    InspectorControls
} from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import { Fragment } from '@wordpress/element';
import {
    Dashicon,
    ToolbarGroup,
    PanelBody,
    BaseControl,
    ToggleControl,
    TextControl,
} from '@wordpress/components';

function Edit({ attributes, setAttributes, isSelected }) {
    const { postLayout } = attributes;
    const blockProps = useBlockProps({
        className: `gridcols gridcols--${postLayout}`,
        style: {
            '--gridLayoutGap': attributes.gridLayoutGap.toString() + 'px',
            ...(attributes.gridMaxColumns ? { '--gridColumnCount': attributes.gridColumnCount.toString() } : {}),
            '--gridItemMinWidth': attributes.gridItemMinWidth.toString() + 'px',
            '--gridItemMaxWidth': attributes.gridMaxColumns ? 'calc((100% - var(--totalGapWidth)) / var(--gridColumnCount))' : attributes.gridItemMaxWidth.toString() + 'px'
        },
    });
    const innerBlocksProps = useInnerBlocksProps(blockProps, {
        templateInsertUpdatesSelection: true,
    });

    return (
        <Fragment>
            {isSelected && <>
                <InspectorControls>
                    <PanelBody
                        title={__('Slider Settings')}
                        initialOpen={true}
                    >
                        <BaseControl>
                            <ToggleControl
                                label={__('Set a column limit')}
                                checked={attributes.gridMaxColumns}
                                onChange={(state) =>
                                    setAttributes({
                                        gridMaxColumns: state,
                                    })
                                }
                            />
                        </BaseControl>
                        <BaseControl>
                            <TextControl
                                label={__("Grid Gap (px)")}
                                min={0}
                                max={60}
                                step={5}
                                value={attributes.gridLayoutGap}
                                type="number"
                                onChange={(val) => {
                                    setAttributes({
                                        gridLayoutGap: parseInt(val, 10),
                                    });
                                }}
                            />
                        </BaseControl>

                        <BaseControl>
                            <TextControl
                                label={__("Grid item min. width (px)")}
                                min={0}
                                max={600}
                                step={20}
                                value={attributes.gridItemMinWidth}
                                type="number"
                                onChange={(val) => {
                                    setAttributes({
                                        gridItemMinWidth: parseInt(val, 10),
                                    });
                                }}
                            />
                        </BaseControl>

                        {attributes.gridMaxColumns ?
                            <BaseControl>
                                <TextControl
                                    label={__("Grid column count")}
                                    min={1}
                                    max={6}
                                    value={attributes.gridColumnCount}
                                    type="number"
                                    onChange={(val) => {
                                        setAttributes({
                                            gridColumnCount: parseInt(val, 10),
                                        });
                                    }}
                                />
                            </BaseControl>
                            :
                            <BaseControl>
                                <TextControl
                                    label={__("Grid item min. width (px)")}
                                    min={0}
                                    max={600}
                                    step={20}
                                    value={attributes.gridItemMaxWidth}
                                    type="number"
                                    onChange={(val) => {
                                        setAttributes({
                                            gridItemMaxWidth: parseInt(val, 10),
                                        });
                                    }}
                                />
                            </BaseControl>}
                    </PanelBody>
                </InspectorControls>

                <BlockControls>
                    <ToolbarGroup controls={[
                        {
                            icon: <Dashicon icon="grid-view" />,
                            title: __('Grid view'),
                            onClick: () => setAttributes({ postLayout: 'grid' }),
                            isActive: postLayout === 'grid',
                        },
                        {
                            icon: <Dashicon icon="slides" />,
                            title: __('Slides view'),
                            onClick: () => setAttributes({ postLayout: 'slides' }),
                            isActive: postLayout === 'slides',
                        },
                    ]} />
                </BlockControls>
            </>}

            <div {...innerBlocksProps}>
                <div className='gridcols__inner'>{innerBlocksProps.children}</div>
            </div>
        </Fragment>
    );
}

export default Edit;
