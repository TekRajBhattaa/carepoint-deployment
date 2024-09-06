import { __ } from '@wordpress/i18n';
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

function save() {
    const blockProps = useBlockProps.save({ className: 'toggle-block' });

    return (
        <details {...blockProps}>
            <summary className="toggle-block__toggle" type='button'>{__('More features')} <svg aria-hidden="true" className="icon"><use href="/ico.svg#chevron-right"></use></svg></summary>

            <div className="toggle-block__content">
                <InnerBlocks.Content />
            </div>
        </details>
    );
}

export default save;
