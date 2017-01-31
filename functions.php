<?php
/**
 * Twenty Fifteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Twenty Fifteen 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

/**
 * Twenty Fifteen only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentyfifteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyfifteen
	 * If you're building a theme based on twentyfifteen, use a find and replace
	 * to change 'twentyfifteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentyfifteen' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'twentyfifteen' ),
		'social'  => __( 'Social Links Menu', 'twentyfifteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	/*
	 * Enable support for custom logo.
	 *
	 * @since Twenty Fifteen 1.5
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 248,
		'width'       => 248,
		'flex-height' => true,
	) );

	$color_scheme  = twentyfifteen_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.

	/**
	 * Filter Twenty Fifteen custom-header support arguments.
	 *
	 * @since Twenty Fifteen 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type string $default-color     		Default color of the header.
	 *     @type string $default-attachment     Default attachment of the header.
	 * }
	 */
	add_theme_support( 'custom-background', apply_filters( 'twentyfifteen_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentyfifteen_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'twentyfifteen_setup' );

/**
 * Register widget area.
 *
 * @since Twenty Fifteen 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function twentyfifteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'twentyfifteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyfifteen_widgets_init' );

if ( ! function_exists( 'twentyfifteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Fifteen.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentyfifteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Serif, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'twentyfifteen' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Fifteen 1.1
 */
function twentyfifteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyfifteen_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyfifteen-fonts', twentyfifteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfifteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'twentyfifteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfifteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'twentyfifteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'twentyfifteen-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_scripts' );

/**
 * Add preconnect for Google Fonts.
 *
 * @since Twenty Fifteen 1.7
 *
 * @param array   $urls          URLs to print for resource hints.
 * @param string  $relation_type The relation type the URLs are printed.
 * @return array URLs to print for resource hints.
 */
function twentyfifteen_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'twentyfifteen-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '>=' ) ) {
			$urls[] = array(
				'href' => 'https://fonts.gstatic.com',
				'crossorigin',
			);
		} else {
			$urls[] = 'https://fonts.gstatic.com';
		}
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'twentyfifteen_resource_hints', 10, 2 );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Twenty Fifteen 1.0
 *
 * @see wp_add_inline_style()
 */
function twentyfifteen_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'twentyfifteen-style', $css );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function twentyfifteen_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'twentyfifteen_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function twentyfifteen_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'twentyfifteen_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Twenty Fifteen 1.0
 */
//去掉wordpress.org
require get_template_directory() . '/inc/customizer.php';
function coolwp_remove_meta_widget() {
    unregister_widget('WP_Widget_Meta');
    register_widget('WP_Widget_Meta_Mod');
}
 
add_action( 'widgets_init', 'coolwp_remove_meta_widget' );
 
 
class WP_Widget_Meta_Mod extends WP_Widget {
 
    function __construct() {
    $widget_ops = array('classname' => 'widget_meta', 'description' => __( "Log in/out, admin, feed and WordPress links") );
    parent::__construct('meta', __('Meta'), $widget_ops);
    }
 
    function widget( $args, $instance ) {
    extract($args);
    $title = apply_filters('widget_title', empty($instance['title']) ? __('Meta') : $instance['title'], $instance, $this->id_base);
 
    echo $before_widget;
    if ( $title )
    echo $before_title . $title . $after_title;
    ?>
    <ul>
    <?php wp_register(); ?>
    <li><?php wp_loginout(); ?></li>
    <?php wp_meta(); ?>
    </ul>
    <?php
    echo $after_widget;
    }
 
    function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
 
    return $instance;
    }
 
    function form( $instance ) {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = strip_tags($instance['title']);
    ?>
    <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
    <?php
    }
}

// Customize your functions
//function mail_smtp( $phpmailer ){
$phpmailer->From = ""; //发件人
$phpmailer->FromName = ""; //发件人昵称
$phpmailer->Host = "smtp.qq.com"; //SMTP服务器地址(比如QQ是smtp.qq.com,腾讯企业邮箱是smtp.exmail.qq.com,阿里云是smtp.域名,其他自行咨询邮件服务商)
$phpmailer->Port = 25; //SMTP端口，常用的有25、465、587，SSL加密连接端口：465或587,qq是25,qq企业邮箱是465
$phpmailer->SMTPSecure = ""; //SMTP加密方式，常用的有ssl/tls,一般25端口不填，端口465天ssl
$phpmailer->Username = ""; //邮箱帐号，一般和发件人相同
$phpmailer->Password = ""; //邮箱密码
$phpmailer->IsSMTP(); //使用SMTP发送
$phpmailer->SMTPAuth = true; //启用SMTPAuth服务
}
add_action('phpmailer_init','mail_smtp');

function remove_dashboard_widgets() {
    global $wp_meta_boxes;
  
    //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);    //快速发布
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);    //WordPress China 博客
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);  //其它WordPress新闻
    //unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);  //近期草稿
  
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);//链入链接
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);     //概况
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);   //插件
    //unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);//近期评论
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

