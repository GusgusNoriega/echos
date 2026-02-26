<?php
/**
 * ECHOS Theme - functions.php
 * Autor: Gustavo Noriega
 *
 * @package Echos
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* -------------------------------------------------------
   1. Soporte del tema
------------------------------------------------------- */
function echos_theme_setup() {
    // Soporte de título dinámico
    add_theme_support( 'title-tag' );

    // Soporte de thumbnails
    add_theme_support( 'post-thumbnails' );

    // HTML5
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Logo personalizado
    add_theme_support( 'custom-logo', array(
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    // Registrar menú de navegación
    register_nav_menus( array(
        'primary' => __( 'Menú Principal', 'echos' ),
    ) );
}
add_action( 'after_setup_theme', 'echos_theme_setup' );

/* -------------------------------------------------------
   2. Encolar estilos y scripts
------------------------------------------------------- */
function echos_enqueue_assets() {
    $theme_uri = get_template_directory_uri();
    $version   = wp_get_theme()->get( 'Version' );

    // ── Google Fonts ──
    wp_enqueue_style(
        'echos-google-fonts',
        'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,700;1,800;1,900&display=swap',
        array(),
        null
    );

    // ── CSS base (styles.css) ──
    wp_enqueue_style(
        'echos-base',
        $theme_uri . '/assets/css/styles.css',
        array( 'echos-google-fonts' ),
        $version
    );

    // ── CSS popup ──
    wp_enqueue_style(
        'echos-popup',
        $theme_uri . '/assets/css/popup.css',
        array( 'echos-base' ),
        $version
    );

    // ── CSS condicionales por template ──
    if ( is_page_template( 'page-templates/template-productos.php' ) ) {
        wp_enqueue_style( 'echos-productos', $theme_uri . '/assets/css/productos.css', array( 'echos-base' ), $version );
    }

    if ( is_page_template( 'page-templates/template-producto.php' ) ) {
        wp_enqueue_style( 'echos-producto', $theme_uri . '/assets/css/producto.css', array( 'echos-base' ), $version );
    }

    if ( is_page_template( 'page-templates/template-servicios-infraestructura.php' ) ) {
        wp_enqueue_style( 'echos-srv1', $theme_uri . '/assets/css/servicios-1.css', array( 'echos-base' ), $version );
    }

    if ( is_page_template( 'page-templates/template-servicios-iluminacion.php' ) ) {
        wp_enqueue_style( 'echos-srv2', $theme_uri . '/assets/css/servicios-2.css', array( 'echos-base' ), $version );
    }

    if ( is_page_template( 'page-templates/template-servicios-stands.php' ) ) {
        wp_enqueue_style( 'echos-srv3', $theme_uri . '/assets/css/servicios-3.css', array( 'echos-base' ), $version );
    }

    // ── JavaScript ──
    // app.js solo en la página de inicio
    if ( is_page_template( 'page-templates/template-inicio.php' ) || is_front_page() ) {
        wp_enqueue_script( 'echos-app', $theme_uri . '/assets/js/app.js', array(), $version, true );
    }

    // producto.js solo en la página de producto
    if ( is_page_template( 'page-templates/template-producto.php' ) ) {
        wp_enqueue_script( 'echos-producto', $theme_uri . '/assets/js/producto.js', array(), $version, true );
    }

    // popup.js en todas las páginas
    wp_enqueue_script( 'echos-popup', $theme_uri . '/assets/js/popup.js', array(), $version, true );

    // ── Sidebar Menu (global) ──
    wp_enqueue_style( 'echos-sidebar-menu', $theme_uri . '/assets/css/sidebar-menu.css', array( 'echos-base' ), $version );
    wp_enqueue_script( 'echos-sidebar-menu', $theme_uri . '/assets/js/sidebar-menu.js', array(), $version, true );

    // Servicios JS inline → ahora como archivos independientes
    if ( is_page_template( 'page-templates/template-servicios-infraestructura.php' ) ) {
        wp_enqueue_script( 'echos-srv1-js', $theme_uri . '/assets/js/servicios-1.js', array(), $version, true );
    }
    if ( is_page_template( 'page-templates/template-servicios-iluminacion.php' ) ) {
        wp_enqueue_script( 'echos-srv2-js', $theme_uri . '/assets/js/servicios-2.js', array(), $version, true );
    }
    if ( is_page_template( 'page-templates/template-servicios-stands.php' ) ) {
        wp_enqueue_script( 'echos-srv3-js', $theme_uri . '/assets/js/servicios-3.js', array(), $version, true );
    }
}
add_action( 'wp_enqueue_scripts', 'echos_enqueue_assets' );

/* -------------------------------------------------------
   3. Preconnect para Google Fonts
------------------------------------------------------- */
function echos_resource_hints( $urls, $relation_type ) {
    if ( 'preconnect' === $relation_type ) {
        $urls[] = array(
            'href' => 'https://fonts.googleapis.com',
            'crossorigin' => false,
        );
        $urls[] = array(
            'href' => 'https://fonts.gstatic.com',
            'crossorigin' => 'anonymous',
        );
    }
    return $urls;
}
add_filter( 'wp_resource_hints', 'echos_resource_hints', 10, 2 );

/* -------------------------------------------------------
   4. Helper: URI de assets
------------------------------------------------------- */
function echos_asset( $path ) {
    return get_template_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

/* -------------------------------------------------------
   5. Eliminar cosas innecesarias de WP para un tema estático
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
   6. Walker personalizado para Sidebar Menu
   Agrega botón toggle para sub-menús con ícono de flecha
------------------------------------------------------- */
if ( ! class_exists( 'Echos_Sidebar_Walker' ) ) :

class Echos_Sidebar_Walker extends Walker_Nav_Menu {

    /**
     * Abre un sub-menú (<ul>).
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "\n{$indent}<ul class=\"sub-menu\">\n";
    }

    /**
     * Cierra un sub-menú (</ul>).
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat( "\t", $depth );
        $output .= "{$indent}</ul>\n";
    }

    /**
     * Abre un elemento del menú (<li> + <a>).
     * Si tiene hijos, agrega un botón toggle dentro del <a>.
     */
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        // Clases del <li>
        $classes   = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $has_children = in_array( 'menu-item-has-children', $classes, true );

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

        $id_attr = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
        $id_attr = $id_attr ? ' id="' . esc_attr( $id_attr ) . '"' : '';

        $output .= $indent . '<li' . $id_attr . $class_names . '>';

        // Atributos del <a>
        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
        $atts['href']   = ! empty( $item->url ) ? $item->url : '';

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // Texto del enlace
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        // Botón toggle para sub-menú
        $submenu_toggle = '';
        if ( $has_children ) {
            $submenu_toggle = '<button class="echos-submenu-toggle" type="button" aria-label="' . esc_attr__( 'Expandir sub-menú', 'echos' ) . '">'
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

    /**
     * Cierra un elemento del menú (</li>).
     */
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}

endif; // class_exists
