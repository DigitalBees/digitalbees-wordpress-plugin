<?php 
namespace DigitalBeesWPVideo;

/**
 * Manage SRAPIQ sdk
 */
class Embed {

    /**
     * add [dbees] tag into wordpress flow
     */
    public function addShortLink()
    {
        add_shortcode('dbees', array( &$this, 'embedVideo'));
    }

    /**
     * Parse post and replace [dbees] tags with div[id=random]
     */
    public function embedVideo($atts)
    {
        $idRandom = "dbees-".rand(0, 1000);
        $options['apikey'] = get_option(DIGITALBEES_API_KEY);
        $options['width'] = (isset($atts['width'])) ? $atts['width'] : get_option(DIGITALBEES_PLAYER_WIDTH);
        $options['height'] = (isset($atts['height'])) ? $atts['height'] : get_option(DIGITALBEES_PLAYER_HEIGHT);
        $options['idEl'] = $idRandom;
        $options['id'] = $atts['id'];
        return "<div id={$idRandom}></div><script>_dbeesWPvideo.init(".json_encode($options).");</script";
    }

    /**
     * Used by hook: 'customize_preview_init'
     * @see add_action('customize_preview_init',$func)
     */
    public static function init()
    {
        wp_enqueue_script(
            'mytheme-themecustomizer',
            DigitalBeesWpVideo_URL.'assets/js/script.js',
            array(),
            '',	
            false
        );
    }
}