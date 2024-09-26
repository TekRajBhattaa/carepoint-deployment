import { __ } from '@wordpress/i18n';
import { useState } from '@wordpress/element';
import {
    PanelBody,
    TextControl,
    TextareaControl,
    ColorPicker,
    ColorPalette,
    PanelColorSettings,
    Button

} from '@wordpress/components';
import {
    InspectorControls,
    useBlockProps
    ,
    RichText,
    BlockControls,
    AlignmentToolbar,
    MediaPlaceholder,
    MediaUpload,
    MediaUploadCheck
} from '@wordpress/block-editor';
import { ToolbarGroup, DropdownMenu } from '@wordpress/components';
// import { DropdownMenu } from '@wordpress/components';

function Edit({ attributes, setAttributes }) {
    const {  text,alignment,button1,button2 ,backgroundColor,textColor ,imageId,imageUrl} = attributes;

    console.log(attributes,"attributes")

    const [isUploading, setUploading] = useState(false);

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

    const onBackgroundColorChange = (background)=>{
    setAttributes ({backgroundColor: background})
    }
    const onTextColorChange = (color)=>{
        setAttributes ({textColor: color})
        }

const onChangeText = (newText) => {
    setAttributes({ text: newText });
};

const onButtonTextChange =(text)=>{
    setAttributes({ button1: text });
}

const onChangeAlignment =(newAlignment) => {
setAttributes({ alignment: newAlignment });
}





    return (
        <div className='fivestar'>
            <InspectorControls>
                safsaf
                <PanelBody title={__('Settings')}>
                    <TextControl
                    label="enter button text"
                        type='text'
                        value={button1}
                       onChange={onButtonTextChange}
                       help="help text"
                    />
                    <TextareaControl
                    label="enter button two text"
                        type='text'
                        value={text}
                       onChange={onChangeText}
                       help="help text"
                    />
                </PanelBody>
                {/* <ColorPicker color={'F03'} onChange={(v)=>console.log(v)}/> */}
                <ColorPalette colors={[{name:"red",color:"#F00"},

{name:"black",color:"#000"}


                ]} onChange={onBackgroundColorChange} value={backgroundColor}/>
            </InspectorControls>
            <BlockControls controls={[
                {
                    "title": "setting",
                    "icon": "admin-generic",
                    isActive: true,
                    onClick: () => console.log("button is clicked !")
                },
                {
                    "title": "setting2",
                    "icon": "admin-generic",
                    isActive: true,
                    onClick: () => console.log("button is clicked !")
                }
            ]}>
                <AlignmentToolbar onChange={onChangeAlignment} value={alignment}></AlignmentToolbar>

                <ToolbarGroup>
                    {/* <ToolbarButton title='align-left' icon='editor-alignleft' onClick={()=>console.log("editor align-left !")}/>
            <ToolbarButton title='align-center' icon='editor-aligncenter' onClick={()=>console.log("editor align-center !")}/>
            <ToolbarButton title='align-right' icon='editor-alignright' onClick={()=>console.log("editor align-right !")}/> */}
                    <DropdownMenu label={__("more alignments", "vdplug")} icon="arrow-down-alt2"
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
                                onClick: () => console.log("editor align-left!"),
                                isDefault: true
                            },
                            {
                                title: __("align-right", "vdplug"),
                                icon: 'editor-alignright',
                                onClick: () => console.log("editor align-left!"),
                                isDefault: true
                            }


                        ]}
                    />

                </ToolbarGroup>

            </BlockControls>



 

            <RichText
            
            {...useBlockProps({
                className:`text-box-align-${alignment}`,
                style:{backgroundColor:backgroundColor}
            })} onChange={onChangeText} placeholder={__('your text', 'vdplug')} tagName='h4' allowedFormats={[]} value={text}  />
            <div className='buttons'>

<button onChange={onButtonTextChange}>{button1}</button>
<button >{button2}</button>

            </div>



            <div>
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
        </div>
        </div>
    );
}

export default Edit;
