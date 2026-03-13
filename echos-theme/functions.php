<?php
/**
 * ECHOS Theme - functions.php
 *
 * @package Echos
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* -------------------------------------------------------
   1. Theme support
------------------------------------------------------- */
function echos_theme_setup() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );

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

    add_theme_support(
        'custom-logo',
        array(
            'height'      => 60,
            'width'       => 200,
            'flex-height' => true,
            'flex-width'  => true,
        )
    );

    register_nav_menus(
        array(
            'primary' => __( 'Menu Principal', 'echos' ),
        )
    );
}
add_action( 'after_setup_theme', 'echos_theme_setup' );

/* -------------------------------------------------------
   2. Enqueue styles and scripts
------------------------------------------------------- */
function echos_enqueue_assets() {
    $theme_uri = get_template_directory_uri();
    $version   = wp_get_theme()->get( 'Version' );

    // Local self-hosted fonts.
    wp_enqueue_style(
        'echos-fonts',
        $theme_uri . '/assets/css/fonts.css',
        array(),
        $version
    );

    wp_enqueue_style(
        'echos-base',
        $theme_uri . '/assets/css/styles.css',
        array( 'echos-fonts' ),
        $version
    );

    wp_enqueue_style(
        'echos-popup',
        $theme_uri . '/assets/css/popup.css',
        array( 'echos-base' ),
        $version
    );

    if ( is_page_template( 'page-templates/template-productos.php' ) || is_post_type_archive( 'producto' ) ) {
        wp_enqueue_style( 'echos-productos', $theme_uri . '/assets/css/productos.css', array( 'echos-base' ), $version );
    }

    if ( is_page_template( 'page-templates/template-producto.php' ) || is_singular( 'producto' ) ) {
        wp_enqueue_style( 'echos-producto', $theme_uri . '/assets/css/producto.css', array( 'echos-base' ), $version );
    }

    if ( echos_is_template_active( 'page-templates/template-servicios-infraestructura.php' ) ) {
        wp_enqueue_style( 'echos-srv1', $theme_uri . '/assets/css/servicios-1.css', array( 'echos-base' ), $version );
    }

    if ( echos_is_template_active( 'page-templates/template-servicios-iluminacion.php' ) ) {
        wp_enqueue_style( 'echos-srv2', $theme_uri . '/assets/css/servicios-2.css', array( 'echos-base' ), $version );
    }

    if ( echos_is_template_active( 'page-templates/template-servicios-stands.php' ) ) {
        wp_enqueue_style( 'echos-srv3', $theme_uri . '/assets/css/servicios-3.css', array( 'echos-base' ), $version );
    }

    if ( is_page_template( 'page-templates/template-proyectos.php' ) || is_post_type_archive( 'proyecto' ) ) {
        wp_enqueue_style( 'echos-proyectos-page', $theme_uri . '/assets/css/proyectos-page.css', array( 'echos-base' ), $version );
        wp_enqueue_script( 'echos-proyectos-js', $theme_uri . '/assets/js/proyectos.js', array(), $version, true );
    }

    if ( is_page_template( 'page-templates/template-proyecto-individual.php' ) || is_singular( 'proyecto' ) ) {
        wp_enqueue_style( 'echos-proyecto-individual', $theme_uri . '/assets/css/proyecto-individual.css', array( 'echos-base' ), $version );
        wp_enqueue_script( 'echos-proyecto-individual-js', $theme_uri . '/assets/js/proyecto-individual.js', array(), $version, true );
    }

    if ( is_page_template( 'page-templates/template-nosotros.php' ) ) {
        wp_enqueue_style( 'echos-nosotros', $theme_uri . '/assets/css/nosotros.css', array( 'echos-base' ), $version );
        wp_enqueue_script( 'echos-nosotros-js', $theme_uri . '/assets/js/nosotros.js', array(), $version, true );
    }

    if ( is_page_template( 'page-templates/template-contacto.php' ) ) {
        wp_enqueue_style( 'echos-contacto', $theme_uri . '/assets/css/contacto.css', array( 'echos-base' ), $version );
        wp_enqueue_script( 'echos-contacto-js', $theme_uri . '/assets/js/contacto.js', array(), $version, true );
    }

    if ( is_page_template( 'page-templates/template-inicio.php' ) || is_front_page() ) {
        wp_enqueue_script( 'echos-app', $theme_uri . '/assets/js/app.js', array(), $version, true );
    }

    if ( is_page_template( 'page-templates/template-producto.php' ) || is_singular( 'producto' ) ) {
        wp_enqueue_script( 'echos-producto', $theme_uri . '/assets/js/producto.js', array(), $version, true );
    }

    wp_enqueue_script( 'echos-popup', $theme_uri . '/assets/js/popup.js', array(), $version, true );

    wp_enqueue_style( 'echos-sidebar-menu', $theme_uri . '/assets/css/sidebar-menu.css', array( 'echos-base' ), $version );
    wp_enqueue_script( 'echos-sidebar-menu', $theme_uri . '/assets/js/sidebar-menu.js', array(), $version, true );

    if ( echos_is_template_active( 'page-templates/template-servicios-infraestructura.php' ) ) {
        wp_enqueue_script( 'echos-srv1-js', $theme_uri . '/assets/js/servicios-1.js', array(), $version, true );
    }

    if ( echos_is_template_active( 'page-templates/template-servicios-iluminacion.php' ) ) {
        wp_enqueue_script( 'echos-srv2-js', $theme_uri . '/assets/js/servicios-2.js', array(), $version, true );
    }

    if ( echos_is_template_active( 'page-templates/template-servicios-stands.php' ) ) {
        wp_enqueue_script( 'echos-srv3-js', $theme_uri . '/assets/js/servicios-3.js', array(), $version, true );
    }
}
add_action( 'wp_enqueue_scripts', 'echos_enqueue_assets' );

