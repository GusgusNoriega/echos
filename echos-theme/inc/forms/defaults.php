<?php
/**
 * Form settings default values.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns default form + mail settings.
 *
 * @return array
 */
function echos_forms_default_settings() {
	$default_from_email = 'admin@echosperu.com';
	$default_from_name  = 'ECHOS Peru';
	$default_notify_to  = 'gusgusnoriega@gmail.com';

	return array(
		'smtp_enabled'    => true,
		'smtp_host'       => 'mail.echosperu.com',
		'smtp_port'       => 465,
		'smtp_encryption' => 'ssl',
		'smtp_username'   => $default_from_email,
		'smtp_password'   => '',
		'from_email'      => $default_from_email,
		'from_name'       => $default_from_name,
		'notify_to'       => $default_notify_to,
		'google_sheets_enabled'         => false,
		'google_sheets_webhook_url'     => '',
		'google_sheets_spreadsheet_url' => '',
		'google_sheets_sheet_name'      => 'Leads',
		'google_sheets_sheet_name_home_contact'    => '',
		'google_sheets_sheet_name_contact_page'    => '',
		'google_sheets_sheet_name_popup_subscribe' => '',
		'google_sheets_secret'          => '',
		'google_sheets_timeout'         => 15,
		'google_sheets_logging_enabled' => true,
		'google_sheets_log_max_size_kb' => 2048,
		'success_message' => __( 'Gracias, recibimos tus datos. Te contactaremos pronto.', 'echos' ),
		'error_message'   => __( 'No se pudo enviar el formulario. Intenta de nuevo en unos minutos.', 'echos' ),
	);
}
