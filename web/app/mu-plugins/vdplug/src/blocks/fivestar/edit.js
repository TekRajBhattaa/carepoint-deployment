import { __ } from '@wordpress/i18n';
import {
    PanelBody,
    TextControl
} from '@wordpress/components';
import {
    InspectorControls,
    useBlockProps
} from '@wordpress/block-editor';

function Edit({ attributes, setAttributes, isSelected }) {
    const { rate } = attributes;
    const blockProps = useBlockProps({
        className: 'fivestar',
        style: {
            "--rate": rate.toString(),
        }
    });

    return (
        <>
            {isSelected && <InspectorControls>
                <PanelBody title={__('Select Rating')}>
                    <TextControl
                        type='number'
                        value={rate}
                        onChange={newValue => setAttributes({ rate: parseFloat(newValue) })}
                        step={.1}
                        min={0}
                        max={5}
                    />
                </PanelBody>
            </InspectorControls>}

            <div {...blockProps}>
                <div className='fivestar__bar'></div>
            </div>
        </>
    );
}

export default Edit;
