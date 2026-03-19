<?php
/**
 * Form settings, delivery and storage helpers.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', 'echos_forms_register_entry_post_type' );
add_action( 'wp_ajax_echos_submit_form', 'echos_forms_handle_submit_ajax' );
add_action( 'wp_ajax_nopriv_echos_submit_form', 'echos_forms_handle_submit_ajax' );
add_action( 'phpmailer_init', 'echos_forms_configure_phpmailer' );
add_filter( 'manage_echos_form_entry_posts_columns', 'echos_forms_entry_columns' );
add_action( 'manage_echos_form_entry_posts_custom_column', 'echos_forms_render_entry_column', 10, 2 );
add_action( 'add_meta_boxes_echos_form_entry', 'echos_forms_register_entry_meta_box' );

/**
 * Returns merged form settings.
 *
 * @return array
 */
function echos_forms_get_settings() {
	$defaults = echos_forms_default_settings();
	$saved    = get_option( 'echos_forms_settings', array() );

	if ( ! is_array( $saved ) ) {
		$saved = array();
	}

	$settings = array_merge( $defaults, $saved );

	$settings['smtp_enabled']    = ! empty( $settings['smtp_enabled'] );
	$settings['smtp_host']       = sanitize_text_field( (string) $settings['smtp_host'] );
	$settings['smtp_port']       = echos_forms_normalize_port( $settings['smtp_port'] );
	$settings['smtp_encryption'] = echos_forms_normalize_encryption( $settings['smtp_encryption'] );
	$settings['smtp_username']   = sanitize_text_field( (string) $settings['smtp_username'] );
	$settings['smtp_password']   = is_scalar( $settings['smtp_password'] ) ? trim( (string) $settings['smtp_password'] ) : '';

	$from_email = sanitize_email( (string) $settings['from_email'] );
	if ( ! is_email( $from_email ) ) {
		$from_email = sanitize_email( (string) $defaults['from_email'] );
	}
	$settings['from_email'] = $from_email;

	$from_name = sanitize_text_field( (string) $settings['from_name'] );
	if ( '' === trim( $from_name ) ) {
		$from_name = sanitize_text_field( (string) $defaults['from_name'] );
	}
	$settings['from_name'] = $from_name;

	$emails = echos_forms_parse_emails( $settings['notify_to'] );
	if ( empty( $emails ) ) {
		$emails = echos_forms_parse_emails( $defaults['notify_to'] );
	}
	$settings['notify_to'] = implode( ', ', $emails );

	$settings['google_sheets_enabled'] = ! empty( $settings['google_sheets_enabled'] );
	$settings['google_sheets_webhook_url'] = echos_forms_sanitize_webhook_url( $settings['google_sheets_webhook_url'] );
	$settings['google_sheets_spreadsheet_url'] = echos_forms_sanitize_webhook_url( $settings['google_sheets_spreadsheet_url'] );

	$sheet_name = echos_forms_sanitize_sheet_tab_name( (string) $settings['google_sheets_sheet_name'] );
	if ( '' === trim( $sheet_name ) ) {
		$sheet_name = echos_forms_sanitize_sheet_tab_name( (string) $defaults['google_sheets_sheet_name'] );
	}
	$settings['google_sheets_sheet_name'] = $sheet_name;
	$settings['google_sheets_sheet_name_home_contact'] = echos_forms_sanitize_sheet_tab_name( $settings['google_sheets_sheet_name_home_contact'] );
	$settings['google_sheets_sheet_name_contact_page'] = echos_forms_sanitize_sheet_tab_name( $settings['google_sheets_sheet_name_contact_page'] );
	$settings['google_sheets_sheet_name_popup_subscribe'] = echos_forms_sanitize_sheet_tab_name( $settings['google_sheets_sheet_name_popup_subscribe'] );

	$settings['google_sheets_secret'] = is_scalar( $settings['google_sheets_secret'] )
		? sanitize_text_field( trim( (string) $settings['google_sheets_secret'] ) )
		: '';
	$settings['google_sheets_timeout'] = echos_forms_normalize_http_timeout( $settings['google_sheets_timeout'] );
	$settings['google_sheets_logging_enabled'] = ! empty( $settings['google_sheets_logging_enabled'] );
	$settings['google_sheets_log_max_size_kb'] = echos_forms_normalize_log_size_kb( $settings['google_sheets_log_max_size_kb'] );

	$success_message = sanitize_text_field( (string) $settings['success_message'] );
	$error_message   = sanitize_text_field( (string) $settings['error_message'] );

	if ( '' === trim( $success_message ) ) {
		$success_message = (string) $defaults['success_message'];
	}
	if ( '' === trim( $error_message ) ) {
		$error_message = (string) $defaults['error_message'];
	}

	$settings['success_message'] = $success_message;
	$settings['error_message']   = $error_message;

	return $settings;
}

/**
 * Normalizes SMTP encryption.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function echos_forms_normalize_encryption( $value ) {
	$allowed = array( 'none', 'ssl', 'tls' );
	$key     = sanitize_key( (string) $value );

	if ( in_array( $key, $allowed, true ) ) {
		return $key;
	}

	return 'tls';
}

/**
 * Normalizes SMTP port.
 *
 * @param mixed $value Raw value.
 * @return int
 */
function echos_forms_normalize_port( $value ) {
	$port = (int) $value;
	if ( $port < 1 || $port > 65535 ) {
		return 587;
	}

	return $port;
}

/**
 * Normalizes outbound HTTP timeout.
 *
 * @param mixed $value Raw value.
 * @return int
 */
function echos_forms_normalize_http_timeout( $value ) {
	$timeout = (int) $value;
	if ( $timeout < 3 || $timeout > 60 ) {
		return 15;
	}

	return $timeout;
}

/**
 * Normalizes Google Sheets log max size.
 *
 * @param mixed $value Raw value.
 * @return int
 */
function echos_forms_normalize_log_size_kb( $value ) {
	$size = (int) $value;
	if ( $size < 256 || $size > 20480 ) {
		return 2048;
	}

	return $size;
}

/**
 * Sanitizes webhook/URL config fields.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function echos_forms_sanitize_webhook_url( $value ) {
	$url = is_scalar( $value ) ? trim( (string) $value ) : '';
	if ( '' === $url ) {
		return '';
	}

	$url = esc_url_raw( $url, array( 'http', 'https' ) );
	if ( '' === $url || ! wp_http_validate_url( $url ) ) {
		return '';
	}

	return $url;
}

/**
 * Sanitizes a Google Sheet tab name.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function echos_forms_sanitize_sheet_tab_name( $value ) {
	$name = sanitize_text_field( (string) $value );
	$name = preg_replace( '/[\[\]\*\?\/\\\\:]/', '', $name );
	$name = is_string( $name ) ? trim( $name ) : '';

	if ( '' === $name ) {
		return '';
	}

	if ( strlen( $name ) > 100 ) {
		$name = substr( $name, 0, 100 );
	}

	return $name;
}

/**
 * Resolves target sheet tab name from form source.
 *
 * @param string $source   Form source key.
 * @param array  $settings Form settings.
 * @return string
 */
function echos_forms_get_target_sheet_name( $source, $settings ) {
	$source   = sanitize_key( (string) $source );
	$settings = is_array( $settings ) ? $settings : array();
	$default  = isset( $settings['google_sheets_sheet_name'] ) ? echos_forms_sanitize_sheet_tab_name( $settings['google_sheets_sheet_name'] ) : '';

	if ( '' === $default ) {
		$default = 'Leads';
	}

	$mapping = array(
		'home_contact'    => 'google_sheets_sheet_name_home_contact',
		'contact_page'    => 'google_sheets_sheet_name_contact_page',
		'popup_subscribe' => 'google_sheets_sheet_name_popup_subscribe',
	);

	if ( ! isset( $mapping[ $source ] ) ) {
		return $default;
	}

	$key      = $mapping[ $source ];
	$specific = isset( $settings[ $key ] ) ? echos_forms_sanitize_sheet_tab_name( $settings[ $key ] ) : '';

	return '' !== $specific ? $specific : $default;
}

