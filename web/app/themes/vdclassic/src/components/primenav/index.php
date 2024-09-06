<?php

// phpcs:disable
/**
 * Custom Menu Walker for Footer Navigation Columns
 */
class VdPrimaryNavWalker extends Walker_Nav_Menu
{
    static $startLevel=false;
    static $lastItem;

    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        if ($depth === 0) {
            $output .= '<div class="primenav__flyout btn-trans"><div class="primenav__inner styled-scrollbars">';
            $output .= '<button type="button" class="primenav__close"><svg class="icon icon-close"><use href="/ico.svg#close"></use></svg></button>';
        }
        $output .= '<ul class="primenav-ul primenav-ul--' . $depth . '">';
        self::$startLevel = true;

        return $output;
    }

    /**
     * Ends the list of after the elements are added.
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        $output .= '</ul>';
        $output .= ($depth === 0) ? '</div></div>' : '';

        return $output;
    }

    /**
     * Starts the element output.
     */
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0 )
    {
        $classes = ['primenav-lvl-' . $depth];
        // Grab the post thumbnail of the element you are parsing with a walker
        $preview = '';
        if ($depth > 0) {
            $thumbId = get_post_thumbnail_id($item->object_id);
            if ($thumbId !== 0) {
                $thumb = wp_get_attachment_image_url($thumbId , 'header_42_15');
                $preview = isset($thumb[0]) ? 'data-preview="' . esc_attr($thumb) . '"' : '';
            }
        }

        // Repeat parent item before first subnavigation item
        if (self::$startLevel && self::$lastItem) {
            array_push($classes, 'primenav__parent');
            $output .= '<li class="' . join(' ', $classes) . '">';
            // $output .= '<span>' . __('Overview:', 'vdclassic') . '</span>';
            $output .= '<a rel="nofollow" class="primenav-ln primenav-ln--' . $depth . '" href="' . self::$lastItem->url . '">';
            $output .= '' . self::$lastItem->title;
            $output .= '</a></li>';
            self::$startLevel = false;
        }
        $output .= '<li class="primenav-lvl-' . $depth . ' ' .  (is_array($item->classes) ? implode(" ", $item->classes): '') . '">';

        // Special fake menu item with: title, desc, image
        if ($depth === 1) {
            // $thumbId = get_post_thumbnail_id($item->object_id);
            // if ($thumbId !== 0) {
            //     $thumb = wp_get_attachment_image($thumbId , 'header_42_15', false, array('loading' => 'lazy'));
            // }
            $thumb = null;

            $output .= '<div class="menu-tile">';
            $output .= '<div class="menu-tile__title">'. $item->title . '</div>';
            $output .= !empty($thumb) ? '<a class="menu-tile__thumb" href="' . $item->url . '">'. $thumb . '</a>' : '';
            // $output .= '<div class="menu-tile__desc">'. $item->description . '</div>';
            $output .= '<div class="menu-tile__nav">';
        }
        else {
            $output .= '<a class="primenav-ln primenav-ln--' . $depth . ' ' . ($depth === 0 ? 'underline-gradient' : '') . '"';
            $output .= ($depth > 0 ? $preview : '');
            $output .= ' href="' . $item->url . '">';
            $output .= $item->title;
            if ($depth === 0 && isset( $args->walker->has_children ) && $args->walker->has_children ) {
                $output .= '<svg class="icon"><use href="/ico.svg#chevron-right"></use></svg>';
            }
            $output .= '</a>';
        }
        self::$lastItem = $item;

        return $output;
    }

    /**
     * Ends the element output, if needed.
     */
    public function end_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        // Special fake menu item with: title, desc, image
        if ($depth === 1) {
            $output .= '</div></div>';
        }

        $output .= '</li>';

        return $output;
    }
}
// phpcs:enable
