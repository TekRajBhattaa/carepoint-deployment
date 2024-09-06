<?php


/**
 * Custom Menu Walker for Footer Navigation Columns
 */
// phpcs:disable
class VdFooterNavWalker extends Walker_Nav_Menu
{
    public $columnNum = 1;

    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth == 0) {
            $output .= '<nav class="footer__nav"><ul>';
        }
    }

    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth == 0) {
            $output .= '</ul></nav></div>';
            $this->columnNum++;
        }
    }

    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        if ($depth == 0) {
            $output .= '<div class="footer__column footer__column--' . $this->columnNum . '"><div class="footer__title">';
            $output .= $item->title;
            $output .= '<svg class="icon"><use href="/ico.svg#chevron-down"></use></svg></div>';
        } else {
            $output .= '<li class="' .  implode(" ", $item->classes) . '">';
            $output .= '<a href="' . $item->url . '">';
            $output .= $item->title;
        }
    }

    public function end_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        if ($depth == 0) {
        } else {
            $output .= '</a>';
            $output .= '</li>';
        }
    }
}
// phpcs:enable

/**
* Add a custom link to the end of footer menu that uses the wp_nav_menu() function
*/
add_filter('wp_nav_menu_items', 'add_admin_link', 10, 2);
function add_admin_link($items, $args)
{
    if ($args->theme_location == 'nav-footer') {
        $the_query = new WP_Query(array(
            'post_type' => 'vd_location',
            'post_status' => 'publish'
        ));

        // The Loop for bussiness locations
        if ($the_query->have_posts()) {
            $items .= '<div class="footer__column footer__column--contact footer__column--open">'.
            '<div class="footer__title">'.
                'Standorte <svg class="icon"><use href="/ico.svg#chevron-down"></use></svg>'.
            '</div>'.
            '<nav class="footer__nav"><ul>';
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $postID = get_the_ID();
                $postOffice = get_the_terms($postID, 'vd_location_office');
                $postPhone = get_post_meta($postID, 'vd_location_phone', true);
                if ($postOffice) {
                    $items .= '<li>'.
                    '<strong>' . $postOffice[0]->name . '</strong><br>'.
                    '<a href="tel:' . $postPhone . '">+49 (0)40 1234567</a>'.
                    '</li>';
                }
            }
            $items .= '</ul></nav></div>';
        }
        // Restore original Post Data.
        wp_reset_postdata();
    }
    return $items;
}

// Footer widget
register_sidebar(array(
    'name'          => __('Footer Widget 1', 'vdclassic'),
    'description'   => __('You can add Gutenberg blocks to your footer'),
    'id'            => 'footer-1',
    'before_widget' => '',
    'after_widget'  => ''
));
