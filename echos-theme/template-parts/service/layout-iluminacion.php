<?php
/**
 * Service layout: Iluminacion.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$service = isset( $args['service'] ) && is_array( $args['service'] ) ? $args['service'] : array();
$service_id = isset( $args['service_id'] ) ? absint( $args['service_id'] ) : 0;

echos_service_render_hero( isset( $service['hero'] ) && is_array( $service['hero'] ) ? $service['hero'] : array() );
echos_service_render_systems_text( isset( $service['systems_text'] ) && is_array( $service['systems_text'] ) ? $service['systems_text'] : array() );
echos_service_render_products( isset( $service['products'] ) && is_array( $service['products'] ) ? $service['products'] : array(), $service_id );
echos_service_render_iluminacion_additional( isset( $service['additional'] ) && is_array( $service['additional'] ) ? $service['additional'] : array() );
echos_service_render_featured( isset( $service['featured'] ) && is_array( $service['featured'] ) ? $service['featured'] : array(), $service_id );
echos_service_render_other_services( isset( $service['other_services'] ) && is_array( $service['other_services'] ) ? $service['other_services'] : array(), $service_id );
echos_service_render_final_cta( isset( $service['final_cta'] ) && is_array( $service['final_cta'] ) ? $service['final_cta'] : array() );
