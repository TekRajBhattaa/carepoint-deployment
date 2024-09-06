<?php

// Category Header

$archive_title = get_the_archive_title();
$head_img = wp_get_attachment_image(498, 'full', false, array('class' => 'category-header__image'));
echo <<<HTML
<div class="category-header">
    <div class="category-header__content">
        <div class="container">
            <div>
                <h1 class="category-header__title">$archive_title</h1>
            </div>
        </div>
    </div>
    $head_img
</div>
HTML;
