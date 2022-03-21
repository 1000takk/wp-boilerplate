<?php

namespace Core\Plugins;

use function Env\env;

/**
 * ACF plugin hooks.
 */
class ACF
{
    /**
     * Set hooks.
     */
    public function __construct()
    {
        add_filter('acf/fields/wysiwyg/toolbars', function ($toolbars) {
            $toolbars['Simple'] = [];
            $toolbars['Simple'][1] = [
                'bold' ,
                'italic' ,
                'underline',
                'strikethrough',
                'link',
                'unlink',
                'bullist',
                'numlist',
                'removeformat',
            ];
            return $toolbars;
        });

        if (env('WP_ENV') === 'production') {
            add_filter('acf/settings/show_admin', '__return_false');
        }
    }
}