/**
 * Returns Google Sheets log file path.
 *
 * @param bool $ensure_dir Create directory if missing.
 * @return string
 */
function echos_forms_get_google_sheet_log_file_path( $ensure_dir = false ) {
	$upload_dir = wp_upload_dir();
	$base_dir   = '';

	if ( is_array( $upload_dir ) && empty( $upload_dir['error'] ) && ! empty( $upload_dir['basedir'] ) ) {
		$base_dir = (string) $upload_dir['basedir'];
	}

	if ( '' === trim( $base_dir ) ) {
		$base_dir = WP_CONTENT_DIR . '/uploads';
	}

	$log_dir = trailingslashit( $base_dir ) . 'echos-logs';

	if ( $ensure_dir && ! is_dir( $log_dir ) ) {
		wp_mkdir_p( $log_dir );
	}

	return trailingslashit( $log_dir ) . 'google-sheets.log';
}

/**
 * Returns recent Google Sheets log lines.
 *
 * @param int $line_count Max number of lines.
 * @param int $max_chars  Max chars to load.
 * @return string
 */
function echos_forms_get_google_sheet_logs_tail( $line_count = 200, $max_chars = 120000 ) {
	$line_count = max( 1, (int) $line_count );
	$max_chars  = max( 2000, (int) $max_chars );
	$log_file   = echos_forms_get_google_sheet_log_file_path( false );

	if ( ! file_exists( $log_file ) || ! is_readable( $log_file ) ) {
		return '';
	}

	$content = file_get_contents( $log_file );
	if ( false === $content || '' === $content ) {
		return '';
	}

	if ( strlen( $content ) > $max_chars ) {
		$content = substr( $content, -1 * $max_chars );
	}

	$lines = preg_split( '/\r\n|\r|\n/', $content );
	if ( ! is_array( $lines ) ) {
		return '';
	}

	$lines = array_values(
		array_filter(
			$lines,
			static function ( $line ) {
				return '' !== trim( (string) $line );
			}
		)
	);

	if ( empty( $lines ) ) {
		return '';
	}

	$tail = array_slice( $lines, -1 * $line_count );

	return implode( "\n", $tail );
}

/**
 * Clears Google Sheets log file.
 *
 * @return bool
 */
function echos_forms_clear_google_sheet_log_file() {
	$log_file = echos_forms_get_google_sheet_log_file_path( false );

	if ( ! file_exists( $log_file ) ) {
		return true;
	}

	if ( is_writable( $log_file ) ) {
		return false !== file_put_contents( $log_file, '' );
	}

	return false;
}

/**
 * Writes a JSON line in Google Sheets log.
 *
 * @param string $event    Log event key.
 * @param int    $entry_id Form entry ID.
 * @param array  $context  Context payload.
 * @param array  $settings Settings payload.
 * @return void
 */
