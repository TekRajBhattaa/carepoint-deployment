import { __ } from '@wordpress/i18n';
import { RichTextToolbarButton } from '@wordpress/block-editor';
import { registerFormatType, toggleFormat } from '@wordpress/rich-text';
import './posttypes/post';
import './posttypes/vd_location';
import './posttypes/vd_job';

/** General Frontend code from blocks-mod */
import './blocks-mod';
import './editor.css';

// Format Uppercase
const CustomFormatUppercaseBtn = ({ isActive, onChange, value }) => {
    return (
        <RichTextToolbarButton
            icon='heading'
            isActive={isActive}
            onClick={() => {
                onChange(
                    toggleFormat(value, {
                        type: 'verdure/format-uppercase',
                    })
                );
            }}
            title={__('Uppercase', 'vdplug')}
        />
    )
};

registerFormatType(
    'verdure/format-uppercase', {
        className: 'format-uppercase',
        edit: CustomFormatUppercaseBtn,
        tagName: 'span',
        title: __('Uppercase', 'vdplug')
    }
);

// Format Font-Weight 500
const CustomFontWeight500Btn = ({ isActive, onChange, value }) => {
    return (
        <RichTextToolbarButton
            icon='bold'
            isActive={isActive}
            onClick={() => {
                onChange(
                    toggleFormat(value, {
                        type: 'verdure/format-fontweight500',
                    })
                );
            }}
            title={__('Font-Weight 500', 'vdplug')}
        />
    )
};

registerFormatType(
    'verdure/format-fontweight500', {
        className: 'format-fontweight500',
        edit: CustomFontWeight500Btn,
        tagName: 'span',
        title: __('Font-Weight 500', 'vdplug')
    }
);
