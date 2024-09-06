import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

function Save({ attributes }) {
    const { blockAuth, mediaId, mediaUrl, hasParallax, parallaxSpeed, bgOpacity } = attributes;
    let wrapperClasses = 'section';
    const wrapperStyles = {};

    if (blockAuth.length > 0) {
        wrapperClasses += ` section--${blockAuth}`;
    }

    if (hasParallax === 'on') {
        wrapperClasses += ' section--parallax';
        wrapperStyles['--parallaxSpeed'] = '' + parallaxSpeed
    }

    if (bgOpacity !== 1) {
        wrapperStyles['--bgOpacity'] = '' + bgOpacity;
    }

    const blockProps = useBlockProps.save({
        className: wrapperClasses,
        style: wrapperStyles
    });

    return (
        <section {...blockProps}>
            {mediaUrl && <img className={`section__bg wp-image-${mediaId}`} loading="lazy" src={mediaUrl} alt="" />}
            <div className="section__inner">
                <InnerBlocks.Content />
            </div>
        </section>
    );
}

export default Save;
