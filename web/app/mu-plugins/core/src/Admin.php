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
    }

    /**
     * Add styles and scripts for admin area.
     */
    public function enqueueStylesScripts()
    {
        wp_enqueue_style("{$this->module_slug}-css", Helpers::pluginRootUrl('assets/css/main.css'));
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
            remove_menu_page('themes.php');
            add_menu_page(
                __('Customize'),
                __('Customize'),
                'edit_theme_options',
                'customize.php',
                '',
                'dashicons-admin-appearance',
                60
            );
            remove_menu_page('plugins.php');
        }
    }
}
