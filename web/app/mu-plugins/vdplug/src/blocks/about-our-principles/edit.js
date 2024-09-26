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
        ['core/group', {}, [
            ['core/heading', { level: 1, content: 'Title' }],
            ['core/paragraph', { content: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.' }],
        ]],
        ['verdure/home-cards']
    ];
    

    return (
        <div className='about-our-principles'>
            {imageUrl && (
                <>
                    <img className='hero-img' src={imageUrl} alt="Selected image" style={{ maxWidth: '100%' }} />
                    <Button
                        onClick={() => setAttributes({ imageUrl: '', imageId: null })}
                        isSecondary
                    >
                        Remove Image
                    </Button>
                </>
            )}

            <div className='container'>



                {/* <InspectorControls>
                    <PanelBody title={__('Background Image')}>
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
                                        {isUploading ? 'Uploading...' : ' Upload Image'}
                                    </Button>
                                )}
                            />
                        </MediaUploadCheck>
                    </PanelBody>

                </InspectorControls> */}





                {/* Add InnerBlocks to allow nesting */}
                <div className="about-our-principles-inner-blocks-container">

                    <InnerBlocks
                        allowedBlocks={ALLOWED_BLOCKS}
                        template={TEMPLATE} // Optional: Template for inner blocks
                        templateLock={false}  // Allow customization or lock if needed
                    />
                </div>
            </div>
        </div>
    );
}

export default Edit;