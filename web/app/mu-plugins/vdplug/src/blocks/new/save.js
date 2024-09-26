import { useBlockProps ,RichText} from '@wordpress/block-editor';
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
        <div className='fivestar'>

            <RichText.Content {...useBlockProps.save({
                className:`text-box-align-${alignment}`,
                style:{backgroundColor:backgroundColor}
            })}    tagName='h4'  value={text} >
           </RichText.Content>

           <div className='buttons'>

<button >{button1}</button>
<button >{button2}</button>

            </div>


            {imageUrl && (
                <div>
                    <img src={imageUrl} alt="Selected image" style={{ maxWidth: '100%' }} />
               
                </div>
            )}


        </div>
    );
}

export default save;
