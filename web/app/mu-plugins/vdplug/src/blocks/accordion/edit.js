import { __ } from '@wordpress/i18n';
import { useBlockProps, RichText, InnerBlocks } from '@wordpress/block-editor';
import { ReactComponent as Caret } from './chevron-left.svg';

export default function Edit({ attributes, setAttributes }) {
    const blockProps = useBlockProps({
        className: 'accordion',
    });

    return (
        <details {...blockProps}>
            <summary>
                <RichText
                    tagName="h4"
                    className="accordion__title"
                    value={attributes.title}
                    onChange={(title) => setAttributes({ title })}
                    placeholder={__('title')}
                />
                <Caret
                    className="icon"
                    width="20"
                    height="20"
                    viewBox="0 0 40 65"
                />
            </summary>

            <div className="accordion__content">
                <InnerBlocks allowedBlocks={[
                    'core/paragraph',
                    'core/heading',
                    'core/image',
                    'core/list'
                ]}/>
            </div>
        </details>
    );
}
