import { __ } from '@wordpress/i18n';
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

function Edit() {
    const blockProps = useBlockProps({ className: 'toggle-block' });

    return (
        <details {...blockProps}>
            <summary className="toggle-block__toggle" type='button'>{__('More features')}</summary>

            <div className="toggle-block__content">
                <InnerBlocks />
            </div>
        </details>
    );
}

export default Edit;
