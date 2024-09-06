import { registerBlockType } from '@wordpress/blocks';
import { addFilter } from '@wordpress/hooks';
import { ReactComponent as icon } from './icon.svg';
import metadata from './block.json';
import edit from './edit';
import save from './save';
import './style.css';

registerBlockType(metadata, {
    icon,
    edit,
    save,
});

/**
 * Default align is: wide
 */
addFilter('blocks.registerBlockType', 'verdure/section', (settings, name) => {
    if ('verdure/section' === name) {
        return {
            ...settings,
            ...{
                attributes: Object.assign({}, settings.attributes, {
                    align: {
                        type: 'string',
                        default: 'wide'
                    }
                })
            }
        }
    }
    return settings
});
