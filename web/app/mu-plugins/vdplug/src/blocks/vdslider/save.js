import { __ } from "@wordpress/i18n";
import { useBlockProps, useInnerBlocksProps } from "@wordpress/block-editor";
import classnames from "classnames";

export default function save({ attributes }) {
    const blockProps = useBlockProps.save({
        className: classnames({
            "vdslider": true,
            "vdslider--has-navigation": attributes.hasNavigation,
            "vdslider--has-pagination": attributes.hasPagination,
            "vdslider--has-loop": attributes.hasLoop
        }),
        ...(attributes.className.includes("vdslider--hornetbox")) && {'data-spacebetween': attributes.spaceBetween,'data-maxitems': attributes.maxDesktopItems},
    });
    const innerBlocksProps = useInnerBlocksProps.save(blockProps);

    return (
        <div {...innerBlocksProps}>
            <div className="swiper">
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
    );
}