function echos_forms_write_google_sheet_log( $event, $entry_id, $context = array(), $settings = array() ) {
	$settings = is_array( $settings ) ? $settings : array();
	if ( empty( $settings ) ) {
		$settings = echos_forms_get_settings();
	}

	if ( empty( $settings['google_sheets_logging_enabled'] ) ) {
		return;
	}

	$log_file = echos_forms_get_google_sheet_log_file_path( true );
	if ( '' === trim( $log_file ) ) {
		return;
	}

	echos_forms_rotate_google_sheet_log_if_needed(
		$log_file,
		isset( $settings['google_sheets_log_max_size_kb'] ) ? (int) $settings['google_sheets_log_max_size_kb'] : 2048
	);

	$event = sanitize_key( (string) $event );
	if ( '' === $event ) {
		$event = 'unknown';
	}

	$payload = array(
		'timestamp' => current_time( 'mysql' ),
		'event'     => $event,
		'entry_id'  => (int) $entry_id,
		'context'   => echos_forms_mask_google_sheet_log_data( $context ),
	);

	$json = wp_json_encode( $payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
	if ( false === $json ) {
		$json = wp_json_encode(
			array(
				'timestamp' => current_time( 'mysql' ),
				'event'     => $event,
				'entry_id'  => (int) $entry_id,
				'context'   => array( 'encode_error' => true ),
			)
		);
	}

	if ( false === $json ) {
		return;
	}

	file_put_contents( $log_file, $json . PHP_EOL, FILE_APPEND | LOCK_EX );
}

/**
 * Rotates Google Sheets log when max size is exceeded.
 *
 * @param string $log_file    Absolute log file path.
 * @param int    $max_size_kb Max size in KB.
 * @return void
 */
function echos_forms_rotate_google_sheet_log_if_needed( $log_file, $max_size_kb ) {
	$log_file    = (string) $log_file;
	$max_size_kb = echos_forms_normalize_log_size_kb( $max_size_kb );

	if ( '' === trim( $log_file ) || ! file_exists( $log_file ) ) {
		return;
	}

	$current_size = filesize( $log_file );
	$max_bytes    = $max_size_kb * 1024;

	if ( false === $current_size || $current_size < $max_bytes ) {
		return;
	}

	$rotated_file = $log_file . '.1';
	if ( file_exists( $rotated_file ) ) {
		@unlink( $rotated_file );
	}

	@rename( $log_file, $rotated_file );
}

/**
 * Masks sensitive fields from Google Sheets debug logs.
 *
 * @param mixed $data Data to scrub.
 * @return mixed
 */
function echos_forms_mask_google_sheet_log_data( $data ) {
	if ( is_array( $data ) ) {
		$masked = array();

		foreach ( $data as $key => $value ) {
			$key_string = is_string( $key ) ? strtolower( $key ) : '';
			$is_secret  = in_array(
				$key_string,
				array(
					'secret',
					'token',
					'password',
					'authorization',
					'x-api-key',
				),
				true
			);

			if ( $is_secret ) {
				$masked[ $key ] = '[REDACTED]';
				continue;
			}

			$masked[ $key ] = echos_forms_mask_google_sheet_log_data( $value );
		}

		return $masked;
	}

	if ( is_object( $data ) ) {
		if ( method_exists( $data, 'getAll' ) ) {
			$all = $data->getAll();
			if ( is_array( $all ) ) {
				return echos_forms_mask_google_sheet_log_data( $all );
			}
		}

		return '[OBJECT]';
	}

	if ( is_bool( $data ) || is_int( $data ) || is_float( $data ) || is_null( $data ) ) {
		return $data;
	}

	if ( is_scalar( $data ) ) {
		$string = (string) $data;
		if ( strlen( $string ) > 4000 ) {
			$string = substr( $string, 0, 4000 ) . '...[TRUNCATED]';
		}

		return $string;
	}

	return '[UNSUPPORTED]';
}

/**
 * Parses Google Sheets webhook HTTP response into normalized data.
 *
 * @param array $response WordPress HTTP response.
 * @return array
 */
function echos_forms_parse_google_sheet_response( $response ) {
	$http_code        = (int) wp_remote_retrieve_response_code( $response );
	$raw_body         = (string) wp_remote_retrieve_body( $response );
	$response_headers = wp_remote_retrieve_headers( $response );
	$content_type     = strtolower( (string) wp_remote_retrieve_header( $response, 'content-type' ) );
	$excerpt          = sanitize_textarea_field( substr( trim( $raw_body ), 0, 400 ) );

	$json             = json_decode( $raw_body, true );
	$json             = is_array( $json ) ? $json : array();
	$is_json_response = false !== strpos( $content_type, 'application/json' );
	$plain_body       = trim( wp_strip_all_tags( $raw_body ) );
	$plain_body_lc    = strtolower( $plain_body );

	$success = $http_code >= 200 && $http_code < 300;

	if ( $is_json_response && empty( $json ) ) {
		$success = false;
	}

	if ( ! $is_json_response ) {
		if ( '' === $plain_body ) {
			$success = false;
		}

		if ( false !== strpos( $plain_body_lc, 'script function not found' ) || false !== strpos( $plain_body_lc, 'exception' ) ) {
			$success = false;
		}
	}

	if ( isset( $json['ok'] ) && false === $json['ok'] ) {
		$success = false;
	}
	if ( isset( $json['success'] ) && false === $json['success'] ) {
		$success = false;
	}

	return array(
		'http_code'        => $http_code,
		'raw_body'         => $raw_body,
		'response_headers' => $response_headers,
		'content_type'     => $content_type,
		'excerpt'          => $excerpt,
		'json'             => $json,
		'is_json_response' => $is_json_response,
		'plain_body'       => $plain_body,
		'plain_body_lc'    => $plain_body_lc,
		'success'          => $success,
	);
}

/**
 * Sends POST to Apps Script and handles Google redirect manually.
 *
 * Apps Script often returns 302 to a script.googleusercontent URL. Some
 * HTTP clients resend POST in redirect chain and Google answers 400.
 * This helper forces: POST (no redirect) + GET to Location.
 *
 * @param string $url          Endpoint URL.
 * @param array  $args         wp_remote_post args.
 * @param int    $entry_id     Entry ID for logs.
 * @param string $form_source  Form source key.
 * @param array  $settings     Form settings.
 * @param string $request_mode Request mode label.
 * @return array|WP_Error
 */
function echos_forms_google_sheet_request_with_redirect_handling( $url, $args, $entry_id, $form_source, $settings, $request_mode ) {
	$url          = is_scalar( $url ) ? (string) $url : '';
	$args         = is_array( $args ) ? $args : array();
	$settings     = is_array( $settings ) ? $settings : array();
	$request_mode = sanitize_key( (string) $request_mode );

	if ( '' === trim( $request_mode ) ) {
		$request_mode = 'json_post';
	}

	$timeout             = isset( $args['timeout'] ) ? echos_forms_normalize_http_timeout( $args['timeout'] ) : 15;
	$args['timeout']     = $timeout;
	$args['redirection'] = 0;

	$response = wp_remote_post( $url, $args );
	if ( is_wp_error( $response ) ) {
		return $response;
	}

	$status_code = (int) wp_remote_retrieve_response_code( $response );
	$location    = (string) wp_remote_retrieve_header( $response, 'location' );

	$is_redirect = in_array( $status_code, array( 301, 302, 303, 307, 308 ), true ) && '' !== trim( $location );
	if ( ! $is_redirect ) {
		return array(
			'response'      => $response,
			'response_mode' => $request_mode,
		);
	}

	$redirect_url = esc_url_raw( $location, array( 'https', 'http' ) );
	if ( '' === trim( $redirect_url ) ) {
		return array(
			'response'      => $response,
			'response_mode' => $request_mode,
		);
	}

	echos_forms_write_google_sheet_log(
		'redirect_received',
		$entry_id,
		array(
			'form_source'   => $form_source,
			'request_mode'  => $request_mode,
			'status_code'   => $status_code,
			'redirect_to'   => $redirect_url,
		),
		$settings
	);

	$follow_response = wp_remote_get(
		$redirect_url,
		array(
			'timeout'     => $timeout,
			'redirection' => 3,
			'headers'     => array(
				'Accept' => 'application/json',
			),
		)
	);

	if ( is_wp_error( $follow_response ) ) {
		return $follow_response;
	}

	echos_forms_write_google_sheet_log(
		'redirect_follow_get',
		$entry_id,
		array(
			'form_source'   => $form_source,
			'request_mode'  => $request_mode,
			'status_code'   => (int) wp_remote_retrieve_response_code( $follow_response ),
			'redirect_to'   => $redirect_url,
		),
		$settings
	);

	return array(
		'response'      => $follow_response,
		'response_mode' => $request_mode . '_redirect_get',
	);
}

/**
 * Frontend config for form scripts.
 *
 * @return array
 */
function echos_forms_get_frontend_config() {
	$settings = echos_forms_get_settings();

	return array(
		'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'echos_forms_submit' ),
		'messages' => array(
			'success'    => (string) $settings['success_message'],
			'error'      => (string) $settings['error_message'],
			'validation' => __( 'Completa los campos obligatorios antes de enviar.', 'echos' ),
		),
	);
}

/**
 * Converts a text list of emails to a valid unique email array.
 *
 * @param mixed $raw Raw value.
 * @return array
 */
function echos_forms_parse_emails( $raw ) {
	$emails = array();

	if ( ! is_scalar( $raw ) ) {
		return $emails;
	}

	$chunks = preg_split( '/[\s,;]+/', (string) $raw );
	if ( ! is_array( $chunks ) ) {
		return $emails;
	}

	foreach ( $chunks as $chunk ) {
		$email = sanitize_email( trim( (string) $chunk ) );
		if ( ! is_email( $email ) ) {
			continue;
		}

		$emails[] = strtolower( $email );
	}

	return array_values( array_unique( $emails ) );
}

/**
 * Returns source label.
 *
 * @param string $source Source key.
 * @return string
 */
function echos_forms_source_label( $source ) {
	$labels = array(
		'home_contact'    => __( 'Contacto (Inicio)', 'echos' ),
		'contact_page'    => __( 'Contacto (Pagina)', 'echos' ),
		'popup_subscribe' => __( 'Suscripcion popup', 'echos' ),
		'generic'         => __( 'Formulario web', 'echos' ),
	);

	$key = sanitize_key( (string) $source );

	return isset( $labels[ $key ] ) ? $labels[ $key ] : $labels['generic'];
}

/**
 * Returns Google Sheets sync status label.
 *
 * @param string $status Status key.
 * @return string
 */
function echos_forms_sheet_status_label( $status ) {
	$labels = array(
		'pending'      => __( 'Pendiente', 'echos' ),
		'sent'         => __( 'Enviado', 'echos' ),
		'error'        => __( 'Error', 'echos' ),
		'disabled'     => __( 'Desactivado', 'echos' ),
		'misconfigured'=> __( 'Sin configurar', 'echos' ),
	);

	$key = sanitize_key( (string) $status );

	return isset( $labels[ $key ] ) ? $labels[ $key ] : $labels['pending'];
}

/**
 * Handles AJAX form submission.
 *
 * @return void
 */
function echos_forms_handle_submit_ajax() {
	$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'echos_forms_submit' ) ) {
		wp_send_json_error(
			array(
				'message' => __( 'Sesion invalida. Recarga la pagina e intenta nuevamente.', 'echos' ),
			),
			403
		);
	}

	$submission = echos_forms_collect_submission_from_request();
	$errors     = echos_forms_validate_submission( $submission );

	if ( ! empty( $errors ) ) {
		wp_send_json_error(
			array(
				'message' => __( 'Revisa los campos obligatorios e intenta de nuevo.', 'echos' ),
				'fields'  => $errors,
			),
			422
		);
	}

	$entry_id = echos_forms_store_submission( $submission );
	if ( is_wp_error( $entry_id ) ) {
		wp_send_json_error(
			array(
				'message' => __( 'No pudimos guardar tu solicitud. Intenta nuevamente.', 'echos' ),
			),
			500
		);
	}

	$mail_sent = echos_forms_send_notification_email( $submission );
	update_post_meta( $entry_id, '_echos_form_mail_sent', $mail_sent ? '1' : '0' );
	$sheet_result = echos_forms_sync_submission_to_google_sheets( (int) $entry_id, $submission );

	$settings = echos_forms_get_settings();

	if ( $mail_sent ) {
		wp_send_json_success(
			array(
				'message'   => (string) $settings['success_message'],
				'entry_id'  => (int) $entry_id,
				'mail_sent' => true,
				'sheet_synced' => ! empty( $sheet_result['sent'] ),
				'sheet_status' => isset( $sheet_result['status'] ) ? (string) $sheet_result['status'] : '',
			)
		);
	}

	wp_send_json_success(
		array(
			'message'   => __( 'Recibimos tus datos y ya quedaron guardados. Revisa la configuracion SMTP para habilitar la notificacion por correo.', 'echos' ),
			'entry_id'  => (int) $entry_id,
			'mail_sent' => false,
			'sheet_synced' => ! empty( $sheet_result['sent'] ),
			'sheet_status' => isset( $sheet_result['status'] ) ? (string) $sheet_result['status'] : '',
		)
	);
}

