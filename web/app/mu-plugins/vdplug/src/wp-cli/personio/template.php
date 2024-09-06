<?php
namespace WP_CLI\Personio\Template;

use Alley\WP\Block_Converter\Block_Converter;

/**
 * Convert HTML to Gutenberg
 * @param string $html
 */
function html2gutenberg($html)
{
    $converter = new Block_Converter($html);

    return $converter->convert();
}

/**
 * Render Markup from parsed XML feed
 * @param SimpleXMLElement $job
 * @return string
 */
function renderMarkup($job)
{
    $out = <<<HTML
<!-- wp:cover {"url":"/app/mu-plugins/vdplug/static/job-background.png","dimRatio":30,"className":"hero jobinfo","backgroundColor":"gray"} -->
<div class="wp-block-cover hero jobinfo has-gray-background-color has-background"><span aria-hidden="true" class="wp-block-cover__background has-background-dim-30 has-background-dim"></span><img class="wp-block-cover__image-background" alt="" src="/app/mu-plugins/vdplug/static/job-background.png" data-object-fit="cover"/><div class="wp-block-cover__inner-container"><!-- wp:post-title {"textAlign":"left"} /-->

<!-- wp:post-terms {"term":"vd_job_department","textAlign":"left","prefix":" Department: ","className":"job-department"} /-->

<!-- wp:post-terms {"term":"vd_job_location","textAlign":"left","prefix":"Location: ","className":"job-location"} /-->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"textAlign":"left","className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link has-text-align-left wp-element-button">Apply Now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div></div>
<!-- /wp:cover -->

<!-- wp:verdure/section {"className":"jobinfo"} -->
<section class="alignwide section jobinfo"><div class="section__inner"><!-- wp:paragraph -->
<p>The Hornetsecurity Group is the leading cloud security provider in Europe, which protects the IT infrastructure, digital communication and data of companies and organizations of all sizes. Its services are provided worldwide via 11 redundantly secured data centers. The product portfolio covers all important areas of email security, including spam and virus filters, legally compliant archiving and encryption, as well as defense against CEO fraud and ransomware. With more than 400 employees, the Hornetsecurity Group is represented globally at several locations and operates in more than 30 countries through its international distribution network. The premium services are used by approximately 50,000 customers including Swisscom, Telefónica, KONICA MINOLTA, LVM Versicherung and CLAAS.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Be part of our fast-growing international company with a promising future and unlimited development! We are looking for a motivated <strong>Account Executive</strong>&nbsp;who wants to work with an amazing team and towards us becoming a market leader in Canada!</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>This is an important full-time position that we are looking to fill immediately, based out of our office in <strong>Montréal</strong>&nbsp;(Quebec H2G 2J6).</p>
<!-- /wp:paragraph -->

<!-- wp:separator {"className":"is-style-blueline"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-blueline"/>
<!-- /wp:separator -->
HTML;

    foreach ($job->jobDescriptions->jobDescription as $jobPart) {
        $title = $jobPart->name;
        $text = html2gutenberg($jobPart->value);
        $out .= <<<HTML
    <!-- wp:heading {"level":4} -->
<h4 class="wp-block-heading">$title</h4>
<!-- /wp:heading -->

$text

<!-- wp:separator {"className":"is-style-blueline"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-blueline"/>
<!-- /wp:separator -->
HTML;
    }

    $out .= <<<HTML
<!-- wp:paragraph -->
<p><strong>Do you want to help shape the growth and success of the Hornetsecurity Group? Then apply now with:</strong></p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul><!-- wp:list-item -->
<li>Your CV</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Your earliest starting date and your salary expectations</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:separator {"className":"is-style-blueline"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-blueline"/>
<!-- /wp:separator -->

<!-- wp:heading {"textAlign":"center","className":"jobform-heading"} -->
<h2 class="wp-block-heading has-text-align-center jobform-heading" id="h-please-fill-out-this-application-form-to-aply-for-this-position">Please Fill Out This Application Form To Aply For This Position</h2>
<!-- /wp:heading -->

<!-- wp:gravityforms/form {"formId":"9","title":false,"description":false,"ajax":true,"inputPrimaryColor":"#204ce5"} /--></div></section>
<!-- /wp:verdure/section -->
HTML;

    return $out;
}
