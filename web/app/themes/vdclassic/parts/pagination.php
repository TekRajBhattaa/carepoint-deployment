<?php

$total_pages = $wp_query->max_num_pages;
$paged = max(1, get_query_var('paged'));

if ($total_pages > 1) :
    ?>
    <div class="pagination">
        <?php
            echo paginate_links(array(
                'current'      => $paged,
                'format'       => '?paged=%#%',
                'show_all'     => false,
                'prev_next'    => true,
                'prev_text'    => sprintf('<svg title="%1$s" class="icon rotate-90"><use href="/ico.svg#arrow-down"></use></svg>', __('Previous', 'vdclassic')),
                'next_text'    => sprintf('<svg title="%1$s" class="icon rotate-270"><use href="/ico.svg#arrow-down"></use></svg>', __('Next', 'vdclassic')),
            ));
        ?>
    </div>
    <?php
endif;
