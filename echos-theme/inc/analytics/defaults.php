<?php
/**
 * Analytics default settings.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns default analytics IDs.
 *
 * @return array
 */
function echos_analytics_default_settings() {
	return array(
		'ga4_measurement_id' => 'G-SJR7QBMVKX',
		'gtm_container_id'   => 'GTM-WLLL93GG',
	);
}