/**
 * Collects and sanitizes submission payload.
 *
 * @return array
 */
function echos_forms_collect_submission_from_request() {
	$post = wp_unslash( $_POST );
	$post = is_array( $post ) ? $post : array();

	$allowed_sources = array( 'home_contact', 'contact_page', 'popup_subscribe' );
	$form_source     = sanitize_key( (string) ( $post['form_source'] ?? '' ) );

	if ( ! in_array( $form_source, $allowed_sources, true ) ) {
		$form_source = 'generic';
	}

	$page_url   = isset( $post['page_url'] ) ? esc_url_raw( (string) $post['page_url'] ) : '';
	$page_title = isset( $post['page_title'] ) ? sanitize_text_field( (string) $post['page_title'] ) : '';

	return array(
		'form_source' => $form_source,
		'nombre'      => sanitize_text_field( (string) ( $post['nombre'] ?? '' ) ),
		'empresa'     => sanitize_text_field( (string) ( $post['empresa'] ?? '' ) ),
		'email'       => sanitize_email( (string) ( $post['email'] ?? '' ) ),
		'telefono'    => sanitize_text_field( (string) ( $post['telefono'] ?? '' ) ),
		'detalle'     => sanitize_textarea_field( (string) ( $post['detalle'] ?? '' ) ),
		'servicio'    => sanitize_text_field( (string) ( $post['servicio'] ?? '' ) ),
		'page_url'    => $page_url,
		'page_title'  => $page_title,
		'ip'          => echos_forms_get_request_ip(),
		'user_agent'  => echos_forms_get_request_user_agent(),
		'extra'       => echos_forms_collect_extra_fields( $post ),
	);
}

/**
 * Collects non-reserved fields for storage.
 *
 * @param array $post Raw POST array.
 * @return array
 */
function echos_forms_collect_extra_fields( $post ) {
	$reserved = array(
		'action',
		'nonce',
		'form_source',
		'nombre',
		'empresa',
		'email',
		'telefono',
		'detalle',
		'servicio',
		'page_url',
		'page_title',
	);

	$extra = array();

	foreach ( $post as $key => $value ) {
		$field_key = sanitize_key( (string) $key );
		if ( '' === $field_key || in_array( $field_key, $reserved, true ) ) {
			continue;
		}

		if ( is_array( $value ) ) {
			$json = wp_json_encode( $value );
			if ( false === $json ) {
				continue;
			}
			$extra[ $field_key ] = $json;
			continue;
		}

		if ( ! is_scalar( $value ) ) {
			continue;
		}

		$extra[ $field_key ] = sanitize_text_field( (string) $value );
	}

	return $extra;
}

/**
 * Validates submission fields.
 *
 * @param array $submission Submission payload.
 * @return array
 */
function echos_forms_validate_submission( $submission ) {
	$errors = array();

	$form_source = isset( $submission['form_source'] ) ? (string) $submission['form_source'] : 'generic';

	if ( 'popup_subscribe' !== $form_source ) {
		if ( '' === trim( (string) $submission['nombre'] ) ) {
			$errors['nombre'] = __( 'El nombre es obligatorio.', 'echos' );
		}
	}

	if ( '' === trim( (string) $submission['empresa'] ) ) {
		$errors['empresa'] = __( 'La empresa es obligatoria.', 'echos' );
	}

	if ( '' === trim( (string) $submission['email'] ) ) {
		$errors['email'] = __( 'El correo es obligatorio.', 'echos' );
	} elseif ( ! is_email( $submission['email'] ) ) {
		$errors['email'] = __( 'El correo no es valido.', 'echos' );
	}

	return $errors;
}

/**
 * Stores submission in internal CPT.
 *
 * @param array $submission Submission payload.
 * @return int|WP_Error
 */
function echos_forms_store_submission( $submission ) {
	$name_or_company = '';
	if ( '' !== trim( (string) $submission['nombre'] ) ) {
		$name_or_company = (string) $submission['nombre'];
	} elseif ( '' !== trim( (string) $submission['empresa'] ) ) {
		$name_or_company = (string) $submission['empresa'];
	}

	if ( '' === $name_or_company ) {
		$name_or_company = __( 'Sin nombre', 'echos' );
	}

	$title = sprintf(
		'%1$s - %2$s - %3$s',
		echos_forms_source_label( (string) $submission['form_source'] ),
		$name_or_company,
		wp_date( 'Y-m-d H:i', current_time( 'timestamp' ) )
	);

	$post_id = wp_insert_post(
		array(
			'post_type'   => 'echos_form_entry',
			'post_status' => 'publish',
			'post_title'  => $title,
		),
		true
	);

	if ( is_wp_error( $post_id ) ) {
		return $post_id;
	}

	update_post_meta( $post_id, '_echos_form_source', (string) $submission['form_source'] );
	update_post_meta( $post_id, '_echos_form_name', (string) $submission['nombre'] );
	update_post_meta( $post_id, '_echos_form_company', (string) $submission['empresa'] );
	update_post_meta( $post_id, '_echos_form_email', (string) $submission['email'] );
	update_post_meta( $post_id, '_echos_form_phone', (string) $submission['telefono'] );
	update_post_meta( $post_id, '_echos_form_detail', (string) $submission['detalle'] );
	update_post_meta( $post_id, '_echos_form_service', (string) $submission['servicio'] );
	update_post_meta( $post_id, '_echos_form_page_url', (string) $submission['page_url'] );
	update_post_meta( $post_id, '_echos_form_page_title', (string) $submission['page_title'] );
	update_post_meta( $post_id, '_echos_form_ip', (string) $submission['ip'] );
	update_post_meta( $post_id, '_echos_form_user_agent', (string) $submission['user_agent'] );
	update_post_meta( $post_id, '_echos_form_submitted_at', current_time( 'mysql' ) );
	update_post_meta( $post_id, '_echos_form_mail_sent', '0' );
	update_post_meta( $post_id, '_echos_form_sheet_status', 'pending' );
	update_post_meta( $post_id, '_echos_form_sheet_error', '' );
	update_post_meta( $post_id, '_echos_form_sheet_synced_at', '' );
	update_post_meta( $post_id, '_echos_form_sheet_http_code', '' );
	update_post_meta( $post_id, '_echos_form_sheet_response_excerpt', '' );

	if ( ! empty( $submission['extra'] ) ) {
		update_post_meta( $post_id, '_echos_form_extra', wp_json_encode( $submission['extra'] ) );
	}

	return (int) $post_id;
}

/**
 * Sends submission payload to Google Sheets webhook.
 *
 * @param int   $entry_id    Saved entry ID.
 * @param array $submission  Submission payload.
 * @return array
 */
