<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Acme Themes
 * @subpackage Online Shop
 */

/**
 * online_shop_action_before_head hook
 * @since Online Shop 1.0.0
 *
 * @hooked online_shop_set_global -  0
 * @hooked online_shop_doctype -  10
 */
do_action( 'online_shop_action_before_head' );?>
	<head>

		<?php
		/**
		 * online_shop_action_before_wp_head hook
		 * @since Online Shop 1.0.0
		 *
		 * @hooked online_shop_before_wp_head -  10
		 */
		do_action( 'online_shop_action_before_wp_head' );

		wp_head();
		?>
      <!--Add the following script at the bottom of the web page (before </body></html>)-->
<script type="text/javascript">function add_chatinline(){var hccid=25423360;var nt=document.createElement("script");nt.async=true;nt.src="https://mylivechat.com/chatinline.aspx?hccid="+hccid;var ct=document.getElementsByTagName("script")[0];ct.parentNode.insertBefore(nt,ct);}
add_chatinline();</script>
      
      
      <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122938330-1"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-122938330-1');
        </script>

	</head>
<body <?php body_class();
/**
 * online_shop_action_body_attr hook
 * @since Online Shop 1.0.0
 *
 * @hooked online_shop_body_attr- 10
 */
do_action( 'online_shop_action_body_attr' );?>>

<?php
/**
 * online_shop_action_before hook
 * @since Online Shop 1.0.0
 *
 * @hooked online_shop_page_start - 10
 * @hooked online_shop_page_start - 15
 */
do_action( 'online_shop_action_before' );

/**
 * online_shop_action_before_header hook
 * @since Online Shop 1.0.0
 *
 * @hooked online_shop_skip_to_content - 10
 */
do_action( 'online_shop_action_before_header' );

/**
 * online_shop_action_header hook
 * @since Online Shop 1.0.0
 *
 * @hooked online_shop_after_header - 10
 */
do_action( 'online_shop_action_header' );

/**
 * online_shop_action_after_header hook
 * @since Online Shop 1.0.0
 *
 * @hooked null
 */
do_action( 'online_shop_action_after_header' );

/**
 * online_shop_action_before_content hook
 * @since Online Shop 1.0.0
 *
 * @hooked online_shop_before_content - 10
 */
do_action( 'online_shop_action_before_content' );