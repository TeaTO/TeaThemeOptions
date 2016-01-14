<?php
//Build data
$titles = array(
    'title' => __('Post types', OLZ_I18N),
    'name' => __('<span style="color:#3a71bb">Post types</span>', OLZ_I18N),
    'slug' => $slug,
    'submit' => false,
);
$details = array(
    array(
        'type' => 'heading',
        'level' => 2,
        'title' => __('The best Admin UI for creating <b>custom post types</b><br/>and <b>custom taxonomies</b> in WordPress easily.<br/><small style="color:#ccc;font-weight:700;">The Olympus Zeus post types engine</small>', OLZ_I18N),
        'style' => 'margin:60px 0;text-align:center;',
    ),
    array(
        'type' => 'posttype',
        'mode' => $mode,
    ),
    array(
        'type' => 'p',
        'content' => __('The Olympus Zeus post types engine lets you customize the WordPress admin panel by adding content types with custom fields and taxonomies. You will be able to craft the WordPress admin and turn it into your very own content management system.', OLZ_I18N),
    ),
    array(
        'type' => 'p',
        'content' => __('To learn more about Post Types, please see the official <a href="https://codex.wordpress.org/Post_Types" target="_blank">Codex WordPress website</a>.', OLZ_I18N),
    ),
);
