<?php

namespace Core;

use function Env\env;

/**
 * Main Admin Class
 */
class Admin
{
    /** @var string Module slug */
    protected $module_slug = 'core-admin';

    /**
     * Set hooks.
     */
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [ $this, 'enqueueStylesScripts' ]);
        add_action('wp_before_admin_bar_render', [ $this, 'adminBarNoLogo' ], 0);
        add_action('wp_dashboard_setup', [ $this, 'removeDashboardWidgets' ]);
        add_action('wp_before_admin_bar_render', [$this, 'cleanAdminBar'], 0);
        add_action('admin_menu', [$this, 'cleanAdminMenu']);
        add_filter('tiny_mce_before_init', [$this, 'filterContentOnPaste']);
    }

    /**
     * Add styles and scripts for admin area.
     */
    public function enqueueStylesScripts()
    {
        wp_enqueue_style($this->module_slug, Helpers::pluginRootUrl('assets/css/main.css'));
    }

    /**
     * Remove WP logo in admin bar.
     */
    public function adminBarNoLogo()
    {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
    }

    /**
     * Remove unused dashboard widgets.
     */
    public function removeDashboardWidgets()
    {
        global $wp_meta_boxes;
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    }

    /**
     * Clean the admin bar
     *
     * @return void
     */
    public function cleanAdminBar()
    {
        global $wp_admin_bar;
        $wp_admin_bar->remove_node('new-media');
    }

    /**
     * Clean admin menu
     *
     * @return void
     */
    public function cleanAdminMenu()
    {
        if (env('WP_ENV') === 'production') {
            remove_submenu_page('themes.php', 'themes.php');
            remove_menu_page('plugins.php');
        }
    }

    /**
     * Filter copied content on paste
     *  - Strip unwanted tags
     *  - Strip all HTML attributes excepted href on a tags
     *  - Remove multiple empty paragraphs
     *
     * @param $in array
     * @return array
     */
    public function filterContentOnPaste(array $in): array
    {
        $in['paste_preprocess'] = "function(pl,o){ 
            // remove the following tags completely:
            o.content = o.content.replace(/<\/*(applet|area|article|aside|audio|base|basefont|bdi|bdo|body|canvas|command|datalist|embed|figcaption|figure|font|footer|frame|frameset|head|header|hgroup|hr|html|img|keygen|link|map|mark|menu|meta|meter|nav|noframes|noscript|object|optgroup|output|param|progress|rp|rt|ruby|script|section|source|span|style|time|title|track|video|wbr)[^>]*>/gi,'');
            // remove all attributes from these tags:
            o.content = o.content.replace(/<(details|summary|div|table|tbody|tr|td|th|p|b|font|strong|i|em|h1|h2|h3|h4|h5|h6|hr|ul|li|ol|code|blockquote|address|dir|dt|dd|dl|big|cite|del|dfn|ins|kbd|q|samp|small|s|strike|sub|sup|tt|u|var|caption) [^>]*>/gi,'<$1>');
            // keep only href in the a tag (needs to be refined to also keep _target and ID):
            // o.content = o.content.replace(/<a [^>]*href=(\"|')(.*?)(\"|')[^>]*>/gi,'<a href=\"$2\">');
            // replace div tag with p tag:
            o.content = o.content.replace(/<(\/)*div[^>]*>/gi,'<$1p>');
            // remove double paragraphs:
            o.content = o.content.replace(/<\/p>[\s\\r\\n]+<\/p>/gi,'</p></p>');
            o.content = o.content.replace(/<\<p>[\s\\r\\n]+<p>/gi,'<p><p>');
            o.content = o.content.replace(/<\/p>[\s\\r\\n]+<\/p>/gi,'</p></p>');
            o.content = o.content.replace(/<\<p>[\s\\r\\n]+<p>/gi,'<p><p>');
            o.content = o.content.replace(/(<\/p>)+/gi,'</p>');
            o.content = o.content.replace(/(<p>)+/gi,'<p>');
          }";
        return $in;
    }
}
