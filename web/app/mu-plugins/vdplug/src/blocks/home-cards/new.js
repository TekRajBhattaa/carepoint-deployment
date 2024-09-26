import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import {
    PanelBody,
    Button
} from '@wordpress/components';
import {
    InspectorControls,
    useBlockProps,
    RichText,
    BlockControls,
    MediaUpload,
    MediaUploadCheck,
    InnerBlocks
} from '@wordpress/block-editor';
import { ToolbarGroup, DropdownMenu } from '@wordpress/components';
 
function Edit({ attributes, setAttributes }) {
    const { text, alignment, backgroundColor, imageId, imageUrl } = attributes;
    const [isUploading, setUploading] = useState(false);
 
    const onChangeText = (newText) => {
        setAttributes({ text: newText });
    };
 
    const onSelectImage = (media) => {
        setAttributes({
            imageUrl: media.url,
            imageId: media.id,
        });
        setUploading(false);
    };
 
    const openMediaLibrary = (open) => {
        setUploading(true);
        open();
    };
 
    const ALLOWED_BLOCKS = ['core/paragraph', 'core/image', 'core/heading']; // Allow these blocks inside
 
 
    const TEMPLATE = [
        ['core/columns', {}, [
            ['core/column', {}, [
                ['core/heading', { level: 1, content: 'Title' }],
                ['core/paragraph', { content: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.' }]
            ]],
            ['core/column', {}, [
                ['core/image', { id: 15, sizeSlug: 'large', linkDestination: 'none' }]
            ]]
        ]]
    ];
 
    return (
        <div className='hero-section container'>
 
            <BlockControls controls={[
                {
                    title: "setting",
                    icon: "admin-generic",
                    isActive: true,
                    onClick: () => console.log("button is clicked !")
                },
                {
                    title: "setting2",
                    icon: "admin-generic",
                    isActive: true,
                    onClick: () => console.log("button is clicked !")
                }
            ]}>
                <ToolbarGroup>
                    <DropdownMenu
                        label={__("more alignments", "vdplug")}
                        icon="arrow-down-alt2"
                        controls={[
                            {
                                title: __("align-left", "vdplug"),
                                icon: 'editor-alignleft',
                                onClick: () => console.log("editor align-left!"),
                                isDefault: true
                            },
                            {
                                title: __("align-center", "vdplug"),
                                icon: 'editor-aligncenter',
                                onClick: () => console.log("editor align-center!"),
                                isDefault: true
                            },
                            {
                                title: __("align-right", "vdplug"),
                                icon: 'editor-alignright',
                                onClick: () => console.log("editor align-right!"),
                                isDefault: true
                            }
                        ]}
                    />
                </ToolbarGroup>
            </BlockControls>
 
            <InspectorControls>
                <MediaUploadCheck>
                    <MediaUpload
                        onSelect={onSelectImage}
                        allowedTypes={['image']}
                        value={imageId}
                        render={({ open }) => (
                            <Button
                                onClick={() => openMediaLibrary(open)}
                                isPrimary
                                disabled={isUploading}
                            >
                                {isUploading ? 'Uploading...' : 'Select or Upload Image'}
                            </Button>
                        )}
                    />
                </MediaUploadCheck>
            </InspectorControls>
 
            <RichText
                {...useBlockProps({
                    className: `text-box-align-${alignment}`,
                    style: { backgroundColor }
                })}
                onChange={onChangeText}
                placeholder={__('Your text', 'vdplug')}
                tagName='h4'
                allowedFormats={[]}
                value={text}
            />
 
            {imageUrl && (
                <div>
                    <img src={imageUrl} alt="Selected image" style={{ maxWidth: '100%' }} />
                    <Button
                        onClick={() => setAttributes({ imageUrl: '', imageId: null })}
                        isSecondary
                    >
                        Remove Image
                    </Button>
                </div>
            )}
 
            {/* Add InnerBlocks to allow nesting */}
            <div className="inner-blocks-container">
                <InnerBlocks
                    allowedBlocks={ALLOWED_BLOCKS}
                    template={TEMPLATE} // Optional: Template for inner blocks
                    templateLock={false}  // Allow customization or lock if needed
                />
            </div>
        </div>
    );
}
 
export default Edit;