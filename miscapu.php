<?php
/**
 * @package MiSCapu
 */
/*
 * Plugin Name: MiSCapu
 * Plugin URI: https://miscapu.com
 * Description: This is my first plugin
 * Version:1.0.0
 * Author: MiSCapu
 * Author URI: https://miscapu.com
 * License: GPLv2 or later
 * Text Domain: miscapu
 */

if ( !defined( 'ABSPATH' ) )
{
    die;
}


class MiSCapu
{
    public function __construct()
    {
        add_action( 'admin_menu', [ $this, 'admin_menu_options' ] );
        add_shortcode('elementor_option_shortcode', [ $this, 'custom_elementor_option_shortcode' ] );

    }

    function activate()
    {
        $this->admin_menu_options();
        flush_rewrite_rules();
    }

    function deactivate()
    {
        flush_rewrite_rules();
    }

    public function admin_menu_options()
    {
        add_menu_page(
            'Adicionar Link do Video',
            'Custom Link Video',
            'manage_options',
            'add-custom-link-video',
            [ $this, 'my_settings' ]
        );
    }

    public function my_settings()
    {
        include __DIR__."/inc/settings.php";
    }


    function custom_elementor_option_shortcode() {
        // Get the Elementor option value using get_option
        $elementor_option_value = get_option('link_text');

        // Check if the option exists and has a value
        if ($elementor_option_value !== false) {
            $video_url = esc_url($elementor_option_value);

            // Extract the video ID from the YouTube URL
            $video_id = $this->convert_youtube_url($video_url);

            // Build the YouTube video iframe
//            $iframe_code = '<iframe width="560" height="315" src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allowfullscreen></iframe>';
            $iframe_code = '<iframe width="560" height="315" src="'.$video_id .'" frameborder="0" allowfullscreen></iframe>';

            // Return the iframe code
            return $iframe_code;

        } else {
            // Option doesn't exist or is not set
            return 'Elementor Option not found or not set.';
        }
    }


    // Function to extract YouTube video ID from URL
    function convert_youtube_url($url) {
        // Regular expression pattern to match YouTube video URL and extract the video ID
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

        // Check if the URL matches the pattern
        if (preg_match($pattern, $url, $matches)) {
            // Extracted video ID
            $video_id = $matches[1];

            // Construct the embed URL
            $embed_url = "https://www.youtube.com/embed/{$video_id}";

            return $embed_url;
        } else {
            // URL doesn't match the expected format
            return false;
        }
    }

}

if ( class_exists( 'MiSCapu' ) ):

    $miscapuPlugin  =   new MiSCapu();

    endif;

// Activation
register_activation_hook( __FILE__, [ $miscapuPlugin, 'activate' ] );
register_deactivation_hook( __FILE__, [ $miscapuPlugin, 'deactivate' ] );