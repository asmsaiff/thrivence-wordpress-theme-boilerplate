<?php
	if ( ! defined( '_S_VERSION' ) ) {
		// Replace the version number of the theme on each release.
		define( '_S_VERSION', '1.0.0' );
	}

	if ( ! function_exists( 'thrivence_setup' ) ) :
		function thrivence_setup() {
			load_theme_textdomain( 'thrivence', get_template_directory() . '/languages' );

			// Add default posts and comments RSS feed links to head.
			add_theme_support( 'automatic-feed-links' );
			add_theme_support( 'title-tag' );
			add_theme_support( 'post-thumbnails' );

			// This theme uses wp_nav_menu() in one location.
			register_nav_menus(
				array(
					'menu-1' => esc_html__( 'Primary', 'thrivence' ),
				)
			);

			add_theme_support(
				'html5',
				array(
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'style',
					'script',
				)
			);

			// Set up the WordPress core custom background feature.
			add_theme_support(
				'custom-background',
				apply_filters(
					'thrivence_custom_background_args',
					array(
						'default-color' => 'ffffff',
						'default-image' => '',
					)
				)
			);

			// Add theme support for selective refresh for widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );

			/**
			 * Add support for core custom logo.
			 *
			 * @link https://codex.wordpress.org/Theme_Logo
			 */
			add_theme_support(
				'custom-logo',
				array(
					'height'      => 250,
					'width'       => 250,
					'flex-width'  => true,
					'flex-height' => true,
				)
			);
		}
	endif;
	add_action( 'after_setup_theme', 'thrivence_setup' );

	function thrivence_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'thrivence_content_width', 640 );
	}
	add_action( 'after_setup_theme', 'thrivence_content_width', 0 );

	function thrivence_widgets_init() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Sidebar', 'thrivence' ),
				'id'            => 'sidebar-1',
				'description'   => esc_html__( 'Add widgets here.', 'thrivence' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
	add_action( 'widgets_init', 'thrivence_widgets_init' );

	/**
	 * Enqueue scripts and styles.
	 */
	function thrivence_scripts() {
		wp_enqueue_style( 'thrivence-style', get_stylesheet_uri(), array(), _S_VERSION );
		wp_style_add_data( 'thrivence-style', 'rtl', 'replace' );

		wp_enqueue_script( 'thrivence-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'thrivence_scripts' );

	/**
	 * Implement the Custom Header feature.
	 */
	require get_template_directory() . '/inc/custom-header.php';

	/**
	 * Custom template tags for this theme.
	 */
	require get_template_directory() . '/inc/template-tags.php';

	/**
	 * Functions which enhance the theme by hooking into WordPress.
	 */
	require get_template_directory() . '/inc/template-functions.php';

	/**
	 * Customizer additions.
	 */
	require get_template_directory() . '/inc/customizer.php';

	/**
	 * Load WooCommerce compatibility file.
	 */
	if ( class_exists( 'WooCommerce' ) ) {
		require get_template_directory() . '/inc/woocommerce.php';
	}
