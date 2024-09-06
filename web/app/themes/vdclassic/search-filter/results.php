<?php
/**
 * Search & Filter Pro
 *
 * Sample Results Template
 *
 * @package   Search_Filter
 * @author    Ross Morsali
 * @link      https://searchandfilter.com
 * @copyright 2018 Search & Filter
 *
 * Note: these templates are not full page templates, rather
 * just an encaspulation of the your results loop which should
 * be inserted in to other pages by using a shortcode - think
 * of it as a template part
 *
 * This template is an absolute base example showing you what
 * you can do, for more customisation see the WordPress docs
 * and using template tags -
 *
 * http://codex.wordpress.org/Template_Tags
 *
 */

// If this file is called directly, abort.
if (!defined('ABSPATH')) {
    exit;
}

if (isset($_GET['_sf_s'])) {
    $searchString = esc_html(get_query_var('_sf_s'));
} else {
    $searchString = '';
}
?>

<div class="job-archive-top-box">
    <form class="job-search-form desktop">
        <input type="text" value = "<?php echo $searchString; ?>"  placeholder="Search...">

        <button id="job--search-button">
            <svg width="39" height="40"><use href="/ico.svg#search"></use></svg>
        </button>
    </form>
    <div class="job-search-info">
        <div class="filtered">
        </div>
          <a href="#" class="search-filter-reset" data-search-form-id="1748" data-sf-submit-form="always"><?php _e('Reset Filters', 'vdclassic'); ?></a>
    </div>
</div>

<div class="search__results">

<?php

if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $id = get_the_ID();
        $raw_content = get_the_excerpt();
        $trimmed_content = wp_trim_words($raw_content, 30);
        $clean_excerpt = apply_filters('the_excerpt', $trimmed_content);
        ?>

        <div class="search__result">
            <div class="search__title">
            <svg width="34" height="34"><use href="/ico.svg#people"></use></svg>
                <h4 ><span><?php the_title(); ?></span></h4>
            </div>
                <div class = "search__description">
                <div class="search__excerpt">
                    <p><?php echo $clean_excerpt; ?></span></p>
                </div>
                <div class="search__readmore">
                    <div class="wp-block-button is-style-fill">
                        <a class="wp-block-button__link wp-element-button" href="<?php echo get_the_permalink(); ?>" target="_blank"><?php _e('Apply now', 'vdclassic'); ?>
                    </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    _e("No Results Found", "vdclassic");
}
?>

</div>
