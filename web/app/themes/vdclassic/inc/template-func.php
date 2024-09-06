<?php

/**
 * Custom WPML Language switcher
 */
function vdclassic_language_switcher()
{
    $languages = apply_filters('wpml_active_languages', null, 'orderby=id&order=desc');

    $markup = '<label class="wpml-switch" aria-label="' . __('Change language', 'vdclassic') . '">';
    $markup .= '<svg class="icon" title><use href="/ico.svg#globe"></use></svg>';
    $markup .= '<select>';

    if (!empty($languages)) {
        foreach ($languages as $l) {
            $isSelected = $l['active'] ? ' selected' : '';
            $markup .= '<option value="' . esc_url($l['url']) . '" ' . $isSelected . '>' . esc_attr($l['language_code']) . '</option>';
        }
    }

    $markup .= '</select>';
    $markup .= '</label>';

    return $markup;
}

/**
 * Create a category list for archive pages
 * This is almost a copy of wp_list_categories(),
 * but with a customable All link url
 */
function vd_list_categories($args = '')
{
    $defaults = array(
        'child_of'            => 0,
        'current_category'    => 0,
        'depth'               => 0,
        'echo'                => 1,
        'exclude'             => '',
        'exclude_tree'        => '',
        'feed'                => '',
        'feed_image'          => '',
        'feed_type'           => '',
        'hide_empty'          => 1,
        'hide_title_if_empty' => false,
        'hierarchical'        => true,
        'order'               => 'ASC',
        'orderby'             => 'name',
        'separator'           => '<br />',
        'show_count'          => 0,
        'show_option_all'     => '',
        'show_option_all_url' => '/blog',
        'show_option_none'    => __('No categories'),
        'style'               => 'list',
        'taxonomy'            => 'category',
        'title_li'            => __('Categories'),
        'use_desc_for_title'  => 0,
    );

    $parsed_args = wp_parse_args($args, $defaults);
    global $wp;

    if (!isset($parsed_args['pad_counts']) && $parsed_args['show_count'] && $parsed_args['hierarchical']) {
        $parsed_args['pad_counts'] = true;
    }

    // Descendants of exclusions should be excluded too.
    if ($parsed_args['hierarchical']) {
        $exclude_tree = array();

        if ($parsed_args['exclude_tree']) {
            $exclude_tree = array_merge($exclude_tree, wp_parse_id_list($parsed_args['exclude_tree']));
        }

        if ($parsed_args['exclude']) {
            $exclude_tree = array_merge($exclude_tree, wp_parse_id_list($parsed_args['exclude']));
        }

        $parsed_args['exclude_tree'] = $exclude_tree;
        $parsed_args['exclude']      = '';
    }

    if (!isset($parsed_args['class'])) {
        $parsed_args['class'] = ( 'category' === $parsed_args['taxonomy'] ) ? 'categories' : $parsed_args['taxonomy'];
    }

    if (!taxonomy_exists($parsed_args['taxonomy'])) {
        return false;
    }

    $show_option_all  = $parsed_args['show_option_all'];
    $show_option_all_url  = $parsed_args['show_option_all_url'];
    $show_option_none = $parsed_args['show_option_none'];

    $categories = get_categories($parsed_args);

    $output = '';

    if ($parsed_args['title_li'] && 'list' === $parsed_args['style']
        && (! empty($categories) || ! $parsed_args['hide_title_if_empty'])
    ) {
        $output = '<li class="' . esc_attr($parsed_args['class']) . '">' . $parsed_args['title_li'] . '<ul>';
    }

    if (empty($categories)) {
        if (! empty($show_option_none)) {
            if ('list' === $parsed_args['style']) {
                $output .= '<li class="cat-item-none">' . $show_option_none . '</li>';
            } else {
                $output .= $show_option_none;
            }
        }
    } else {
        if (!empty($show_option_all)) {
            $posts_page = '';

            // For taxonomies that belong only to custom post types, point to a valid archive.
            $taxonomy_object = get_taxonomy($parsed_args['taxonomy']);
            if (!in_array('post', $taxonomy_object->object_type, true) && ! in_array('page', $taxonomy_object->object_type, true)) {
                foreach ($taxonomy_object->object_type as $object_type) {
                    $_object_type = get_post_type_object($object_type);

                    // Grab the first one.
                    if (! empty($_object_type->has_archive)) {
                        $posts_page = get_post_type_archive_link($object_type);
                        break;
                    }
                }
            }

            // Fallback for the 'All' link is the posts page.
            if (!$posts_page) {
                if ('page' === get_option('show_on_front') && get_option('page_for_posts')) {
                    $posts_page = get_permalink(get_option('page_for_posts'));
                } else {
                    $posts_page = home_url('/');
                }
            }

            $posts_page = esc_url($posts_page);
            if ('list' === $parsed_args['style']) {
                $classes = str_contains($show_option_all_url, $wp->request) ? 'current-cat' : '';
                $output .= "<li class='cat-item-all " . $classes . "'><a href='$show_option_all_url'>$show_option_all</a></li>";
            } else {
                $output .= "<a href='$show_option_all_url'>$show_option_all</a>";
            }
        }

        if (empty($parsed_args['current_category']) && ( is_category() || is_tax() || is_tag() )) {
            $current_term_object = get_queried_object();
            if ($current_term_object && $parsed_args['taxonomy'] === $current_term_object->taxonomy) {
                $parsed_args['current_category'] = get_queried_object_id();
            }
        }

        if ($parsed_args['hierarchical']) {
            $depth = $parsed_args['depth'];
        } else {
            $depth = -1; // Flat.
        }
        $output .= walk_category_tree($categories, $depth, $parsed_args);
    }

    if ($parsed_args['title_li'] && 'list' === $parsed_args['style']
        && (!empty($categories) || ! $parsed_args['hide_title_if_empty'])
    ) {
        $output .= '</ul></li>';
    }

    /**
     * Filters the HTML output of a taxonomy list.
     *
     * @since 2.1.0
     *
     * @param string       $output HTML output.
     * @param array|string $args   An array or query string of taxonomy-listing arguments. See
     *                             wp_list_categories() for information on accepted arguments.
     */
    $html = apply_filters('wp_list_categories', $output, $args);

    if ($parsed_args['echo']) {
        echo $html;
    } else {
        return $html;
    }
}
