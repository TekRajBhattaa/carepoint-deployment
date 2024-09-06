import { registerBlockVariation } from '@wordpress/blocks';
import { ReactComponent as icon } from './icon.svg';

registerBlockVariation(
    'core/columns', {
        name: 'four-columns-equal',
        title: '4 columns',
        description: 'Four columns equal split. PLEASE CONSIDER USING GridCols Block instead.',
        icon,
        innerBlocks: [
            ['core/column'],
            ['core/column'],
            ['core/column'],
            ['core/column'],
        ],
        scope: ['block']
    }
);
