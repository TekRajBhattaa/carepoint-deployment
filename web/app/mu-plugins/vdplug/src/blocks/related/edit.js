import { __ } from '@wordpress/i18n';
import { get, includes, pickBy, invoke } from 'lodash';
import classnames from 'classnames';
import {
    Placeholder,
    PanelBody,
    Spinner,
    RangeControl,
    ToggleControl,
    QueryControls,
} from '@wordpress/components';
import {
    InspectorControls,
    useBlockProps,
    __experimentalImageSizeControl as ImageSizeControl,
    store as blockEditorStore,
} from '@wordpress/block-editor';
import { useSelect } from '@wordpress/data';
import { store as coreStore } from '@wordpress/core-data';
import { registerEndpoint as registerEndpointMPT } from '../../rest';

/**
 * Register custom rest endpoint
 */
registerEndpointMPT();

/**
 * Module Constants
 */
const MAX_POSTS_COLUMNS = 6;
const CATEGORIES_LIST_QUERY = {
    per_page: -1,
    context: "view",
};

/**
 * Recieve featured media
 *
 * @param {Object} post
 * @param {number} size
 * @return {{url: string, alt: string}} Object with url and alt
 */
function getFeaturedImageDetails(post, size) {
    const image = get(post, ['_embedded', 'wp:featuredmedia', '0']);

    return {
        url:
            image?.media_details?.sizes?.[size]?.source_url ??
            image?.source_url,
        alt: image?.alt_text,
    };
}

