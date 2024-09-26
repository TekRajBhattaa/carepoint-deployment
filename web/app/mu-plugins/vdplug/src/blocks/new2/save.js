import { useBlockProps ,RichText,InnerBlocks} from '@wordpress/block-editor';
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
    const { text,alignment ,button1 ,button2,backgroundColor,imageId,imageUrl} = attributes;


    return (
        <div className='hero-section container'>

            <RichText.Content {...useBlockProps.save({
                className:`text-box-align-${alignment}`,
                style:{backgroundColor:backgroundColor}
            })}    tagName='h4'  value={text} >
           </RichText.Content>




            {imageUrl && (
                <div>
                    <img src={imageUrl} alt="Selected image" style={{ maxWidth: '100%' }} />
               
                </div>
            )}

               {/* InnerBlocks.Content renders saved child blocks */}
               <div className="inner-blocks-container">
                <InnerBlocks.Content />
            </div>


        </div>
    );
}

export default save;
