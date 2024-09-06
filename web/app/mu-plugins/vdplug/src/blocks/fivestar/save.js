import { useBlockProps } from '@wordpress/block-editor';

function save({ attributes }) {
    const { rate } = attributes;
    const blockProps = useBlockProps.save({
        className: 'fivestar',
        style: {
            "--rate": rate.toString(),
        }
    });

    return (
        <div {...blockProps}>
            <div className='fivestar__bar'></div>
        </div>
    );
}

export default save;
