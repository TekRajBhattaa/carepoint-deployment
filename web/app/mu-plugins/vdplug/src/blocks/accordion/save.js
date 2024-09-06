import { useBlockProps, RichText, InnerBlocks } from '@wordpress/block-editor';
import { ReactComponent as Caret } from './chevron-left.svg';

export default function save({ attributes }) {
    const blockProps = useBlockProps.save({
        className: 'accordion',
    });

    return (
        <details {...blockProps}>
            <summary>
                <RichText.Content
                    tagName="h4"
                    className="accordion__title"
                    value={attributes.title}
                />
                <Caret
                    className="icon"
                    width="20"
                    height="20"
                    viewBox="0 0 40 65"
                />
            </summary>

            <div className="accordion__content">
                <InnerBlocks.Content />
            </div>
        </details>
    );
}
