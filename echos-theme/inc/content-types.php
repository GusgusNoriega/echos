<?php
/**
 * Registro de tipos de contenido y taxonomias.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Construye labels estandares para un post type.
 *
 * @param string $singular Nombre singular.
 * @param string $plural   Nombre plural.
 * @return array<string, string>
 */
function echos_post_type_labels( $singular, $plural ) {
    return array(
        'name'                  => $plural,
        'singular_name'         => $singular,
        'menu_name'             => $plural,
        'name_admin_bar'        => $singular,
        'add_new'               => __( 'Anadir nuevo', 'echos' ),
        'add_new_item'          => sprintf( __( 'Anadir nuevo %s', 'echos' ), $singular ),
        'new_item'              => sprintf( __( 'Nuevo %s', 'echos' ), $singular ),
        'edit_item'             => sprintf( __( 'Editar %s', 'echos' ), $singular ),
        'view_item'             => sprintf( __( 'Ver %s', 'echos' ), $singular ),
        'all_items'             => sprintf( __( 'Todos los %s', 'echos' ), $plural ),
        'search_items'          => sprintf( __( 'Buscar %s', 'echos' ), $plural ),
        'parent_item_colon'     => sprintf( __( '%s superior:', 'echos' ), $singular ),
        'not_found'             => sprintf( __( 'No se encontraron %s.', 'echos' ), strtolower( $plural ) ),
        'not_found_in_trash'    => sprintf( __( 'No se encontraron %s en la papelera.', 'echos' ), strtolower( $plural ) ),
        'featured_image'        => __( 'Imagen destacada', 'echos' ),
        'set_featured_image'    => __( 'Establecer imagen destacada', 'echos' ),
        'remove_featured_image' => __( 'Eliminar imagen destacada', 'echos' ),
        'use_featured_image'    => __( 'Usar como imagen destacada', 'echos' ),
        'archives'              => sprintf( __( 'Archivo de %s', 'echos' ), $plural ),
        'insert_into_item'      => sprintf( __( 'Insertar en %s', 'echos' ), strtolower( $singular ) ),
        'uploaded_to_this_item' => sprintf( __( 'Subido a este %s', 'echos' ), strtolower( $singular ) ),
        'items_list'            => sprintf( __( 'Lista de %s', 'echos' ), strtolower( $plural ) ),
        'items_list_navigation' => sprintf( __( 'Navegacion de lista de %s', 'echos' ), strtolower( $plural ) ),
        'filter_items_list'     => sprintf( __( 'Filtrar lista de %s', 'echos' ), strtolower( $plural ) ),
    );
}

/**
 * Construye labels para taxonomias jerarquicas.
 *
 * @param string $singular Nombre singular.
 * @param string $plural   Nombre plural.
 * @return array<string, string>
 */
function echos_taxonomy_labels( $singular, $plural ) {
    return array(
        'name'              => $plural,
        'singular_name'     => $singular,
        'search_items'      => sprintf( __( 'Buscar %s', 'echos' ), strtolower( $plural ) ),
        'all_items'         => sprintf( __( 'Todas las %s', 'echos' ), strtolower( $plural ) ),
        'parent_item'       => sprintf( __( '%s superior', 'echos' ), $singular ),
        'parent_item_colon' => sprintf( __( '%s superior:', 'echos' ), $singular ),
        'edit_item'         => sprintf( __( 'Editar %s', 'echos' ), $singular ),
        'update_item'       => sprintf( __( 'Actualizar %s', 'echos' ), $singular ),
        'add_new_item'      => sprintf( __( 'Anadir nueva %s', 'echos' ), strtolower( $singular ) ),
        'new_item_name'     => sprintf( __( 'Nombre de nueva %s', 'echos' ), strtolower( $singular ) ),
        'menu_name'         => $plural,
    );
}

/**
 * Registro de CPT del tema.
 *
 * Nota: "producto" se mantiene como contenido propio,
 * sin dependencia de WooCommerce.
 */
function echos_register_content_types() {
    $common_args = array(
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'publicly_queryable'  => true,
        'query_var'           => true,
        'can_export'          => true,
        'show_in_rest'        => true,
        'exclude_from_search' => false,
        'hierarchical'        => false,
        'has_archive'         => false,
        'menu_position'       => 21,
        'supports'            => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'revisions',
            'page-attributes',
        ),
    );

    register_post_type(
        'proyecto',
        array_merge(
            $common_args,
            array(
                'labels'    => echos_post_type_labels( __( 'Proyecto', 'echos' ), __( 'Proyectos', 'echos' ) ),
                'rewrite'   => array(
                    'slug'       => 'proyecto',
                    'with_front' => false,
                ),
                'menu_icon' => 'dashicons-portfolio',
            )
        )
    );

    register_post_type(
        'servicio',
        array_merge(
            $common_args,
            array(
                'labels'    => echos_post_type_labels( __( 'Servicio', 'echos' ), __( 'Servicios', 'echos' ) ),
                'rewrite'   => array(
                    'slug'       => 'servicio',
                    'with_front' => false,
                ),
                'menu_icon' => 'dashicons-hammer',
            )
        )
    );

    register_post_type(
        'producto',
        array_merge(
            $common_args,
            array(
                'labels'    => echos_post_type_labels( __( 'Producto', 'echos' ), __( 'Productos', 'echos' ) ),
                'rewrite'   => array(
                    'slug'       => 'producto',
                    'with_front' => false,
                ),
                'menu_icon' => 'dashicons-screenoptions',
            )
        )
    );
}
add_action( 'init', 'echos_register_content_types' );

/**
 * Registro de taxonomias por tipo de contenido.
 */
function echos_register_content_taxonomies() {
    register_taxonomy(
        'categoria_proyecto',
        array( 'proyecto' ),
        array(
            'labels'            => echos_taxonomy_labels( __( 'Categoria de proyecto', 'echos' ), __( 'Categorias de proyecto', 'echos' ) ),
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => array(
                'slug'       => 'categoria-proyecto',
                'with_front' => false,
            ),
        )
    );

    register_taxonomy(
        'categoria_servicio',
        array( 'servicio' ),
        array(
            'labels'            => echos_taxonomy_labels( __( 'Categoria de servicio', 'echos' ), __( 'Categorias de servicio', 'echos' ) ),
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => array(
                'slug'       => 'categoria-servicio',
                'with_front' => false,
            ),
        )
    );

    register_taxonomy(
        'categoria_producto',
        array( 'producto' ),
        array(
            'labels'            => echos_taxonomy_labels( __( 'Categoria de producto', 'echos' ), __( 'Categorias de producto', 'echos' ) ),
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_rest'      => true,
            'rewrite'           => array(
                'slug'       => 'categoria-producto',
                'with_front' => false,
            ),
        )
    );
}
add_action( 'init', 'echos_register_content_taxonomies' );

/**
 * Regenera reglas de enlaces permanentes al activar el tema.
 */
function echos_flush_rewrite_on_theme_switch() {
    echos_register_content_types();
    echos_register_content_taxonomies();
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'echos_flush_rewrite_on_theme_switch' );

