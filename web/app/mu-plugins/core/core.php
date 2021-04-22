<?php
/*
Plugin Name: Core plugin
Plugin URI: http://1000takk.fr
Description: Define core behaviors for Boilerplate
Version: 1.0
Author: 1000takk
Author URI: https://guillaumemutschler.eu
Author Email: guillaume.mutschler@1000takk.fr
Text Domain: core
*/

namespace Core;

require_once 'autoloader.php';

/**
 * Load core plugin.
 */
class Loader
{
    /**
     * Load all dependencies.
     */
    public function __construct()
    {
        /* TODO: add a cookie consent manager */
        new Medias();

        $this->registerHooks();
        $this->registerPlugins();
        $this->registerSchedules();

        if (is_admin()) {
            new Admin();
        }
    }

    /**
     * Register core post types.
     */
    protected function registerHooks()
    {
        add_action('plugins_loaded', [$this, 'loadTextDomain']);
        add_action('wp_enqueue_scripts', [$this, 'deregisterJquery']);
    }

    /**
     * Loads the core plugin's translated strings.
     */
    public function loadTextDomain()
    {
        load_muplugin_textdomain('core', plugin_basename(dirname(__FILE__)) . '/languages/');
    }

    /**
     * Prevent jQuery to be loaded on the site
     */
    public function deregisterJquery()
    {
        wp_deregister_script('jquery');
    }

    /**
     * Register plugin-centric hooks & filters.
     */
    protected function registerPlugins()
    {
        /* TODO: Add customization for matomo, secupress and jetpack */
        new Plugins\SEOFramework();
        new Plugins\ACF();
    }

    /**
     * Register core schedules.
     */
    protected function registerSchedules()
    {
        // new Schedules\Example();
    }
}

new Loader();