function reset_password_message( $message, $key ) {  
  if ( strpos($_POST['user_login'], '@') ) {  
    $user_data = get_user_by('email', trim($_POST['user_login']));  
  } else {  
    $login = trim($_POST['user_login']);  
    $user_data = get_user_by('login', $login);  
  }  
  $user_login = $user_data->user_login;  
  $msg = __('有人要求重设如下帐号的密码：'). "\r\n\r\n";  
  $msg .= network_site_url() . "\r\n\r\n";  
  $msg .= sprintf(__('用户名：%s'), $user_login) . "\r\n\r\n";  
  $msg .= __('若这不是您本人要求的，请忽略本邮件。') . "\r\n\r\n";  
  $msg .= __('要重置您的密码，请打开下面的链接：'). "\r\n\r\n";  
  $msg .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') ;  
  return $msg;  
}  
add_filter('retrieve_password_message', reset_password_message, null, 2);

/**
 * WordPress 关闭 XML-RPC 的 pingback 端口
 * https://www.wpdaxue.com/remove-xmlrpc-pingback-ping.html
 */
add_filter( 'xmlrpc_methods', 'remove_xmlrpc_pingback_ping' );
function remove_xmlrpc_pingback_ping( $methods ) {
	unset( $methods['pingback.ping'] );
	return $methods;
}

/*-----------------------------------------------------------------------------------*/
# 在 WordPress 编辑器添加“下一页”按钮
# https://www.wpdaxue.com/add-next-page-button-wordpress-post-editor.html
/*-----------------------------------------------------------------------------------*/
add_filter( 'mce_buttons', 'cmp_add_page_break_button', 1, 2 );
function cmp_add_page_break_button( $buttons, $id ){
    if ( 'content' != $id )
        return $buttons;
    array_splice( $buttons, 13, 0, 'wp_page' );
    return $buttons;
}

/**
 * WordPress 禁止用户编辑个人资料的某些字段
 * https://www.wpdaxue.com/disable-profile-fields.html
 */
global $pagenow;
if ( !current_user_can( 'manage_options' ) && $pagenow == 'profile.php' ) {
	add_action( 'admin_footer', 'disable_userprofile_fields' );
}
 
function disable_userprofile_fields() {
	?>
	<script>
		jQuery(document).ready( function($) {
 
			//禁止编辑“电子邮件”（input 举例）
			if ( $('input[name=email]').length ) {
				$('input[name=email]').attr("readonly", "readon ly");
			}
 
			//禁止编辑“个人说明”（textarea 举例）
		        if ( $('textarea[name=description]').length ) {
				$('textarea[name=description]').attr("enabled", "enabled");
        		}
 
			//禁止编辑“公开显示为”（select 举例）
			if ( $('select[name=display_name]').length ) {
				$('select[name=display_name]').attr("enabled", "enabled");
			}
 
		});
	</script>
	<?php
}

/**
 * WordPress 后台用户列表添加上次登录时间
 * https://www.wpdaxue.com/wp-user-last-login-date.html
 */
// 创建一个新字段存储用户登录时间
function insert_last_login( $login ) {
	global $user_id;
	$user = get_userdatabylogin( $login );
	update_user_meta( $user->ID, 'last_login', current_time( 'mysql' ) );
}
add_action( 'wp_login', 'insert_last_login' );
 
// 添加一个新栏目“上次登录”
function add_last_login_column( $columns ) {
	$columns['last_login'] = '上次登录';
	return $columns;
}
add_filter( 'manage_users_columns', 'add_last_login_column' );
 
// 显示登录时间到新增栏目
function add_last_login_column_value( $value, $column_name, $user_id ) {
	$user = get_userdata( $user_id );
	if ( 'last_login' == $column_name && $user->last_login )
		$value = get_user_meta( $user->ID, 'last_login', ture );
	else $value = '从未登录';
	return $value;
}
add_action( 'manage_users_custom_column', 'add_last_login_column_value', 10, 3 );

/**
 *（全网独家）如何正确的避免你的 WordPress 管理员登录用户名被暴露 - 龙笑天下
 * http://www.ilxtx.com/further-hide-your-wordpress-admin-username.html
 * 说明：直接去掉函数 comment_class() 和 body_class() 中输出的 "comment-author-" 和 "author-"
 */
function lxtx_comment_body_class($content){ 
    $pattern = "/(.*?)([^>]*)author-([^>]*)(.*?)/i";
    $replacement = '$1$4';
    $content = preg_replace($pattern, $replacement, $content);  
    return $content;
}
add_filter('comment_class', 'lxtx_comment_body_class');
add_filter('body_class', 'lxtx_comment_body_class');

/* 替换图片链接为 https */
function my_content_manipulator($content){
    if( is_ssl() ){
        $content = str_replace('http://xxx.cn/wp-content/uploads', 'https://xxx.cn/wp-content/uploads', $content);
    }
    return $content;
}
add_filter('the_content', 'my_content_manipulator');