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

    ['core/group', {}, [ // Wrapping the image in a group block
        ['core/image', { 
            id: 15, 
            sizeSlug: 'large', 
            linkDestination: 'none', 
            url: 'https://via.placeholder.com/150' 
        }]
    ]]
    const TEMPLATE = [
        ['core/columns', {}, [
            ['core/column', {}, [
                ['core/heading', { level: 1, content: 'Title' }],

                ['core/group', {}, [ // Wrapping the image in a group block
                    ['core/paragraph', { content: 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa.' }],
                    ['core/buttons', {}, [ // Add a buttons block container
                        ['core/button', { text: 'Button 1', url: '#' }]
    
                    ]]
    
                ]]
                  
            ]],
            ['core/column', {}]
        ]]
    ];

    return (
        <div className='home-faq-section'>
               

            <div className='container'>

          

       



        

            {/* Add InnerBlocks to allow nesting */}
            <div className="home-faq-section-inner-blocks-container">
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