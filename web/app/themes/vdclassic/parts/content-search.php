<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vdclassic
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('search-inpage__teaser'); ?>>
    <div class="search-inpage__subheading">
    <?php
    $curCategories = categoriesCommaList();
    if (!empty($curCategories)) {
        echo categoriesCommaList();
    } else {
        _e('Page', 'vdclassic');
    };
    ?>
    </div>
    <?php the_title(sprintf('<h3 class="search-inpage__title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h3>'); ?>
    <?php the_excerpt(); ?>
    <p class="readmore">
        <a href="<?php the_permalink(); ?>"><?php _e('Read more', 'vdclassic'); ?></a>
    </p>
</article><!-- #post-<?php the_ID(); ?> -->
<hr />
