import { registerBlockType } from '@wordpress/blocks';
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
