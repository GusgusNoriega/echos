<?php
/**
 * Service layout: Stands para ferias.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$service = isset( $args['service'] ) && is_array( $args['service'] ) ? $args['service'] : array();
$service_id = isset( $args['service_id'] ) ? absint( $args['service_id'] ) : 0;

echos_service_render_hero( isset( $service['hero'] ) && is_array( $service['hero'] ) ? $service['hero'] : array() );
echos_service_render_description( isset( $service['description'] ) && is_array( $service['description'] ) ? $service['description'] : array() );
echos_service_render_ficha( isset( $service['ficha'] ) && is_array( $service['ficha'] ) ? $service['ficha'] : array() );
echos_service_render_products( isset( $service['products'] ) && is_array( $service['products'] ) ? $service['products'] : array(), $service_id );
echos_service_render_featured( isset( $service['featured'] ) && is_array( $service['featured'] ) ? $service['featured'] : array(), $service_id );
echos_service_render_additional_slider( isset( $service['additional_slider'] ) && is_array( $service['additional_slider'] ) ? $service['additional_slider'] : array() );
echos_service_render_furniture( isset( $service['furniture'] ) && is_array( $service['furniture'] ) ? $service['furniture'] : array() );
echos_service_render_other_services( isset( $service['other_services'] ) && is_array( $service['other_services'] ) ? $service['other_services'] : array(), $service_id );
echos_service_render_final_cta( isset( $service['final_cta'] ) && is_array( $service['final_cta'] ) ? $service['final_cta'] : array() );
