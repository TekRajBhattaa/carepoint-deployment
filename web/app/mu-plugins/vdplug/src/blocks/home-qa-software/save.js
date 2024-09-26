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
        <div className='home-qa-software'>

           

            <div className='container'>


                {/* Add InnerBlocks to allow nesting */}
                <div className="home-qa-software-inner-blocks-container">
                    <InnerBlocks.Content
                    />
                </div>
            </div>


        </div>
    );
}

export default save;
