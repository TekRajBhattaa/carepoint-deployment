import { __ } from "@wordpress/i18n";
import {
    useBlockProps,
    useInnerBlocksProps,
    InspectorControls,
    RichText
} from "@wordpress/block-editor";
import classnames from "classnames";
import { Fragment } from "@wordpress/element";
import {
    Panel,
    PanelBody,
    BaseControl,
    ToggleControl,
    SelectControl,
    TextControl
} from "@wordpress/components";
import "./editor.css";

const TEMPLATE = [
    // ['verdure/vdslider-item']
];

const ALLOWED_BLOCKS = ["verdure/vdslider-item"];
const LAYOUT = {
    type: "default",
    alignments: [],
};

export default function Edit({ attributes, setAttributes, isSelected }) {

    const { smallHeading, heading } = attributes;


    const onChangeText = (newText) => {
        setAttributes({ smallHeading: newText });
    };
    const onChangeText2 = (newText) => {
        setAttributes({ heading: newText });
    };
    const blockProps = useBlockProps({
        className: classnames({
            "vdslider": true,
            "vdslider--has-navigation": attributes.hasNavigation,
            "vdslider--has-pagination": attributes.hasPagination,
            "vdslider--has-loop": attributes.hasLoop
        }),
        ...(attributes.className.includes("vdslider--hornetbox")) && { 'data-spacebetween': attributes.spaceBetween, 'data-maxitems': attributes.maxDesktopItems },
    });

    const innerBlocksProps = useInnerBlocksProps(blockProps, {
        allowedBlocks: ALLOWED_BLOCKS,
        template: TEMPLATE,
        templateInsertUpdatesSelection: true,
        __experimentalLayout: LAYOUT,
        templateLock: false,
    });

    return (
        <Fragment>
            <InspectorControls>
                {isSelected && (
                    <Panel>
                        <PanelBody
                            title={__("Slider Settings")}
                            initialOpen={true}
                        >
                            <BaseControl>
                                <h4>{attributes.providerNameSlug}</h4>
                            </BaseControl>

                            <BaseControl>
                                <ToggleControl
                                    label={__("Enable Navigation")}
                                    checked={attributes.hasNavigation}
                                    onChange={(state) =>
                                        setAttributes({
                                            hasNavigation: state,
                                        })
                                    }
                                />
                            </BaseControl>

                            <BaseControl>
                                <ToggleControl
                                    label={__("Enable Pagination")}
                                    checked={attributes.hasPagination}
                                    onChange={(state) =>
                                        setAttributes({
                                            hasPagination: state,
                                        })
                                    }
                                />
                            </BaseControl>

                            <BaseControl>
                                <ToggleControl
                                    label={__("Enable Loop")}
                                    checked={attributes.hasLoop}
                                    onChange={(state) =>
                                        setAttributes({
                                            hasLoop: state,
                                        })
                                    }
                                />
                            </BaseControl>

                            {/* {attributes.className.includes("vdslider--hornetbox") && */}
                                <BaseControl>
                                    <SelectControl
                                        label={__('Select desktop items:')}
                                        value={attributes.maxDesktopItems}
                                        onChange={(state) =>
                                            setAttributes({
                                                maxDesktopItems: state,
                                            })
                                        }
                                        options={[
                                            { value: '3', label: '3' },
                                            { value: '2', label: '2' }
                                        ]}
                                    />
                                    <TextControl
                                        value={attributes.spaceBetween}
                                        label={__("Gap Between slides")}
                                        onChange={(state) =>
                                            setAttributes({
                                                spaceBetween: state,
                                            })
                                        }
                                    />
                                </BaseControl>
                            {/* // } */}
                        </PanelBody>
                    </Panel>
                )}
            </InspectorControls>



            <div {...innerBlocksProps}  >




                <div className="swiper container">

                    <div className="testimonial-heading">
                        <RichText value={smallHeading} tagName="P" onChange={onChangeText}>

                        </RichText>
                        <RichText value={heading} tagName="h2" onChange={onChangeText2}>

                        </RichText>


                    </div>
                    <div className="vdslider__items swiper-wrapper">
                        {innerBlocksProps.children}
                    </div>

                    {attributes.hasPagination && (
                        <div className="swiper-pagination"></div>
                    )}
                </div>

                {attributes.hasNavigation && (
                    <>
                        <button type="button" aria-label={__('Previous slide')} className="vdslider__nav vdslider__nav--prev">
                            <svg className="icon"><use href="/ico.svg#chevron-left"></use></svg>
                        </button>
                        <button type="button" aria-label={__('Next slide')} className="vdslider__nav vdslider__nav--next">
                            <svg className="icon"><use href="/ico.svg#chevron-right"></use></svg>
                        </button>
                    </>
                )}

            </div>
        </Fragment>
    );
}
