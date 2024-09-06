import { registerBlockVariation } from '@wordpress/blocks';

registerBlockVariation('core/spacer', [
    {
        name: 'responsive',
        title: 'Spacer: Responsive',
        isDefault: true,
        className: 'spacer--responsive',
        attributes: {
            width: '100%',
            height: 'var:preset|spacing|20'
        },
        isActive: ['className'],
        scope: ['block', 'inserter', 'transform']
    },
]);
