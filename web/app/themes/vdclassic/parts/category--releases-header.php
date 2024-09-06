<?php

// Category Header
$term = get_queried_object();
if ($term->name == 'vd_release-note') {
    $term->name = $term->labels->name;
}

$head_img = wp_get_attachment_image('1854', 'full', false, array('class' => 'category-header__image'));
echo <<<HTML
<div class="category-header">
    <div class="category-header__content">
        <div class="container">
            <div>
                <h1 class="category-header__title">$term->name</h1>
                <p>$term->description</p>
            </div>
        </div>
    </div>
    $head_img
</div>
HTML;
