
import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {

	const { items } = attributes;

	return (
		<ul { ...useBlockProps.save() }>
            {items.map((item, index) => (
                <li key={index} className="repeater-list-item">
                    {item.icon && <img src={item.icon} alt="Icon" style={{ width: '24px', height: '24px' }} />}
                    {item.text && <p>{item.text}</p>}
                </li>
            ))}
        </ul>
	);
}
