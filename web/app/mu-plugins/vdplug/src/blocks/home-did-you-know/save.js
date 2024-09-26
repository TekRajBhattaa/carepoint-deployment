import { useBlockProps, RichText, InnerBlocks } from '@wordpress/block-editor';
import {
    PanelBody,
    TextControl,
    TextareaControl,
    ColorPicker,
    ColorPalette,
    PanelColorSettings,
    Button

} from '@wordpress/components';


function save({ attributes }) {
    const { text, alignment, button1, button2, backgroundColor, imageId, imageUrl } = attributes;


    return (
        <div className='home-did-you-know'>

           

            <div className='container'>


                {/* Add InnerBlocks to allow nesting */}
                <div className="home-did-you-know-inner-blocks-container">
                    <InnerBlocks.Content
                    />
                </div>
            </div>


        </div>
    );
}

export default save;