function echos_forms_sync_submission_to_google_sheets( $entry_id, $submission ) {
	$entry_id  = (int) $entry_id;
	$settings  = echos_forms_get_settings();
	$webhook   = isset( $settings['google_sheets_webhook_url'] ) ? (string) $settings['google_sheets_webhook_url'] : '';
	$timeout   = isset( $settings['google_sheets_timeout'] ) ? (int) $settings['google_sheets_timeout'] : 15;
	$source    = isset( $submission['form_source'] ) ? sanitize_key( (string) $submission['form_source'] ) : 'generic';
	$sheet_tab = echos_forms_get_target_sheet_name( $source, $settings );

	echos_forms_write_google_sheet_log(
		'sync_start',
		$entry_id,
		array(
			'form_source' => $source,
			'sheet_name'  => $sheet_tab,
			'webhook_url' => $webhook,
		),
		$settings
	);

	if ( empty( $settings['google_sheets_enabled'] ) ) {
		echos_forms_update_sheet_sync_meta( $entry_id, 'disabled', '', 0, '' );
		echos_forms_write_google_sheet_log(
			'sync_skipped_disabled',
			$entry_id,
			array(
				'form_source' => $source,
			),
			$settings
		);
		return array(
			'sent'   => false,
			'status' => 'disabled',
			'error'  => '',
		);
	}

	if ( '' === trim( $webhook ) ) {
		$error = __( 'Google Sheets esta activado pero falta URL del Web App.', 'echos' );
		echos_forms_update_sheet_sync_meta( $entry_id, 'misconfigured', $error, 0, '' );
		echos_forms_write_google_sheet_log(
			'sync_skipped_misconfigured',
			$entry_id,
			array(
				'form_source' => $source,
				'error'       => $error,
			),
			$settings
		);
		return array(
			'sent'   => false,
			'status' => 'misconfigured',
			'error'  => $error,
		);
	}

	$payload = echos_forms_build_google_sheets_payload( $entry_id, $submission, $settings );
	$body    = wp_json_encode( $payload );
	if ( false === $body ) {
		$error = __( 'No se pudo serializar el payload para Google Sheets.', 'echos' );
		echos_forms_update_sheet_sync_meta( $entry_id, 'error', $error, 0, '' );
		echos_forms_write_google_sheet_log(
			'sync_payload_encode_error',
			$entry_id,
			array(
				'form_source' => $source,
				'error'       => $error,
				'payload'     => $payload,
			),
			$settings
		);
		return array(
			'sent'   => false,
			'status' => 'error',
			'error'  => $error,
		);
	}

	$payload_for_log = $payload;
	if ( isset( $payload_for_log['secret'] ) ) {
		$payload_for_log['secret'] = '[REDACTED]';
	}
	$payload_json_for_log = wp_json_encode( $payload_for_log, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
	if ( false === $payload_json_for_log ) {
		$payload_json_for_log = '[json_encode_failed]';
	}

	echos_forms_write_google_sheet_log(
		'request_sent',
		$entry_id,
		array(
			'form_source'  => $source,
			'sheet_name'   => $sheet_tab,
			'url'          => $webhook,
			'timeout'      => echos_forms_normalize_http_timeout( $timeout ),
			'method'       => 'POST',
			'content_type' => 'application/json; charset=UTF-8',
			'payload'      => $payload_for_log,
			'payload_json' => $payload_json_for_log,
		),
		$settings
	);

	$response_result = echos_forms_google_sheet_request_with_redirect_handling(
		$webhook,
		array(
			'timeout' => echos_forms_normalize_http_timeout( $timeout ),
			'headers' => array(
				'Content-Type' => 'application/json; charset=UTF-8',
				'Accept'       => 'application/json',
			),
			'body'    => $body,
		),
		$entry_id,
		$source,
		$settings,
		'json_post'
	);

	if ( is_wp_error( $response_result ) ) {
		$error = $response_result->get_error_message();
		echos_forms_update_sheet_sync_meta( $entry_id, 'error', $error, 0, '' );
		echos_forms_write_google_sheet_log(
			'request_error',
			$entry_id,
			array(
				'form_source' => $source,
				'error'       => $error,
				'error_code'  => $response_result->get_error_code(),
			),
			$settings
		);
		return array(
			'sent'   => false,
			'status' => 'error',
			'error'  => $error,
		);
	}

	$response      = isset( $response_result['response'] ) ? $response_result['response'] : array();
	$response_mode = isset( $response_result['response_mode'] ) ? (string) $response_result['response_mode'] : 'json_post';

	$parsed           = echos_forms_parse_google_sheet_response( $response );
	$http_code        = (int) $parsed['http_code'];
	$raw_body         = (string) $parsed['raw_body'];
	$response_headers = $parsed['response_headers'];
	$content_type     = (string) $parsed['content_type'];
	$excerpt          = (string) $parsed['excerpt'];
	$json             = isset( $parsed['json'] ) && is_array( $parsed['json'] ) ? $parsed['json'] : array();
	$is_json_response = ! empty( $parsed['is_json_response'] );
	$plain_body       = (string) $parsed['plain_body'];
	$plain_body_lc    = (string) $parsed['plain_body_lc'];
	$success          = ! empty( $parsed['success'] );
	echos_forms_write_google_sheet_log(
		'response_received',
		$entry_id,
		array(
			'form_source'       => $source,
			'response_mode'     => $response_mode,
			'http_code'         => $http_code,
			'content_type'      => $content_type,
			'response_headers'  => $response_headers,
			'response_body'     => $raw_body,
			'response_decoded'  => $json,
			'considered_success'=> $success,
		),
		$settings
	);

	if ( ! $success && 400 === $http_code && false !== strpos( $content_type, 'text/html' ) ) {
		$fallback_request_body = array(
			'payload'     => $body,
			'entry_id'    => (string) $entry_id,
			'sheet_name'  => $sheet_tab,
			'form_source' => $source,
		);

		if ( isset( $payload['secret'] ) ) {
			$fallback_request_body['secret'] = (string) $payload['secret'];
		}

		$fallback_log_body = $fallback_request_body;
		$fallback_log_body['payload'] = $payload_json_for_log;
		if ( isset( $fallback_log_body['secret'] ) ) {
			$fallback_log_body['secret'] = '[REDACTED]';
		}

		echos_forms_write_google_sheet_log(
			'request_retry_form_urlencoded',
			$entry_id,
			array(
				'form_source' => $source,
				'url'         => $webhook,
				'body'        => $fallback_log_body,
			),
			$settings
		);

		$fallback_response_result = echos_forms_google_sheet_request_with_redirect_handling(
			$webhook,
			array(
				'timeout' => echos_forms_normalize_http_timeout( $timeout ),
				'headers' => array(
					'Accept' => 'application/json',
				),
				'body'    => $fallback_request_body,
			),
			$entry_id,
			$source,
			$settings,
			'form_urlencoded_retry'
		);

		if ( is_wp_error( $fallback_response_result ) ) {
			echos_forms_write_google_sheet_log(
				'request_retry_error',
				$entry_id,
				array(
					'form_source' => $source,
					'error'       => $fallback_response_result->get_error_message(),
					'error_code'  => $fallback_response_result->get_error_code(),
				),
				$settings
			);
		} else {
			$response      = isset( $fallback_response_result['response'] ) ? $fallback_response_result['response'] : array();
			$response_mode = isset( $fallback_response_result['response_mode'] ) ? (string) $fallback_response_result['response_mode'] : 'form_urlencoded_retry';
			$parsed           = echos_forms_parse_google_sheet_response( $response );
			$http_code        = (int) $parsed['http_code'];
			$raw_body         = (string) $parsed['raw_body'];
			$response_headers = $parsed['response_headers'];
			$content_type     = (string) $parsed['content_type'];
			$excerpt          = (string) $parsed['excerpt'];
			$json             = isset( $parsed['json'] ) && is_array( $parsed['json'] ) ? $parsed['json'] : array();
			$is_json_response = ! empty( $parsed['is_json_response'] );
			$plain_body       = (string) $parsed['plain_body'];
			$plain_body_lc    = (string) $parsed['plain_body_lc'];
			$success          = ! empty( $parsed['success'] );

			echos_forms_write_google_sheet_log(
				'response_received_retry',
				$entry_id,
				array(
					'form_source'       => $source,
					'response_mode'     => $response_mode,
					'http_code'         => $http_code,
					'content_type'      => $content_type,
					'response_headers'  => $response_headers,
					'response_body'     => $raw_body,
					'response_decoded'  => $json,
					'considered_success'=> $success,
				),
				$settings
			);
		}
	}

	if ( $success ) {
		echos_forms_update_sheet_sync_meta( $entry_id, 'sent', '', $http_code, $excerpt );
		echos_forms_write_google_sheet_log(
			'sync_success',
			$entry_id,
			array(
				'form_source'   => $source,
				'http_code'     => $http_code,
				'response_mode' => $response_mode,
			),
			$settings
		);
		return array(
			'sent'   => true,
			'status' => 'sent',
			'error'  => '',
		);
	}

	$error = '';
	if ( isset( $json['error'] ) && is_scalar( $json['error'] ) ) {
		$error = sanitize_text_field( (string) $json['error'] );
	} elseif ( isset( $json['message'] ) && is_scalar( $json['message'] ) ) {
		$error = sanitize_text_field( (string) $json['message'] );
	}

	if ( '' === trim( $error ) && false !== strpos( $plain_body_lc, 'script function not found: dopost' ) ) {
		$error = __( 'Google Apps Script respondio: Script function not found: doPost. Debes publicar una version que incluya function doPost(e).', 'echos' );
	}

	if ( '' === trim( $error ) && 400 === $http_code && false !== strpos( $plain_body_lc, 'malformed or illegal request' ) ) {
		$error = __( 'Google devolvio HTTP 400 (malformed request). Se recomienda revisar deployment /exec, permisos del Web App y logs de reintento form-url-encoded.', 'echos' );
	}

	if ( '' === trim( $error ) && ! empty( $plain_body ) && ! $is_json_response ) {
		$error = sanitize_text_field( substr( $plain_body, 0, 180 ) );
	}

	if ( '' === trim( $error ) ) {
		if ( 401 === $http_code ) {
			$error = __( 'HTTP 401 en Google Sheets. Usa la URL /exec del Web App y configura acceso publico (Anyone).', 'echos' );
		} elseif ( 403 === $http_code ) {
			$error = __( 'HTTP 403 en Google Sheets. Verifica permisos de deployment del Web App.', 'echos' );
		} else {
			$error = sprintf(
				/* translators: %d is HTTP status code returned by webhook. */
				__( 'Respuesta no valida de Google Sheets (HTTP %d).', 'echos' ),
				$http_code
			);
		}
	}

	echos_forms_update_sheet_sync_meta( $entry_id, 'error', $error, $http_code, $excerpt );
	echos_forms_write_google_sheet_log(
		'sync_error',
		$entry_id,
		array(
			'form_source'   => $source,
			'http_code'     => $http_code,
			'response_mode' => $response_mode,
			'error'         => $error,
		),
		$settings
	);

	return array(
		'sent'   => false,
		'status' => 'error',
		'error'  => $error,
	);
}

/**
 * Builds normalized payload for Google Sheets webhook.
 *
 * @param int   $entry_id   Saved entry ID.
 * @param array $submission Submission payload.
 * @param array $settings   Form settings.
 * @return array
 */
function echos_forms_build_google_sheets_payload( $entry_id, $submission, $settings ) {
	$entry_id     = (int) $entry_id;
	$submitted_at = (string) get_post_meta( $entry_id, '_echos_form_submitted_at', true );
	$form_source  = isset( $submission['form_source'] ) ? (string) $submission['form_source'] : 'generic';

	if ( '' === trim( $submitted_at ) ) {
		$submitted_at = current_time( 'mysql' );
	}

	$extra      = isset( $submission['extra'] ) && is_array( $submission['extra'] ) ? $submission['extra'] : array();
	$extra_json = wp_json_encode( $extra );
	$extra_json = false === $extra_json ? '' : $extra_json;

	$payload = array(
		'event'            => 'echos_form_submission',
		'entry_id'         => $entry_id,
		'submitted_at'     => $submitted_at,
		'submitted_at_iso' => wp_date( 'c', current_time( 'timestamp' ) ),
		'sheet_name'       => echos_forms_get_target_sheet_name( $form_source, $settings ),
		'secret'           => isset( $settings['google_sheets_secret'] ) ? (string) $settings['google_sheets_secret'] : '',
		'site'             => array(
			'name' => wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ),
			'url'  => home_url( '/' ),
		),
		'form'             => array(
			'source_key'   => $form_source,
			'source_label' => echos_forms_source_label( $form_source ),
		),
		'contact'          => array(
			'nombre'   => isset( $submission['nombre'] ) ? (string) $submission['nombre'] : '',
			'empresa'  => isset( $submission['empresa'] ) ? (string) $submission['empresa'] : '',
			'email'    => isset( $submission['email'] ) ? (string) $submission['email'] : '',
			'telefono' => isset( $submission['telefono'] ) ? (string) $submission['telefono'] : '',
			'detalle'  => isset( $submission['detalle'] ) ? (string) $submission['detalle'] : '',
			'servicio' => isset( $submission['servicio'] ) ? (string) $submission['servicio'] : '',
		),
		'context'          => array(
			'page_title' => isset( $submission['page_title'] ) ? (string) $submission['page_title'] : '',
			'page_url'   => isset( $submission['page_url'] ) ? (string) $submission['page_url'] : '',
			'ip'         => isset( $submission['ip'] ) ? (string) $submission['ip'] : '',
			'user_agent' => isset( $submission['user_agent'] ) ? (string) $submission['user_agent'] : '',
		),
		'extra'            => $extra,
		'row'              => array(
			'entry_id'     => $entry_id,
			'submitted_at' => $submitted_at,
			'source_key'   => $form_source,
			'source_label' => echos_forms_source_label( $form_source ),
			'service'      => isset( $submission['servicio'] ) ? (string) $submission['servicio'] : '',
			'name'         => isset( $submission['nombre'] ) ? (string) $submission['nombre'] : '',
			'company'      => isset( $submission['empresa'] ) ? (string) $submission['empresa'] : '',
			'email'        => isset( $submission['email'] ) ? (string) $submission['email'] : '',
			'phone'        => isset( $submission['telefono'] ) ? (string) $submission['telefono'] : '',
			'detail'       => isset( $submission['detalle'] ) ? (string) $submission['detalle'] : '',
			'page_title'   => isset( $submission['page_title'] ) ? (string) $submission['page_title'] : '',
			'page_url'     => isset( $submission['page_url'] ) ? (string) $submission['page_url'] : '',
			'ip'           => isset( $submission['ip'] ) ? (string) $submission['ip'] : '',
			'user_agent'   => isset( $submission['user_agent'] ) ? (string) $submission['user_agent'] : '',
			'extra_json'   => $extra_json,
		),
	);

	if ( '' === trim( (string) $payload['secret'] ) ) {
		unset( $payload['secret'] );
	}

	return $payload;
}

