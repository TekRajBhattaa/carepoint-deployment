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
        <div class="teaser__head">
            <div class="teaser__info"><?php the_category(', '); ?></div>
            <?php
            if ('post' == get_post_type()) {
                ?><div class="teaser__date"><?php the_date(); ?></div><?php
            }
            ?>
        </div>

        <h3 class="teaser__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

        <?php if (has_excerpt()) :?>
            <p>
                <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
            </p>
        <?php endif; ?>

        <div class="teaser__actions">
            <div class="readmore" style="display: inline-block;">
                <a href="<?php the_permalink(); ?>">Mehr erfahren</a>
            </div>

            <?php
            $video_url = get_post_meta(get_the_ID(), 'vd_video_url', true);
            if (!empty($video_url)) {
                $video_btn_text = __('Watch Video Overview');
                $video_block = $GLOBALS['wp_embed']->run_shortcode('[embed width=560 height=315]' . $video_url . '[/embed]');

                echo <<<HTML
                <button data-youtube="$video_url" class="video-link" type="button">
                    $video_btn_text
                    <svg class="icon"><use href="/ico.svg#play"></use></svg>
                </button>

                <dialog>
                    <div class="dialog__close"><svg class="icon"><use href="/ico.svg#close"></use></svg></div>

                    <div class="video-container">$video_block</div>
                </dialog>
                HTML;
            }
            ?>
        </div>
    </div>
</article><!-- #post-<?php the_ID(); ?> -->