/* -------------------------------------------------------
   3. Helper: asset URI
------------------------------------------------------- */
function echos_asset( $path ) {
    return get_template_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

/**
 * Checks if a template is active for the current singular object.
 * Works for pages and CPTs (e.g. servicio).
 *
 * @param string $template_slug Template file path.
 * @return bool
 */
function echos_is_template_active( $template_slug ) {
    if ( is_page_template( $template_slug ) ) {
        return true;
    }

    if ( ! is_singular() ) {
        return false;
    }

    $post_id = get_queried_object_id();
    if ( ! $post_id ) {
        return false;
    }

    return $template_slug === get_page_template_slug( $post_id );
}

/* -------------------------------------------------------
   4. Modular templates and admin data layer
------------------------------------------------------- */
require_once get_template_directory() . '/inc/home/defaults.php';
require_once get_template_directory() . '/inc/home/data.php';
require_once get_template_directory() . '/inc/admin/home-metabox.php';
require_once get_template_directory() . '/inc/nosotros/defaults.php';
require_once get_template_directory() . '/inc/nosotros/data.php';
require_once get_template_directory() . '/inc/admin/nosotros-metabox.php';
require_once get_template_directory() . '/inc/contact/defaults.php';
require_once get_template_directory() . '/inc/contact/data.php';
require_once get_template_directory() . '/inc/admin/contact-metabox.php';
require_once get_template_directory() . '/inc/service/defaults.php';
require_once get_template_directory() . '/inc/service/data.php';
require_once get_template_directory() . '/inc/service/render.php';
require_once get_template_directory() . '/inc/admin/service-metabox.php';
require_once get_template_directory() . '/inc/product/defaults.php';
require_once get_template_directory() . '/inc/product/data.php';
require_once get_template_directory() . '/inc/product/render.php';
require_once get_template_directory() . '/inc/admin/product-metabox.php';
require_once get_template_directory() . '/inc/project/defaults.php';
require_once get_template_directory() . '/inc/project/data.php';
require_once get_template_directory() . '/inc/admin/project-metabox.php';
require_once get_template_directory() . '/inc/content-types.php';

/* -------------------------------------------------------
   5. Cleanup WP head
------------------------------------------------------- */
function echos_cleanup_head() {
    remove_action( 'wp_head', 'wp_generator' );
    remove_action( 'wp_head', 'wlwmanifest_link' );
    remove_action( 'wp_head', 'rsd_link' );
    remove_action( 'wp_head', 'wp_shortlink_wp_head' );
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}
add_action( 'after_setup_theme', 'echos_cleanup_head' );

/* -------------------------------------------------------
   6. Sidebar walker with submenu toggles
------------------------------------------------------- */
if ( ! class_exists( 'Echos_Sidebar_Walker' ) ) :

class Echos_Sidebar_Walker extends Walker_Nav_Menu {

    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent  = str_repeat( "\t", $depth );
        $output .= "\n{$indent}<ul class=\"sub-menu\">\n";
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent  = str_repeat( "\t", $depth );
        $output .= "{$indent}</ul>\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = $depth ? str_repeat( "\t", $depth ) : '';

        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $has_children = in_array( 'menu-item-has-children', $classes, true );

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id_attr = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
        $id_attr = $id_attr ? ' id="' . esc_attr( $id_attr ) . '"' : '';

        $output .= $indent . '<li' . $id_attr . $class_names . '>';

        $atts           = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
        $atts['href']   = ! empty( $item->url ) ? $item->url : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value       = 'href' === $attr ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $submenu_toggle = '';
        if ( $has_children ) {
            $submenu_toggle = '<button class="echos-submenu-toggle" type="button" aria-label="' . esc_attr__( 'Expandir submenu', 'echos' ) . '">'
                . '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>'
                . '</button>';
        }

        $item_output  = $args->before ?? '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= ( $args->link_before ?? '' ) . $title . ( $args->link_after ?? '' );
        $item_output .= $submenu_toggle;
        $item_output .= '</a>';
        $item_output .= $args->after ?? '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}

endif;