/**
 * Persists Google Sheets sync status in entry meta.
 *
 * @param int    $entry_id          Entry ID.
 * @param string $status            Sync status.
 * @param string $error             Error message.
 * @param int    $http_code         HTTP response code.
 * @param string $response_excerpt  Truncated body response.
 * @return void
 */
function echos_forms_update_sheet_sync_meta( $entry_id, $status, $error, $http_code, $response_excerpt ) {
	$entry_id = (int) $entry_id;
	$status   = sanitize_key( (string) $status );

	$allowed_statuses = array( 'pending', 'sent', 'error', 'disabled', 'misconfigured' );
	if ( ! in_array( $status, $allowed_statuses, true ) ) {
		$status = 'error';
	}

	$error            = sanitize_text_field( substr( (string) $error, 0, 300 ) );
	$http_code        = (int) $http_code;
	$response_excerpt = sanitize_textarea_field( substr( (string) $response_excerpt, 0, 500 ) );
	$synced_at        = 'sent' === $status ? current_time( 'mysql' ) : '';

	update_post_meta( $entry_id, '_echos_form_sheet_status', $status );
	update_post_meta( $entry_id, '_echos_form_sheet_error', $error );
	update_post_meta( $entry_id, '_echos_form_sheet_synced_at', $synced_at );
	update_post_meta( $entry_id, '_echos_form_sheet_http_code', (string) $http_code );
	update_post_meta( $entry_id, '_echos_form_sheet_response_excerpt', $response_excerpt );
}

