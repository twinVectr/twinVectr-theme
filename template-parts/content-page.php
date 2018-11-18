<?php
/**
 * Template part for displaying page content in page.php
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package twinVectr Theme
 */

while (have_posts()): the_post();
    the_content();
endwhile;
