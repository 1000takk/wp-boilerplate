<?php

namespace Core;

/**
 * Media custom sizes and behaviors.
 */
class Medias
{
    /**
     * Set hooks.
     */
    public function __construct()
    {
        add_filter('image_resize_dimensions', [ $this, 'crop' ], 10, 6);
    }

    /**
     * Add real crop functionality.
     */
    public function crop($default, $orig_w, $orig_h, $new_w, $new_h, $crop)
    {
        if (!$crop) {
            return null; // let the wordpress default function handle this
        }

        $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

        $crop_w = round($new_w / $size_ratio);
        $crop_h = round($new_h / $size_ratio);

        $s_x = floor(($orig_w - $crop_w) / 2);
        $s_y = floor(($orig_h - $crop_h) / 2);

        return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
    }
}
