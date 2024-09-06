<?php
namespace WP_CLI\VD;

require_once(__DIR__ . '/fake-post/index.php');
require_once(__DIR__ . '/personio/index.php');

use WP_CLI;

class WPCLI
{
    // Usage: wp vd environment
    public function environment($args)
    {
        WP_CLI::log(sprintf('Environment: %s', WP_ENV));
    }

    // Usage: wp vd lorem --type=post --pages=10 --paragraph=2
    public function lorem($args, $assoc_args)
    {
        $cli_args = array_merge(array(
            "pages" => "1",
            "type" => "post",
            "sections" => "1",
            "paragraphs" => "2"
        ), $assoc_args);

        for ($i=0; $i < $cli_args["pages"]; $i++) {
            WP_CLI\DummyContent\insertFakePost($cli_args);
        }
    }

    // Usage: wp vd personio
    public function personio()
    {
        WP_CLI\Personio\importJobs();
    }
}

WP_CLI::add_command('vd', 'WP_CLI\vd\WPCLI');
