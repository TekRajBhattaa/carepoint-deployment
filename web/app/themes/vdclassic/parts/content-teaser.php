<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package vdclassic
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('teaser'); ?>>
    <figure class="wp-block-image">
        <a href="<?php the_permalink(); ?>" class="teaser__media">
            <?php the_post_thumbnail(); ?>
        </a>
    </figure>
    <div class="teaser__inner">
        <h3 class="teaser__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="teaser__head">
            <div class="teaser__info"><?php the_category(', '); ?></div>
            <?php
            if ('post' == get_post_type()) {
                ?><div class="teaser__date"><?php the_date(); ?></div><?php
            }
            ?>
        </div>
        <?php if (has_excerpt()) :?>
            <p>
                <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
            </p>
        <?php endif; ?>
        <p class="readmore">
            <a href="<?php the_permalink(); ?>">Mehr erfahren</a>
        </p>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->
