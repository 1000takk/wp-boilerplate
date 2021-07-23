<?php
/**
 * Configuration overrides for WP_ENV === 'production'
 */

use Roots\WPConfig\Config;

/**
 * Disable Automatic Database Optimizing
 * @see https://wordpress.org/support/article/editing-wp-config-php/#automatic-database-optimizing
 */
Config::define( 'WP_ALLOW_REPAIR', false );

/**
 * Disallow files width extensions other than images/video/pdf to be uploaded.
 * Warning, this also disallow SVG
 * @see https://developer.wordpress.org/reference/functions/map_meta_cap/
 */
Config::define( 'ALLOW_UNFILTERED_UPLOADS', false ); // interdit l'upload non filtré

/**
 * Avoid malicious HTML to be inserted in posts.
 * Warning, this also disallow iframe and script tags to be included
 * @see https://developer.wordpress.org/reference/functions/map_meta_cap/
 */
// Config::define( 'DISALLOW_UNFILTERED_HTML', true );

/**
 * Disable the Plugin and Theme Editor
 * @see https://wordpress.org/support/article/editing-wp-config-php/#disable-the-plugin-and-theme-editor
 */
Config::define( 'DISALLOW_FILE_EDIT', true ); // supprime l'éditeur de fichiers CSS et PHP

/**
 * Avoid Site URL to be modified in  the option table
 * @see https://wordpress.org/support/article/changing-the-site-url/#relocate-method
 */
Config::define( 'RELOCATE', false );

/**
 * Hide DB Errors on WP Multisite install
 * @see https://developer.wordpress.org/reference/classes/wpdb/print_error/#source
 */
Config::define( 'DIEONDBERROR', false );


/**
 * Define where Error logs should be stored on WP Multisite install
 * @see https://developer.wordpress.org/reference/classes/wpdb/print_error/#source
 */
// define( 'ERRORLOGFILE', 'absolute/path/to/file.log' );