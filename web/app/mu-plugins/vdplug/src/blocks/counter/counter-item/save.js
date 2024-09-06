import { useBlockProps, RichText } from "@wordpress/block-editor";

export default function Save({ attributes }) {
    const blockProps = useBlockProps.save({
        className: "counter-item",
    });

    return (
        <div {...blockProps}>
            <div className="counter-item__value">
                {attributes.countPrefix !== '' && <div className="counter-item__count-prefix">{attributes.countPrefix}</div>}

                <RichText.Content
                    tagName="div"
                    className="counter-item__count-to"
                    data-counter-start="0"
                    data-counter-end={attributes.countTo}
                    value={0}
                />

                {attributes.countSuffix !== '' && <div className="counter-item__count-suffix">{attributes.countSuffix}</div>}
            </div>

            <RichText.Content
                tagName="div"
                className="counter-item__count-title"
                value={attributes.countTitle}
            />
        </div>
    );
}
