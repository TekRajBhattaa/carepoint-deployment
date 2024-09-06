<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package vdclassic
 */

get_header();
?>

<main id="primary" class="main">
    <section class="wp-block-verdure-section section">
        <div class="section__inner">
            <header class="page-header">
                <h2 class="page-title">
                    <?php
                    /* translators: %s: search query. */
                    printf(esc_html__('Search Results for: “%s”', 'vdclassic'), '<span>' . get_search_query() . '</span>');
                    ?>
                </h2>
                <?php
                /**
                 * Replace base Block class since we use it not it header this time...
                 */
                $searchFormHtml = get_search_form(array(
                    'echo' => false
                ));
                echo preg_replace('/searchcomplete/', 'search-inpage', $searchFormHtml);
                ?>
            </header><!-- .page-header -->

            <?php if (have_posts()) :
                /* Start the Loop */
                while (have_posts()) :
                    the_post();

                    /**
                     * Run the loop for the search to output the results.
                     * If you want to overload this in a child theme then include a file
                     * called content-search.php and that will be used instead.
                     */
                    get_template_part('parts/content', 'search');
                endwhile;

                get_template_part('parts/pagination');
            else :
                get_template_part('parts/content', 'none');
            endif;
            ?>
            </div>
        </section>
</main>

<?php
get_footer();