function Edit({ attributes, setAttributes, context, isSelected }) {
    const {
        byPageCategories,
        postsToShow,
        categories,
        excerptLength,
        order,
        orderBy,
        displayFeaturedImage,
        featuredImageSizeSlug,
        featuredImageSizeWidth,
        featuredImageSizeHeight,
        columns,
    } = attributes;
    const { imageSizes, categoriesList, pageTeasers, defaultImageWidth, defaultImageHeight } =
        useSelect(
            (select) => {
                const { getEntityRecords } = select(coreStore);
                const settings = select(blockEditorStore).getSettings();

                // TODO: Implement related content by CURRENT page_categories
                // const tagArray = select("core/editor").getCurrentPostAttribute("custom_taxonomy");

                // const sourceCategories = byPageCategories ? wp.data.select('core').getEntityRecord('taxonomy', 'page_categories', name) : categories;
                const catIds =
                    categories && categories.length > 0
                        ? categories.map((cat) => cat.id)
                        : [];
                const categoryTeasersQuery = pickBy(
                    {
                        page_category: catIds,
                        type: ["page", "post", "vd_job"],
                        status: 'publish',
                        context: 'edit',
                        order,
                        orderby: orderBy,
                        per_page: postsToShow,
                        _embed: "wp:featuredmedia",
                    },
                    (value) => typeof value !== "undefined"
                );

                return {
                    defaultImageWidth: get(
                        settings.imageDimensions,
                        [featuredImageSizeSlug, 'width'],
                        0
                    ),
                    defaultImageHeight: get(
                        settings.imageDimensions,
                        [featuredImageSizeSlug, 'height'],
                        0
                    ),
                    imageSizes: settings.imageSizes,
                    categoriesList: getEntityRecords(
                        "taxonomy",
                        "page_category",
                        CATEGORIES_LIST_QUERY
                    ),
                    pageTeasers: getEntityRecords(
                        'wp/v2',
                        'multiple-post-type',
                        categoryTeasersQuery
                    ),
                };
            },
            [featuredImageSizeSlug, postsToShow, order, orderBy, categories]
        );

    const categorySuggestions =
        categoriesList?.reduce(
            (accumulator, category) => ({
                ...accumulator,
                [category.name]: category,
            }),
            {}
        ) ?? {};
    const selectCategories = (tokens) => {
        const hasNoSuggestion = tokens.some(
            (token) => typeof token === "string" && !categorySuggestions[token]
        );
        if (hasNoSuggestion) {
            return;
        }
        // Categories that are already will be objects, while new additions will be strings (the name).
        // allCategories nomalizes the array so that they are all objects.
        const allCategories = tokens.map((token) => {
            return typeof token === "string"
                ? categorySuggestions[token]
                : token;
        });
        // We do nothing if the category is not selected
        // from suggestions.
        if (includes(allCategories, null)) {
            return false;
        }
        setAttributes({ categories: allCategories });
    };

    const hasPosts = !!pageTeasers?.length;
    const blockProps = useBlockProps({
        className: 'related',
    });

    const imageSizeOptions = imageSizes
        .filter(({ slug }) => slug !== 'full')
        .map(({ name, slug }) => ({
            value: slug,
            label: name,
        }));

    const inspectorControls = (
        <InspectorControls>
            {/* <PanelBody title={__('Based on page categories')}>
                <ToggleControl
                    label={__('By Page Categories')}
                    checked={byPageCategories}
                    onChange={(value) =>
                        setAttributes({ byPageCategories: value })
                    }
                />
            </PanelBody> */}

            <PanelBody title={__('Featured image settings')}>
                <ToggleControl
                    label={__('Display featured image')}
                    checked={displayFeaturedImage}
                    onChange={(value) =>
                        setAttributes({ displayFeaturedImage: value })
                    }
                />
                {displayFeaturedImage && (
                    <ImageSizeControl
                        onChange={(value) => {
                            const newAttrs = {};
                            if (value.hasOwnProperty('width')) {
                                newAttrs.featuredImageSizeWidth =
                                    value.width;
                            }
                            if (value.hasOwnProperty('height')) {
                                newAttrs.featuredImageSizeHeight =
                                    value.height;
                            }
                            setAttributes(newAttrs);
                        }}
                        slug={featuredImageSizeSlug}
                        width={featuredImageSizeWidth}
                        height={featuredImageSizeHeight}
                        imageWidth={defaultImageWidth}
                        imageHeight={defaultImageHeight}
                        imageSizeOptions={imageSizeOptions}
                        onChangeImage={(value) =>
                            setAttributes({
                                featuredImageSizeSlug: value,
                                featuredImageSizeWidth: undefined,
                                featuredImageSizeHeight: undefined,
                            })
                        }
                    />
                )}
            </PanelBody>

            <PanelBody title={__('Sorting and filtering')}>
                <QueryControls
                    {...{ order, orderBy }}
                    numberOfItems={postsToShow}
                    minItems={2}
                    maxItems={4}
                    onOrderChange={(value) => setAttributes({ order: value })}
                    onOrderByChange={(value) =>
                        setAttributes({ orderBy: value })
                    }
                    onNumberOfItemsChange={(value) =>
                        setAttributes({ postsToShow: value })
                    }
                    categorySuggestions={categorySuggestions}
                    onCategoryChange={selectCategories}
                    selectedCategories={categories}
                />

                <RangeControl
                    label={__('Columns')}
                    value={columns}
                    onChange={(value) => setAttributes({ columns: value })}
                    min={2}
                    max={
                        !hasPosts
                            ? MAX_POSTS_COLUMNS
                            : Math.min(MAX_POSTS_COLUMNS, pageTeasers.length)
                    }
                    required
                />

            </PanelBody>
        </InspectorControls>
    );

    if (!hasPosts) {
        return (
            <>
                {isSelected && inspectorControls}

                <div {...blockProps}>
                    <Placeholder label={__('Loading Featured Content')}>
                        {!Array.isArray(pageTeasers) ? (
                            <Spinner />
                        ) :
                            /* translators: output post type name */
                            `No posts found.`
                        }
                    </Placeholder>
                </div>
            </>
        );
    }

    // Removing posts from display should be instant.
    const displayPosts =
        pageTeasers.length > postsToShow
            ? pageTeasers.slice(0, postsToShow)
            : pageTeasers;

    return (
        <>
            {isSelected && inspectorControls}

            <div {...blockProps}>

                { /* BEGIN LAYOUT Container */}
                <div className={classnames({
                    'grid-columns': true,
                    [`grid-columns--max${columns}`]: true
                })}>

                    {displayPosts.map((post) => {
                        const titleTrimmed = invoke(post, [
                            'title',
                            'rendered',
                            'trim',
                        ]);

                        let excerpt = post.excerpt.rendered;
                        const excerptElement = document.createElement('div');
                        excerptElement.innerHTML = excerpt;

                        excerpt =
                            excerptElement.textContent ||
                            excerptElement.innerText ||
                            '';

                        const { url: imageSourceUrl, alt: featuredImageAlt } =
                            getFeaturedImageDetails(post, featuredImageSizeSlug);

                        const needsReadMore =
                            excerptLength < excerpt.trim().split(' ').length &&
                            post.excerpt.raw === '';

                        const postExcerpt = needsReadMore ? (
                            <>
                                {excerpt.trim().split(' ', excerptLength).join(' ')}
                                {/* translators: excerpt truncation character, default …  */}
                                {__(' … ')}
                                <span>
                                    {__('Read more')}
                                </span>
                            </>
                        ) : (
                            excerpt
                        );

                        return (
                            <article className="teaser" key={`teaser-${post.id}`}>
                                {(displayFeaturedImage && imageSourceUrl) && (
                                    <figure className="wp-block-image size-full is-style-hover-scale">
                                        <img
                                            src={imageSourceUrl}
                                            alt={featuredImageAlt}
                                            className="page-teaser__featured"
                                        />
                                    </figure>
                                )}
                                <div className="teaser__inner">
                                    <h4 className="teaser__title" dangerouslySetInnerHTML={{ __html: titleTrimmed }} />

                                    <div className="teaser__excerpt">
                                        {postExcerpt}
                                        <p className="readmore">
                                            <span>
                                                {__('Read more')}
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </article>
                        );
                    })}
                </div>
                { /* END LAYOUT Container */}
            </div>
        </>
    );
}

export default Edit;
