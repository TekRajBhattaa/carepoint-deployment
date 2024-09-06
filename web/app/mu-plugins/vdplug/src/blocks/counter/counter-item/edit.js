import { __ } from "@wordpress/i18n";
import { useBlockProps, InspectorControls, RichText } from "@wordpress/block-editor";
import { BaseControl, PanelBody, PanelRow, TextControl } from '@wordpress/components';
import "./editor.css";

export default function Edit({ attributes, setAttributes, isSelected }) {
    const blockProps = useBlockProps({
        className: "counter-item",
    });
    const updateCountTo = (num) => setAttributes({ countTo: parseInt(num, 10) });
    const updateCountTitle = (title) => setAttributes({ countTitle: title });

    const inspectorControls = (
        <InspectorControls>
            <PanelBody title={__('Counter Settings', 'vdplug')}>
                <PanelRow>
                    <BaseControl>
                        <TextControl
                            label={__('Prefix')}
                            value={attributes.countPrefix}
                            onChange={newValue => setAttributes({ countPrefix: newValue })}
                        />
                    </BaseControl>
                </PanelRow>
                <PanelRow>
                    <BaseControl>
                        <TextControl
                            label={__('Suffix')}
                            value={attributes.countSuffix}
                            onChange={newValue => setAttributes({ countSuffix: newValue })}
                        />
                    </BaseControl>
                </PanelRow>
            </PanelBody>
        </InspectorControls>
    )

    return (
        <>
            {isSelected && inspectorControls}

            <div {...blockProps} data-end-val={attributes.countTo}>
                <div className="counter-item__value">
                    {attributes.countPrefix !== '' && <div className="counter-item__count-prefix">{attributes.countPrefix}</div>}

                    <RichText
                        __unstableDisableFormats
                        label="Number"
                        tagName="div" // The tag here is the element output and editable in the admin
                        className="counter-item__count-to"
                        data-counter-start="0"
                        data-counter-end={attributes.countTo.toString()}
                        value={attributes.countTo.toString()} // Any existing content, either from the database or an attribute default
                        onChange={updateCountTo} // Store updated content as a block attribute
                        placeholder={__("0")}
                    />

                    {attributes.countSuffix !== '' && <div className="counter-item__count-suffix">{attributes.countSuffix}</div>}
                </div>

                <RichText
                    __unstableDisableFormats
                    tagName="div"
                    className="counter-item__count-title"
                    value={attributes.countTitle}
                    allowedFormats={["core/bold", "core/italic"]}
                    onChange={updateCountTitle}
                    placeholder={__("Title…")}
                />
            </div>
        </>
    );
}
