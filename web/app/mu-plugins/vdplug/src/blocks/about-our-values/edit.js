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
                ['core/paragraph', { content: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.' }],
                ['core/buttons', {}, [ // Add a buttons block container
                    ['core/button', { text: 'Button 1', url: '#' }],
                    ['core/button', { text: 'Button 2', url: '#' }]
                ]]

            
               
            ]],
            ['core/column', {}, [
                ['core/image', { id: 15, sizeSlug: 'large', linkDestination: 'none' }]
            ]]
        ]]
    ];

    return (
        <div className='about-our-values'>
               

            <div className='container'>

          

       



        

            {/* Add InnerBlocks to allow nesting */}
            <div className="about-our-values-inner-blocks-container">
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