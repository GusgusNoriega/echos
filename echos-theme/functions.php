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
    $theme_dir = get_template_directory();
    $version   = wp_get_theme()->get( 'Version' );

    $forms_loader_css_path    = $theme_dir . '/assets/css/forms-loader.css';
    $forms_loader_css_version = file_exists( $forms_loader_css_path ) ? (string) filemtime( $forms_loader_css_path ) : $version;
    wp_register_style(
        'echos-forms-loader',
        $theme_uri . '/assets/css/forms-loader.css',
        array( 'echos-base' ),
        $forms_loader_css_version
    );

    $forms_loader_js_path    = $theme_dir . '/assets/js/forms-loader.js';
    $forms_loader_js_version = file_exists( $forms_loader_js_path ) ? (string) filemtime( $forms_loader_js_path ) : $version;
    wp_register_script(
        'echos-forms-loader',
        $theme_uri . '/assets/js/forms-loader.js',
        array(),
        $forms_loader_js_version,
        true
    );

    $fonts_css_path    = $theme_dir . '/assets/css/fonts.css';
    $fonts_css_version = file_exists( $fonts_css_path ) ? (string) filemtime( $fonts_css_path ) : $version;

    // Local self-hosted fonts.
    wp_enqueue_style(
        'echos-fonts',
        $theme_uri . '/assets/css/fonts.css',
        array(),
        $fonts_css_version
    );

    wp_enqueue_style(
        'echos-base',
        $theme_uri . '/assets/css/styles.css',
        array( 'echos-fonts' ),
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

    $is_service_template = echos_is_template_active( 'page-templates/template-servicios-infraestructura.php' )
        || echos_is_template_active( 'page-templates/template-servicios-iluminacion.php' )
        || echos_is_template_active( 'page-templates/template-servicios-stands.php' );

    if ( $is_service_template ) {
        $srv_additional_css_path    = $theme_dir . '/assets/css/servicios-additional.css';
        $srv_additional_css_version = file_exists( $srv_additional_css_path ) ? (string) filemtime( $srv_additional_css_path ) : $version;
        wp_enqueue_style(
            'echos-srv-additional',
            $theme_uri . '/assets/css/servicios-additional.css',
            array( 'echos-base' ),
            $srv_additional_css_version
        );
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
        $contact_js_path    = $theme_dir . '/assets/js/contacto.js';
        $contact_js_version = file_exists( $contact_js_path ) ? (string) filemtime( $contact_js_path ) : $version;
        wp_enqueue_script( 'echos-contacto-js', $theme_uri . '/assets/js/contacto.js', array( 'echos-forms-loader' ), $contact_js_version, true );
    }

    if ( is_page_template( 'page-templates/template-inicio.php' ) || is_front_page() ) {
        $app_js_path    = $theme_dir . '/assets/js/app.js';
        $app_js_version = file_exists( $app_js_path ) ? (string) filemtime( $app_js_path ) : $version;
        wp_enqueue_script( 'echos-app', $theme_uri . '/assets/js/app.js', array( 'echos-forms-loader' ), $app_js_version, true );
    }

    if ( is_page_template( 'page-templates/template-producto.php' ) || is_singular( 'producto' ) ) {
        wp_enqueue_script( 'echos-producto', $theme_uri . '/assets/js/producto.js', array(), $version, true );
    }

    if ( function_exists( 'echos_popup_should_render' ) && echos_popup_should_render() ) {
        $popup_js_path    = $theme_dir . '/assets/js/popup.js';
        $popup_js_version = file_exists( $popup_js_path ) ? (string) filemtime( $popup_js_path ) : $version;

        wp_enqueue_style(
            'echos-popup',
            $theme_uri . '/assets/css/popup.css',
            array( 'echos-base' ),
            $version
        );
        wp_enqueue_script( 'echos-popup', $theme_uri . '/assets/js/popup.js', array( 'echos-forms-loader' ), $popup_js_version, true );
    }

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

    if ( $is_service_template ) {
        $srv_additional_js_path    = $theme_dir . '/assets/js/servicios-additional.js';
        $srv_additional_js_version = file_exists( $srv_additional_js_path ) ? (string) filemtime( $srv_additional_js_path ) : $version;
        wp_enqueue_script(
            'echos-srv-additional-js',
            $theme_uri . '/assets/js/servicios-additional.js',
            array(),
            $srv_additional_js_version,
            true
        );
    }

    if ( function_exists( 'echos_forms_get_frontend_config' ) ) {
        $forms_config = echos_forms_get_frontend_config();
        $form_handles = array(
            'echos-app',
            'echos-contacto-js',
            'echos-popup',
        );
        $has_form_script = false;

        foreach ( $form_handles as $handle ) {
            if ( wp_script_is( $handle, 'enqueued' ) ) {
                $has_form_script = true;
                wp_localize_script( $handle, 'echosFormsConfig', $forms_config );
            }
        }

        if ( $has_form_script ) {
            wp_enqueue_style( 'echos-forms-loader' );
        }
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
require_once get_template_directory() . '/inc/footer/defaults.php';
require_once get_template_directory() . '/inc/footer/data.php';
require_once get_template_directory() . '/inc/admin/footer-options.php';
require_once get_template_directory() . '/inc/analytics/defaults.php';
require_once get_template_directory() . '/inc/analytics/data.php';
require_once get_template_directory() . '/inc/admin/analytics-options.php';
require_once get_template_directory() . '/inc/popup/defaults.php';
require_once get_template_directory() . '/inc/popup/data.php';
require_once get_template_directory() . '/inc/admin/popup-metabox.php';
require_once get_template_directory() . '/inc/forms/defaults.php';
require_once get_template_directory() . '/inc/forms/data.php';
require_once get_template_directory() . '/inc/admin/forms-options.php';
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








