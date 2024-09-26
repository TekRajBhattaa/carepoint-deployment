
import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {

	const { items } = attributes;

	return (
		<ul { ...useBlockProps.save() }>
            {items.map((item, index) => (
                <li key={index} className="card-items">
                    {item.icon && <span className='img-box'> <img src={item.icon} alt="Icon" style={{ width: '24px', height: '24px' }} /> </span>}
                    {item.text1 && <h2>{item.text1}</h2>}
                    {item.text2 && <p>{item.text2}</p>}

                </li>
            ))}
        </ul>
	);
}
