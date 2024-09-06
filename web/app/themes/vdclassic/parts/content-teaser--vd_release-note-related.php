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
        <?php
        if (has_post_thumbnail()) {
            the_post_thumbnail();
        } else {
            $term = get_queried_object();
            if ($term->term_image) {
                $head_img = wp_get_attachment_image($term->term_image, 'large', false, array('class' => 'category-header__image'));
            } else {
                $terms = wp_get_post_terms($post->ID, 'vd_release_category');
                $terms = wp_list_filter($terms, array('slug'=>'release-notes-es'), 'NOT');
                $terms = wp_list_filter($terms, array('slug'=>'release-notes-en'), 'NOT');
                if ($terms[1]) {
                    $term = $terms[1];
                    if ($term->term_image) {
                        $head_img = wp_get_attachment_image($term->term_image, 'large', false, array('class' => 'category-header__image'));
                    }
                }
            }
            echo $head_img;
        }
        ?>
        </a>
    </figure>
    <div class="teaser__inner">
        <h3 class="teaser__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="teaser__head">
            <div class="teaser__info">
            <?php
            $post = get_post();
            $terms = wp_get_post_terms($post->ID, 'vd_release_category');
            foreach ($terms as $term) : ?>
                <a href="<?php echo get_category_link($term->term_id) ?>"><?php echo $term->name; ?></a>
                <?php if (next($terms)) {
                    echo ',';
                }  ?>
            <?php endforeach; ?>
            </div>
            <?php
            if ('vd_release-note' == get_post_type()) {
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
            <a href="<?php the_permalink(); ?>"><?php echo _e('Read More'); ?></a>
        </p>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->
