<?php
use function Env\env;

/**
 * Set SMTP mail server
 * $phpmailer->SMTPDebug = PHPMailer\PHPMailer\SMTP::DEBUG_SERVER;
 */
function vdplug_phpmailer_details($phpmailer)
{
    $phpmailer->isSMTP();
    $phpmailer->Host = env('SMTP_HOST');
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = '587';
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->Username = env('SMTP_USER');
    $phpmailer->Password = env('SMTP_PASS');
    $phpmailer->addReplyTo(env('SMTP_REPLY_TO'), env('SMTP_FROM_NAME'));
    $phpmailer->setFrom(env('SMTP_FROM_MAIL'));
}
add_action('phpmailer_init', 'vdplug_phpmailer_details');
