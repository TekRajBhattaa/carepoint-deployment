
import { __ } from '@wordpress/i18n';
import { useBlockProps, MediaUpload, RichText } from '@wordpress/block-editor';
import { Button, IconButton } from '@wordpress/components';
import './editor.scss';

export default function Edit({ attributes, setAttributes }) {

	const { items } = attributes;

    const addItem = () => {
        const newItems = [...(items || []), { icon: null, text: '' }];
        setAttributes({ items: newItems });
    };

    const removeItem = (index) => {
        const newItems = items.filter((item, i) => i !== index);
        setAttributes({ items: newItems });
    };

    const updateItem = (index, newData) => {
        const newItems = [...items];
        newItems[index] = { ...newItems[index], ...newData };
        setAttributes({ items: newItems });
    };

	return (
		<div { ...useBlockProps() }>
            {/* <h4>{ __('Repeater List with Icon', 'repeater-list-with-icon') }</h4> */}
            {items && items.length > 0 ? (
                items.map((item, index) => (
                    <div key={index} className="repeater-list-item">
                        <MediaUpload
                            onSelect={(media) => updateItem(index, { icon: media.url })}
							allowedTypes={['image/svg+xml', 'image/png', 'image/jpeg']}
                            render={({ open }) => (
                                <Button className='upload-icon' onClick={open}>
                                    {item.icon ? (
                                        <img src={item.icon} alt="Icon" style={{ width: '24px', height: '24px' }} />
                                    ) : (
                                        <button className='upload_icon'>Upload icon</button>
                                    )}
                                </Button>
                            )}
                        />
                        <RichText
                        className='text'
                            value={item.text}
                            placeholder={ __('Enter list item content', 'repeater-list-with-icon')}
                            onChange={(text) => updateItem(index, { text })}
                        />
                        <Button  label="Remove Item"
                            onClick={() => removeItem(index)}>
                            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 30 30" width="25px" height="25px"><path d="M 13 3 A 1.0001 1.0001 0 0 0 11.986328 4 L 6 4 A 1.0001 1.0001 0 1 0 6 6 L 24 6 A 1.0001 1.0001 0 1 0 24 4 L 18.013672 4 A 1.0001 1.0001 0 0 0 17 3 L 13 3 z M 6 8 L 6 24 C 6 25.105 6.895 26 8 26 L 22 26 C 23.105 26 24 25.105 24 24 L 24 8 L 6 8 z"/></svg>
                        </Button>
                        {/* <Button
                            icon="trash"
                           
    
                        /> */}
                    </div>
                ))
            ) : (
                <p>{__('No items added yet.', 'repeater-list-with-icon')}</p>
            )}
            <Button isPrimary onClick={addItem}>
                {__('Add New List Item', 'repeater-list-with-icon')}
            </Button>
        </div>
	);
}