/**
 * Sends notification email for submission.
 *
 * @param array $submission Submission payload.
 * @return bool
 */
function echos_forms_send_notification_email( $submission ) {
	$settings   = echos_forms_get_settings();
	$recipients = echos_forms_parse_emails( $settings['notify_to'] );

	if ( empty( $recipients ) ) {
		$fallback = sanitize_email( (string) get_option( 'admin_email' ) );
		if ( is_email( $fallback ) ) {
			$recipients[] = $fallback;
		}
	}

	if ( empty( $recipients ) ) {
		return false;
	}

	$subject = sprintf(
		'[ECHOS] %s',
		echos_forms_source_label( (string) $submission['form_source'] )
	);

	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
	);

	if ( '' !== trim( (string) $submission['email'] ) && is_email( $submission['email'] ) ) {
		$headers[] = 'Reply-To: ' . sanitize_email( (string) $submission['email'] );
	}

	$message = echos_forms_build_email_body( $submission );
	$sent    = (bool) wp_mail(
		$recipients,
		$subject,
		$message,
		$headers
	);

	if ( $sent ) {
		return true;
	}

	// Fallback retry with minimal headers in case the mail server rejects Reply-To.
	return (bool) wp_mail(
		$recipients,
		$subject,
		$message,
		array( 'Content-Type: text/plain; charset=UTF-8' )
	);
}

/**
 * Builds plain text email body.
 *
 * @param array $submission Submission payload.
 * @return string
 */
function echos_forms_build_email_body( $submission ) {
	$lines   = array();
	$lines[] = __( 'Nuevo envio de formulario en ECHOS', 'echos' );
	$lines[] = '';
	$lines[] = __( 'Formulario:', 'echos' ) . ' ' . echos_forms_source_label( (string) $submission['form_source'] );
	$lines[] = __( 'Servicio interesado:', 'echos' ) . ' ' . ( '' !== trim( (string) $submission['servicio'] ) ? (string) $submission['servicio'] : __( 'No especificado', 'echos' ) );
	$lines[] = __( 'Nombre:', 'echos' ) . ' ' . (string) $submission['nombre'];
	$lines[] = __( 'Empresa:', 'echos' ) . ' ' . (string) $submission['empresa'];
	$lines[] = __( 'Email:', 'echos' ) . ' ' . (string) $submission['email'];
	$lines[] = __( 'Telefono:', 'echos' ) . ' ' . (string) $submission['telefono'];
	$lines[] = __( 'Detalle:', 'echos' ) . ' ' . (string) $submission['detalle'];
	$lines[] = __( 'Pagina:', 'echos' ) . ' ' . (string) $submission['page_title'];
	$lines[] = __( 'URL:', 'echos' ) . ' ' . (string) $submission['page_url'];
	$lines[] = __( 'IP:', 'echos' ) . ' ' . (string) $submission['ip'];
	$lines[] = __( 'User-Agent:', 'echos' ) . ' ' . (string) $submission['user_agent'];
	$lines[] = __( 'Fecha:', 'echos' ) . ' ' . wp_date( 'Y-m-d H:i:s', current_time( 'timestamp' ) );

	if ( ! empty( $submission['extra'] ) && is_array( $submission['extra'] ) ) {
		$lines[] = '';
		$lines[] = __( 'Campos adicionales:', 'echos' );

		foreach ( $submission['extra'] as $key => $value ) {
			$lines[] = '- ' . sanitize_text_field( (string) $key ) . ': ' . sanitize_text_field( (string) $value );
		}
	}

	return implode( "\n", $lines );
}

/**
 * Applies SMTP settings to PHPMailer.
 *
 * @param PHPMailer\PHPMailer\PHPMailer $phpmailer PHPMailer instance.
 * @return void
 */
function echos_forms_configure_phpmailer( $phpmailer ) {
	$settings = echos_forms_get_settings();

	if ( empty( $settings['smtp_enabled'] ) ) {
		return;
	}

	$host = trim( (string) $settings['smtp_host'] );
	if ( '' === $host ) {
		return;
	}

	$phpmailer->isSMTP();
	$phpmailer->Host = $host;
	$phpmailer->Port = (int) echos_forms_normalize_port( $settings['smtp_port'] );

	$username             = trim( (string) $settings['smtp_username'] );
	$password             = (string) $settings['smtp_password'];
	$phpmailer->SMTPAuth  = '' !== $username;
	$phpmailer->Username  = $username;
	$phpmailer->Password  = $password;
	$phpmailer->Timeout   = 20;
	$phpmailer->SMTPDebug = 0;

	$encryption = echos_forms_normalize_encryption( $settings['smtp_encryption'] );
	if ( in_array( $encryption, array( 'ssl', 'tls' ), true ) ) {
		$phpmailer->SMTPSecure = $encryption;
	} else {
		$phpmailer->SMTPSecure = '';
	}

	if ( '' !== trim( (string) $settings['from_email'] ) && is_email( $settings['from_email'] ) ) {
		$from_name = trim( (string) $settings['from_name'] );
		if ( '' === $from_name ) {
			$from_name = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
		}
		$phpmailer->setFrom( $settings['from_email'], $from_name, false );
	}
}

/**
 * Returns request IP.
 *
 * @return string
 */
function echos_forms_get_request_ip() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	return substr( $ip, 0, 64 );
}

/**
 * Returns request user-agent.
 *
 * @return string
 */
function echos_forms_get_request_user_agent() {
	$agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
	return substr( $agent, 0, 500 );
}

/**
 * Registers internal CPT for form entries.
 *
 * @return void
 */
function echos_forms_register_entry_post_type() {
	$labels = array(
		'name'               => __( 'Formularios recibidos', 'echos' ),
		'singular_name'      => __( 'Formulario recibido', 'echos' ),
		'menu_name'          => __( 'Formularios recibidos', 'echos' ),
		'name_admin_bar'     => __( 'Formulario recibido', 'echos' ),
		'add_new'            => __( 'Agregar nuevo', 'echos' ),
		'add_new_item'       => __( 'Agregar formulario', 'echos' ),
		'new_item'           => __( 'Nuevo formulario', 'echos' ),
		'edit_item'          => __( 'Ver formulario', 'echos' ),
		'view_item'          => __( 'Ver formulario', 'echos' ),
		'all_items'          => __( 'Todos los formularios', 'echos' ),
		'search_items'       => __( 'Buscar formularios', 'echos' ),
		'not_found'          => __( 'No hay formularios guardados.', 'echos' ),
		'not_found_in_trash' => __( 'No hay formularios en la papelera.', 'echos' ),
	);

	register_post_type(
		'echos_form_entry',
		array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => 'themes.php',
			'show_in_admin_bar'  => false,
			'show_in_nav_menus'  => false,
			'exclude_from_search'=> true,
			'menu_icon'          => 'dashicons-email-alt2',
			'supports'           => array( 'title' ),
			'capabilities'       => array(
				'create_posts' => 'do_not_allow',
			),
			'map_meta_cap'       => true,
		)
	);
}

/**
 * Defines admin columns for entries list.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function echos_forms_entry_columns( $columns ) {
	$new = array();

	if ( isset( $columns['cb'] ) ) {
		$new['cb'] = $columns['cb'];
	}

	$new['title']       = __( 'Registro', 'echos' );
	$new['source']      = __( 'Formulario', 'echos' );
	$new['service']     = __( 'Servicio', 'echos' );
	$new['contact']     = __( 'Contacto', 'echos' );
	$new['sheet_status']= __( 'Google Sheet', 'echos' );
	$new['mail_status'] = __( 'Correo', 'echos' );
	$new['date']        = isset( $columns['date'] ) ? $columns['date'] : __( 'Fecha', 'echos' );

	return $new;
}

/**
 * Renders custom columns.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 * @return void
 */
