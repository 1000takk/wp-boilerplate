<?php

namespace Core\Plugins;

/**
 * Yoast SEO plugin hooks.
 */
class SEOFramework
{
    /**
     * Set hooks.
     */
    public function __construct()
    {
        add_filter('the_seo_framework_indicator', '__return_false');
    }
}
