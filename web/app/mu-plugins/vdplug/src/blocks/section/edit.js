import { __ } from '@wordpress/i18n';
import { useSelect } from '@wordpress/data';
import { BaseControl, PanelBody, PanelRow, SelectControl, TextControl, Button } from '@wordpress/components';
import { Fragment } from '@wordpress/element';
import {
    useBlockProps,
    InspectorControls,
    BlockControls,
    InnerBlocks,
    MediaPlaceholder,
    MediaReplaceFlow,
    MediaUploadCheck
} from '@wordpress/block-editor';
import { getBlockTypes } from '@wordpress/blocks';

function Edit({ attributes, setAttributes, isSelected }) {
    const { blockAuth, blockRole, mediaId, mediaUrl, hasParallax, parallaxSpeed, bgOpacity } = attributes;
    let wrapperClasses = 'section';
    const wrapperStyles = {};

    if (blockAuth.length > 0) {
        wrapperClasses += ` section--${blockAuth}`;
    }

    if (hasParallax === 'on') {
        wrapperClasses += ' section--parallax';
        wrapperStyles['--parallaxSpeed'] = parallaxSpeed;
    }

    if (bgOpacity !== 1) {
        wrapperStyles['--bgOpacity'] = bgOpacity;
    }

    const blockProps = useBlockProps({
        className: wrapperClasses,
        style: wrapperStyles
    });
    const media = useSelect((select) => select('core').getMedia(mediaId), [mediaId]);
    const ALLOWED_BLOCKS = getBlockTypes().map(block => block.name).filter(blockName => blockName !== 'verdure/section');

    const removeMedia = () => {
        setAttributes({
            mediaId: 0,
            mediaUrl: ''
        });
    }

    const onSelectMedia = (newMedia) => {
        setAttributes({
            mediaId: parseInt(newMedia.id, 10),
            mediaUrl: newMedia.url
        });
    }

    const blockControls = (
        <BlockControls>
            <MediaReplaceFlow
                mediaId={mediaId}
                mediaUrl={mediaUrl}
                allowedTypes={['image']}
                accept="image/*"
                onSelect={onSelectMedia}
                name={!mediaUrl ? __('Backgound Image') : __('Replace Backgound Image')}
            />
        </BlockControls>
    );

    const inspectorControls = (
        <InspectorControls group="styles">
            <PanelBody title={__('Background Image Settings', 'vdplug')} isSelected={false}>
                <PanelRow>
                    <BaseControl>
                        <MediaPlaceholder
                            labels={{
                                title: __('Backgroung Image', 'vdplug'),
                                instructions: __('Add a background image for the section', 'vdplug')
                            }}
                            accept="image/*"
                            allowedTypes={['image']}
                            value={media}
                            autoOpenMediaUpload={true}
                            onSelect={onSelectMedia}
                            multiple={false}
                            handleUpload={false}
                            mediaPreview={<img className={`section__bg-preview wp-image-${mediaId}`} loading="lazy" src={mediaUrl} alt="" />}
                        />

                        {media && <MediaUploadCheck>
                            <Button onClick={removeMedia} isLink isDestructive>{__('Remove image', 'vdplug')}</Button>
                        </MediaUploadCheck>}
                    </BaseControl>
                </PanelRow>

                <PanelRow>
                    <BaseControl>
                        <SelectControl
                            label={__('Parallax')}
                            options={[
                                {
                                    label: 'Off',
                                    value: 'off',
                                },
                                {
                                    label: 'On',
                                    value: 'on',
                                },
                            ]}
                            value={hasParallax}
                            onChange={(value) =>
                                setAttributes({
                                    hasParallax: value,
                                })
                            }
                        />
                    </BaseControl>
                </PanelRow>

                <PanelRow>
                    <BaseControl>
                        <TextControl
                            label={__('Parallax Speed')}
                            type='number'
                            step={.1}
                            min={.1}
                            max={3}
                            value={parallaxSpeed}
                            onChange={(value) =>
                                setAttributes({
                                    parallaxSpeed: parseFloat(value),
                                })
                            }
                        />
                    </BaseControl>

                    <BaseControl>
                        <TextControl
                            label={__('BG Opacity (0..1)')}
                            type='number'
                            step={.1}
                            min={.1}
                            max={1}
                            value={bgOpacity}
                            onChange={(value) =>
                                setAttributes({
                                    bgOpacity: parseFloat(value),
                                })
                            }
                        />
                    </BaseControl>
                </PanelRow>
            </PanelBody>

            <PanelBody title={__('Permission', 'vdplug')}>
                <PanelRow>
                    <BaseControl>
                        <SelectControl
                            label={__('Authentication required')}
                            options={[
                                { label: 'Ignore', value: '' },
                                {
                                    label: 'Only logged',
                                    value: 'is-logged',
                                },
                                {
                                    label: 'Not logged',
                                    value: 'is-unlogged',
                                },
                            ]}
                            value={blockAuth}
                            onChange={(value) =>
                                setAttributes({
                                    blockAuth: value,
                                })
                            }
                        />
                    </BaseControl>

                    {blockAuth === 'is-logged' ? (
                        <BaseControl>
                            <SelectControl
                                label="Required Role"
                                options={[
                                    { label: 'Alle', value: '' },
                                    {
                                        label: 'Author',
                                        value: 'author',
                                    },
                                    {
                                        label: 'Editor',
                                        value: 'editor',
                                    },
                                    {
                                        label: 'Administrator',
                                        value: 'administrator',
                                    },
                                ]}
                                value={blockRole}
                                onChange={(value) =>
                                    setAttributes({ blockRole: value })
                                }
                            ></SelectControl>
                        </BaseControl>
                    ) : (
                        ''
                    )}
                </PanelRow>
            </PanelBody>
        </InspectorControls>
    )

    return (
        <Fragment>
            {isSelected && <>
                {blockControls}
                {inspectorControls}
            </>}

            <section {...blockProps}>
                {mediaUrl && mediaId && <img className={`section__bg wp-image-${mediaId}`} loading="lazy" src={mediaUrl} data-id={mediaId} alt="" />}
                <div className="section__inner">
                    <InnerBlocks allowedBlocks={ALLOWED_BLOCKS} templateInsertUpdatesSelection={false} />
                </div>
            </section>
        </Fragment>
    );
}

export default Edit;
