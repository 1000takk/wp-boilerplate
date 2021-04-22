<?php

namespace Core;

/**
 * Helpers class.
 */
class Helpers
{
    /**
     * Get plugin root url.
     *
     * @param  string $path  Optional. Path relative to the plugin URL. Default empty.
     * @return string Plugin root URL with optional path appended.
     */
    public static function pluginRootUrl($path = '')
    {
        $current_url = plugin_dir_url(__FILE__);
        preg_match('/(.*)\/(mu-)?plugins\/([^\/]*)\//', $current_url, $matches);
        return $matches[0] . $path;
    }

    /**
     * Get plugin root path.
     *
     * @param  string $path  Optional. Path relative to the plugin path. Default empty.
     * @return string Plugin root path with optional path appended.
     */
    public static function pluginRootPath($path = '')
    {
        $current_url = plugin_dir_path(__FILE__);
        preg_match('/(.*)\/(mu-)?plugins\/([^\/]*)\//', $current_url, $matches);
        return $matches[0] . $path;
    }
}