function echos_forms_render_entry_column( $column, $post_id ) {
	if ( 'source' === $column ) {
		$source = get_post_meta( $post_id, '_echos_form_source', true );
		echo esc_html( echos_forms_source_label( (string) $source ) );
		return;
	}

	if ( 'service' === $column ) {
		$service = (string) get_post_meta( $post_id, '_echos_form_service', true );
		echo '' !== trim( $service ) ? esc_html( $service ) : '&mdash;';
		return;
	}

	if ( 'contact' === $column ) {
		$name    = (string) get_post_meta( $post_id, '_echos_form_name', true );
		$company = (string) get_post_meta( $post_id, '_echos_form_company', true );
		$email   = (string) get_post_meta( $post_id, '_echos_form_email', true );

		$parts = array();
		if ( '' !== trim( $name ) ) {
			$parts[] = $name;
		}
		if ( '' !== trim( $company ) ) {
			$parts[] = $company;
		}
		if ( '' !== trim( $email ) ) {
			$parts[] = $email;
		}

		echo ! empty( $parts ) ? esc_html( implode( ' | ', $parts ) ) : '&mdash;';
		return;
	}

	if ( 'mail_status' === $column ) {
		$mail_sent = '1' === (string) get_post_meta( $post_id, '_echos_form_mail_sent', true );
		echo $mail_sent ? esc_html__( 'Enviado', 'echos' ) : esc_html__( 'Pendiente', 'echos' );
		return;
	}

	if ( 'sheet_status' === $column ) {
		$status = (string) get_post_meta( $post_id, '_echos_form_sheet_status', true );
		$error  = (string) get_post_meta( $post_id, '_echos_form_sheet_error', true );
		$label  = echos_forms_sheet_status_label( $status );

		if ( 'error' === $status && '' !== trim( $error ) ) {
			echo esc_html( $label . ': ' . $error );
			return;
		}

		echo esc_html( $label );
	}
}

/**
 * Registers details metabox for entry.
 *
 * @return void
 */
function echos_forms_register_entry_meta_box() {
	add_meta_box(
		'echos_form_entry_details',
		__( 'Detalle del formulario', 'echos' ),
		'echos_forms_render_entry_meta_box',
		'echos_form_entry',
		'normal',
		'high'
	);
}

/**
 * Renders entry details metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function echos_forms_render_entry_meta_box( $post ) {
	$source      = (string) get_post_meta( $post->ID, '_echos_form_source', true );
	$name        = (string) get_post_meta( $post->ID, '_echos_form_name', true );
	$company     = (string) get_post_meta( $post->ID, '_echos_form_company', true );
	$email       = (string) get_post_meta( $post->ID, '_echos_form_email', true );
	$phone       = (string) get_post_meta( $post->ID, '_echos_form_phone', true );
	$detail      = (string) get_post_meta( $post->ID, '_echos_form_detail', true );
	$service     = (string) get_post_meta( $post->ID, '_echos_form_service', true );
	$page_title  = (string) get_post_meta( $post->ID, '_echos_form_page_title', true );
	$page_url    = (string) get_post_meta( $post->ID, '_echos_form_page_url', true );
	$ip          = (string) get_post_meta( $post->ID, '_echos_form_ip', true );
	$user_agent  = (string) get_post_meta( $post->ID, '_echos_form_user_agent', true );
	$mail_sent   = '1' === (string) get_post_meta( $post->ID, '_echos_form_mail_sent', true );
	$submitted_at = (string) get_post_meta( $post->ID, '_echos_form_submitted_at', true );
	$sheet_status = (string) get_post_meta( $post->ID, '_echos_form_sheet_status', true );
	$sheet_error  = (string) get_post_meta( $post->ID, '_echos_form_sheet_error', true );
	$sheet_synced_at = (string) get_post_meta( $post->ID, '_echos_form_sheet_synced_at', true );
	$sheet_http_code = (string) get_post_meta( $post->ID, '_echos_form_sheet_http_code', true );
	$sheet_response_excerpt = (string) get_post_meta( $post->ID, '_echos_form_sheet_response_excerpt', true );
	$extra_raw   = get_post_meta( $post->ID, '_echos_form_extra', true );

	$rows = array(
		array(
			'label' => __( 'Formulario', 'echos' ),
			'value' => echos_forms_source_label( $source ),
			'type'  => 'text',
		),
		array(
			'label' => __( 'Servicio', 'echos' ),
			'value' => $service,
			'type'  => 'text',
		),
		array(
			'label' => __( 'Nombre', 'echos' ),
			'value' => $name,
			'type'  => 'text',
		),
		array(
			'label' => __( 'Empresa', 'echos' ),
			'value' => $company,
			'type'  => 'text',
		),
		array(
			'label' => __( 'Email', 'echos' ),
			'value' => $email,
			'type'  => 'text',
		),
		array(
			'label' => __( 'Telefono', 'echos' ),
			'value' => $phone,
			'type'  => 'text',
		),
		array(
			'label' => __( 'Detalle', 'echos' ),
			'value' => $detail,
			'type'  => 'text',
		),
		array(
			'label' => __( 'Pagina', 'echos' ),
			'value' => $page_title,
			'type'  => 'text',
		),
		array(
			'label' => __( 'URL', 'echos' ),
			'value' => $page_url,
			'type'  => 'url',
		),
		array(
			'label' => __( 'IP', 'echos' ),
			'value' => $ip,
			'type'  => 'text',
		),
		array(
			'label' => __( 'User-Agent', 'echos' ),
			'value' => $user_agent,
			'type'  => 'text',
		),
		array(
			'label' => __( 'Estado correo', 'echos' ),
			'value' => $mail_sent ? __( 'Enviado', 'echos' ) : __( 'Pendiente', 'echos' ),
			'type'  => 'text',
		),
		array(
			'label' => __( 'Estado Google Sheet', 'echos' ),
			'value' => echos_forms_sheet_status_label( $sheet_status ),
			'type'  => 'text',
		),
		array(
			'label' => __( 'Google Sheet (fecha sync)', 'echos' ),
			'value' => $sheet_synced_at,
			'type'  => 'text',
		),
		array(
			'label' => __( 'Google Sheet (HTTP)', 'echos' ),
			'value' => (int) $sheet_http_code > 0 ? $sheet_http_code : '',
			'type'  => 'text',
		),
		array(
			'label' => __( 'Google Sheet (error)', 'echos' ),
			'value' => $sheet_error,
			'type'  => 'text',
		),
		array(
			'label' => __( 'Google Sheet (respuesta)', 'echos' ),
			'value' => $sheet_response_excerpt,
			'type'  => 'text',
		),
		array(
			'label' => __( 'Fecha guardado', 'echos' ),
			'value' => $submitted_at,
			'type'  => 'text',
		),
	);

	echo '<table class="widefat striped">';
	echo '<tbody>';

	foreach ( $rows as $row ) {
		$label = isset( $row['label'] ) ? (string) $row['label'] : '';
		$value = isset( $row['value'] ) ? (string) $row['value'] : '';
		$type  = isset( $row['type'] ) ? (string) $row['type'] : 'text';

		if ( '' === trim( (string) $value ) ) {
			continue;
		}

		echo '<tr>';
		echo '<th style="width:200px;">' . esc_html( $label ) . '</th>';

		if ( 'url' === $type ) {
			echo '<td><a href="' . esc_url( $value ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( $value ) . '</a></td>';
		} else {
			echo '<td>' . esc_html( $value ) . '</td>';
		}

		echo '</tr>';
	}

	echo '</tbody>';
	echo '</table>';

	$extra = json_decode( (string) $extra_raw, true );
	if ( is_array( $extra ) && ! empty( $extra ) ) {
		echo '<h3>' . esc_html__( 'Campos adicionales', 'echos' ) . '</h3>';
		echo '<ul style="margin-left:18px; list-style:disc;">';
		foreach ( $extra as $key => $value ) {
			echo '<li><strong>' . esc_html( sanitize_text_field( (string) $key ) ) . ':</strong> ' . esc_html( sanitize_text_field( (string) $value ) ) . '</li>';
		}
		echo '</ul>';
	}
}
