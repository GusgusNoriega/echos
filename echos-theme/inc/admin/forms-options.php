<?php
/**
 * Forms options page (mail + Google Sheets).
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', 'echos_forms_register_options_page' );
add_action( 'admin_post_echos_save_forms_settings', 'echos_forms_save_options_page' );
add_action( 'admin_post_echos_download_google_sheet_logs', 'echos_forms_download_google_sheet_logs' );
add_action( 'admin_post_echos_clear_google_sheet_logs', 'echos_forms_clear_google_sheet_logs' );

/**
 * Registers forms options page under Appearance.
 *
 * @return void
 */
function echos_forms_register_options_page() {
	add_theme_page(
		__( 'Formularios ECHOS', 'echos' ),
		__( 'Formularios ECHOS', 'echos' ),
		'manage_options',
		'echos-forms-options',
		'echos_forms_render_options_page'
	);
}

/**
 * Renders forms options page.
 *
 * @return void
 */
function echos_forms_render_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$settings          = echos_forms_get_settings();
	$updated           = isset( $_GET['updated'] ) ? sanitize_key( wp_unslash( $_GET['updated'] ) ) : '';
	$entries_url       = admin_url( 'edit.php?post_type=echos_form_entry' );
	$sheet_manage_url  = isset( $settings['google_sheets_spreadsheet_url'] ) ? (string) $settings['google_sheets_spreadsheet_url'] : '';
	$has_smtp_password = '' !== trim( (string) $settings['smtp_password'] );
	$has_sheet_secret  = '' !== trim( (string) $settings['google_sheets_secret'] );
	$sheet_logs_cleared = isset( $_GET['sheet_logs_cleared'] ) ? sanitize_key( wp_unslash( $_GET['sheet_logs_cleared'] ) ) : '';
	$log_file_path      = function_exists( 'echos_forms_get_google_sheet_log_file_path' ) ? echos_forms_get_google_sheet_log_file_path( false ) : '';
	$log_exists         = '' !== trim( $log_file_path ) && file_exists( $log_file_path );
	$log_size           = $log_exists ? size_format( (int) filesize( $log_file_path ), 2 ) : '0 B';
	$log_updated_at     = $log_exists ? wp_date( 'Y-m-d H:i:s', (int) filemtime( $log_file_path ) ) : '';
	$log_tail           = function_exists( 'echos_forms_get_google_sheet_logs_tail' ) ? echos_forms_get_google_sheet_logs_tail( 160, 100000 ) : '';
	$logs_action_url    = admin_url( 'admin-post.php' );
	$download_logs_url  = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'echos_download_google_sheet_logs',
			),
			$logs_action_url
		),
		'echos_forms_sheet_logs_action',
		'nonce'
	);
	$clear_logs_url     = wp_nonce_url(
		add_query_arg(
			array(
				'action' => 'echos_clear_google_sheet_logs',
			),
			$logs_action_url
		),
		'echos_forms_sheet_logs_action',
		'nonce'
	);
	$apps_script_code  = <<<'EOCODE'
const HEADERS = [
  "entry_id",
  "submitted_at",
  "source_key",
  "source_label",
  "service",
  "name",
  "company",
  "email",
  "phone",
  "detail",
  "page_title",
  "page_url",
  "ip",
  "user_agent",
  "extra_json"
];

const DEFAULT_SHEET = "Leads";
const SHARED_SECRET = "REEMPLAZAR_CON_TU_TOKEN";

function jsonResponse_(data) {
  return ContentService
    .createTextOutput(JSON.stringify(data))
    .setMimeType(ContentService.MimeType.JSON);
}

function getTargetSheetName_(payload) {
  const requested = String((payload && payload.sheet_name) || "").trim();
  return requested || DEFAULT_SHEET;
}

function getOrCreateSheet_(spreadsheet, sheetName) {
  let sheet = spreadsheet.getSheetByName(sheetName);
  if (!sheet) {
    sheet = spreadsheet.insertSheet(sheetName);
  }
  return sheet;
}

function ensureHeaders_(sheet) {
  if (sheet.getLastRow() === 0) {
    sheet.appendRow(HEADERS);
  }
}

// Endpoint de verificacion rapida: al abrir /exec en navegador debe responder JSON.
function doGet() {
  return jsonResponse_({ ok: true, status: "ready", hasDoPost: true });
}

function parsePayload_(e) {
  if (e && e.postData && e.postData.contents) {
    try {
      return JSON.parse(e.postData.contents);
    } catch (jsonError) {
      // fallback a payload form-url-encoded
    }
  }

  if (e && e.parameter && e.parameter.payload) {
    try {
      return JSON.parse(e.parameter.payload);
    } catch (payloadError) {
      return null;
    }
  }

  return null;
}

function doPost(e) {
  let lock = null;

  try {
    const payload = parsePayload_(e);
    if (!payload) {
      return jsonResponse_({ ok: false, error: "invalid_payload" });
    }

    const incomingSecret = String(
      payload.secret ||
      (e && e.parameter && e.parameter.secret) ||
      ""
    );

    if (SHARED_SECRET && incomingSecret !== SHARED_SECRET) {
      return jsonResponse_({ ok: false, error: "invalid_secret" });
    }

    lock = LockService.getScriptLock();
    lock.waitLock(20000);

    const spreadsheet = SpreadsheetApp.getActiveSpreadsheet();
    const sheetName = getTargetSheetName_(payload);
    const sheet = getOrCreateSheet_(spreadsheet, sheetName);
    ensureHeaders_(sheet);

    const row = payload.row || {};
    sheet.appendRow([
      row.entry_id || "",
      row.submitted_at || "",
      row.source_key || "",
      row.source_label || "",
      row.service || "",
      row.name || "",
      row.company || "",
      row.email || "",
      row.phone || "",
      row.detail || "",
      row.page_title || "",
      row.page_url || "",
      row.ip || "",
      row.user_agent || "",
      row.extra_json || ""
    ]);

    return jsonResponse_({
      ok: true,
      row: sheet.getLastRow(),
      sheet: sheetName,
      spreadsheet_id: spreadsheet.getId()
    });
  } catch (error) {
    const message = error && error.message ? error.message : String(error);
    return jsonResponse_({ ok: false, error: String(message) });
  } finally {
    if (lock) {
      lock.releaseLock();
    }
  }
}
EOCODE;
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Formularios ECHOS - Configuracion de envio', 'echos' ); ?></h1>

		<?php if ( 'true' === $updated ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Configuracion actualizada correctamente.', 'echos' ); ?></p>
			</div>
		<?php endif; ?>

		<?php if ( 'true' === $sheet_logs_cleared ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Log de Google Sheets limpiado correctamente.', 'echos' ); ?></p>
			</div>
		<?php endif; ?>

		<p class="description">
			<?php esc_html_e( 'Aqui configuras correo de notificacion, integracion con Google Sheets y revisas todos los envios internos.', 'echos' ); ?>
		</p>
		<p class="description">
			<?php esc_html_e( 'Nota: FTP sirve para transferir archivos. Para enviar correos se usa SMTP.', 'echos' ); ?>
		</p>
		<p>
			<a class="button button-secondary" href="<?php echo esc_url( $entries_url ); ?>">
				<?php esc_html_e( 'Ver formularios guardados', 'echos' ); ?>
			</a>
			<?php if ( '' !== trim( $sheet_manage_url ) ) : ?>
				<a class="button button-secondary" href="<?php echo esc_url( $sheet_manage_url ); ?>" target="_blank" rel="noopener noreferrer">
					<?php esc_html_e( 'Abrir Google Sheet', 'echos' ); ?>
				</a>
			<?php endif; ?>
		</p>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'echos_forms_save_options', 'echos_forms_options_nonce' ); ?>
			<input type="hidden" name="action" value="echos_save_forms_settings" />

			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">
							<label for="echos-notify-to"><?php esc_html_e( 'Correos destino', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="echos-notify-to"
								name="echos_forms_settings[notify_to]"
								value="<?php echo esc_attr( (string) $settings['notify_to'] ); ?>"
							/>
							<p class="description">
								<?php esc_html_e( 'Puedes usar varios correos separados por coma.', 'echos' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-from-email"><?php esc_html_e( 'Correo remitente', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="email"
								class="regular-text"
								id="echos-from-email"
								name="echos_forms_settings[from_email]"
								value="<?php echo esc_attr( (string) $settings['from_email'] ); ?>"
							/>
							<p class="description">
								<?php esc_html_e( 'Debe existir en tu servidor SMTP para evitar rechazos.', 'echos' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-from-name"><?php esc_html_e( 'Nombre remitente', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="echos-from-name"
								name="echos_forms_settings[from_name]"
								value="<?php echo esc_attr( (string) $settings['from_name'] ); ?>"
							/>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-success-message"><?php esc_html_e( 'Mensaje de exito (frontend)', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="echos-success-message"
								name="echos_forms_settings[success_message]"
								value="<?php echo esc_attr( (string) $settings['success_message'] ); ?>"
							/>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-error-message"><?php esc_html_e( 'Mensaje de error (frontend)', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="echos-error-message"
								name="echos_forms_settings[error_message]"
								value="<?php echo esc_attr( (string) $settings['error_message'] ); ?>"
							/>
						</td>
					</tr>
				</tbody>
			</table>

			<h2><?php esc_html_e( 'Configuracion SMTP', 'echos' ); ?></h2>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><?php esc_html_e( 'Activar SMTP', 'echos' ); ?></th>
						<td>
							<label for="echos-smtp-enabled">
								<input
									type="checkbox"
									id="echos-smtp-enabled"
									name="echos_forms_settings[smtp_enabled]"
									value="1"
									<?php checked( ! empty( $settings['smtp_enabled'] ) ); ?>
								/>
								<?php esc_html_e( 'Usar servidor SMTP para enviar notificaciones', 'echos' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-smtp-host"><?php esc_html_e( 'SMTP host', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="echos-smtp-host"
								name="echos_forms_settings[smtp_host]"
								value="<?php echo esc_attr( (string) $settings['smtp_host'] ); ?>"
								placeholder="smtp.tudominio.com"
							/>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-smtp-port"><?php esc_html_e( 'SMTP puerto', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="number"
								class="small-text"
								id="echos-smtp-port"
								name="echos_forms_settings[smtp_port]"
								value="<?php echo esc_attr( (string) $settings['smtp_port'] ); ?>"
								min="1"
								max="65535"
							/>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-smtp-encryption"><?php esc_html_e( 'Cifrado', 'echos' ); ?></label>
						</th>
						<td>
							<select id="echos-smtp-encryption" name="echos_forms_settings[smtp_encryption]">
								<option value="tls" <?php selected( 'tls', (string) $settings['smtp_encryption'] ); ?>>TLS</option>
								<option value="ssl" <?php selected( 'ssl', (string) $settings['smtp_encryption'] ); ?>>SSL</option>
								<option value="none" <?php selected( 'none', (string) $settings['smtp_encryption'] ); ?>><?php esc_html_e( 'Sin cifrado', 'echos' ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-smtp-username"><?php esc_html_e( 'Usuario SMTP', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="echos-smtp-username"
								name="echos_forms_settings[smtp_username]"
								value="<?php echo esc_attr( (string) $settings['smtp_username'] ); ?>"
							/>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-smtp-password"><?php esc_html_e( 'Contrasena SMTP', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="password"
								class="regular-text"
								id="echos-smtp-password"
								name="echos_forms_settings[smtp_password]"
								value=""
								autocomplete="new-password"
							/>
							<p class="description">
								<?php if ( $has_smtp_password ) : ?>
									<?php esc_html_e( 'Ya existe una contrasena guardada. Si dejas este campo vacio se mantiene.', 'echos' ); ?>
								<?php else : ?>
									<?php esc_html_e( 'No hay contrasena guardada actualmente.', 'echos' ); ?>
								<?php endif; ?>
							</p>
							<label for="echos-smtp-password-clear">
								<input
									type="checkbox"
									id="echos-smtp-password-clear"
									name="echos_forms_settings[smtp_password_clear]"
									value="1"
								/>
								<?php esc_html_e( 'Borrar contrasena guardada', 'echos' ); ?>
							</label>
						</td>
					</tr>
				</tbody>
			</table>

			<h2><?php esc_html_e( 'Configuracion Google Sheets', 'echos' ); ?></h2>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><?php esc_html_e( 'Activar Google Sheets', 'echos' ); ?></th>
						<td>
							<label for="echos-google-sheets-enabled">
								<input
									type="checkbox"
									id="echos-google-sheets-enabled"
									name="echos_forms_settings[google_sheets_enabled]"
									value="1"
									<?php checked( ! empty( $settings['google_sheets_enabled'] ) ); ?>
								/>
								<?php esc_html_e( 'Enviar cada formulario recibido a Google Sheets', 'echos' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-google-sheets-webhook"><?php esc_html_e( 'URL Web App (Apps Script)', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="url"
								class="regular-text code"
								id="echos-google-sheets-webhook"
								name="echos_forms_settings[google_sheets_webhook_url]"
								value="<?php echo esc_attr( (string) $settings['google_sheets_webhook_url'] ); ?>"
								placeholder="https://script.google.com/macros/s/.../exec"
							/>
							<p class="description">
								<?php esc_html_e( 'Pega aqui la URL del deployment tipo Web App de Apps Script.', 'echos' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-google-sheets-url"><?php esc_html_e( 'URL de la hoja (opcional)', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="url"
								class="regular-text code"
								id="echos-google-sheets-url"
								name="echos_forms_settings[google_sheets_spreadsheet_url]"
								value="<?php echo esc_attr( (string) $settings['google_sheets_spreadsheet_url'] ); ?>"
								placeholder="https://docs.google.com/spreadsheets/d/..."
							/>
							<p class="description">
								<?php esc_html_e( 'Se usa solo para mostrar el boton "Abrir Google Sheet" en esta pantalla.', 'echos' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-google-sheets-sheet-name"><?php esc_html_e( 'Pestana por defecto', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="echos-google-sheets-sheet-name"
								name="echos_forms_settings[google_sheets_sheet_name]"
								value="<?php echo esc_attr( (string) $settings['google_sheets_sheet_name'] ); ?>"
							/>
							<p class="description">
								<?php esc_html_e( 'Se usa cuando no hay una pestana especifica por formulario.', 'echos' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-google-sheets-sheet-home"><?php esc_html_e( 'Pestana formulario Inicio', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="echos-google-sheets-sheet-home"
								name="echos_forms_settings[google_sheets_sheet_name_home_contact]"
								value="<?php echo esc_attr( (string) $settings['google_sheets_sheet_name_home_contact'] ); ?>"
								placeholder="Leads Inicio"
							/>
							<p class="description">
								<?php esc_html_e( 'Opcional. Se aplica al form_source home_contact.', 'echos' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-google-sheets-sheet-contact"><?php esc_html_e( 'Pestana formulario Contacto', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="echos-google-sheets-sheet-contact"
								name="echos_forms_settings[google_sheets_sheet_name_contact_page]"
								value="<?php echo esc_attr( (string) $settings['google_sheets_sheet_name_contact_page'] ); ?>"
								placeholder="Leads Contacto"
							/>
							<p class="description">
								<?php esc_html_e( 'Opcional. Se aplica al form_source contact_page.', 'echos' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-google-sheets-sheet-popup"><?php esc_html_e( 'Pestana formulario Popup', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="echos-google-sheets-sheet-popup"
								name="echos_forms_settings[google_sheets_sheet_name_popup_subscribe]"
								value="<?php echo esc_attr( (string) $settings['google_sheets_sheet_name_popup_subscribe'] ); ?>"
								placeholder="Leads Popup"
							/>
							<p class="description">
								<?php esc_html_e( 'Opcional. Se aplica al form_source popup_subscribe.', 'echos' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-google-sheets-timeout"><?php esc_html_e( 'Timeout HTTP (segundos)', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="number"
								class="small-text"
								id="echos-google-sheets-timeout"
								name="echos_forms_settings[google_sheets_timeout]"
								value="<?php echo esc_attr( (string) $settings['google_sheets_timeout'] ); ?>"
								min="3"
								max="60"
							/>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Activar logs de depuracion', 'echos' ); ?></th>
						<td>
							<label for="echos-google-sheets-logging-enabled">
								<input
									type="checkbox"
									id="echos-google-sheets-logging-enabled"
									name="echos_forms_settings[google_sheets_logging_enabled]"
									value="1"
									<?php checked( ! empty( $settings['google_sheets_logging_enabled'] ) ); ?>
								/>
								<?php esc_html_e( 'Guardar request/response/error de Google Sheets en archivo interno', 'echos' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-google-sheets-log-max-size"><?php esc_html_e( 'Tamano maximo del log (KB)', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="number"
								class="small-text"
								id="echos-google-sheets-log-max-size"
								name="echos_forms_settings[google_sheets_log_max_size_kb]"
								value="<?php echo esc_attr( (string) $settings['google_sheets_log_max_size_kb'] ); ?>"
								min="256"
								max="20480"
							/>
							<p class="description">
								<?php esc_html_e( 'Cuando supera este tamano se rota automaticamente (google-sheets.log.1).', 'echos' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-google-sheets-secret"><?php esc_html_e( 'Token secreto compartido', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="password"
								class="regular-text"
								id="echos-google-sheets-secret"
								name="echos_forms_settings[google_sheets_secret]"
								value=""
								autocomplete="new-password"
							/>
							<p class="description">
								<?php if ( $has_sheet_secret ) : ?>
									<?php esc_html_e( 'Ya existe un token guardado. Si dejas este campo vacio se mantiene.', 'echos' ); ?>
								<?php else : ?>
									<?php esc_html_e( 'No hay token guardado actualmente.', 'echos' ); ?>
								<?php endif; ?>
							</p>
							<label for="echos-google-sheets-secret-clear">
								<input
									type="checkbox"
									id="echos-google-sheets-secret-clear"
									name="echos_forms_settings[google_sheets_secret_clear]"
									value="1"
								/>
								<?php esc_html_e( 'Borrar token guardado', 'echos' ); ?>
							</label>
						</td>
					</tr>
				</tbody>
			</table>

			<h2><?php esc_html_e( 'Depuracion y logs Google Sheets', 'echos' ); ?></h2>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><?php esc_html_e( 'Archivo de log', 'echos' ); ?></th>
						<td>
							<input type="text" class="regular-text code" readonly value="<?php echo esc_attr( $log_file_path ); ?>" />
							<p class="description">
								<?php esc_html_e( 'Estado:', 'echos' ); ?>
								<?php echo $log_exists ? esc_html__( 'Disponible', 'echos' ) : esc_html__( 'Aun no creado', 'echos' ); ?>
								|
								<?php esc_html_e( 'Tamano:', 'echos' ); ?>
								<?php echo esc_html( $log_size ); ?>
								<?php if ( '' !== trim( $log_updated_at ) ) : ?>
									|
									<?php esc_html_e( 'Ultima actualizacion:', 'echos' ); ?>
									<?php echo esc_html( $log_updated_at ); ?>
								<?php endif; ?>
							</p>
							<p>
								<a class="button button-secondary" href="<?php echo esc_url( $download_logs_url ); ?>">
									<?php esc_html_e( 'Descargar log', 'echos' ); ?>
								</a>
								<a
									class="button button-secondary"
									href="<?php echo esc_url( $clear_logs_url ); ?>"
									onclick="return confirm('Se vaciara el archivo de logs de Google Sheets. Deseas continuar?');"
								>
									<?php esc_html_e( 'Vaciar log', 'echos' ); ?>
								</a>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Ultimas lineas del log', 'echos' ); ?></th>
						<td>
							<textarea class="large-text code" rows="16" readonly><?php echo esc_textarea( $log_tail ); ?></textarea>
							<p class="description">
								<?php esc_html_e( 'Muestra los eventos recientes con request, payload enviado, respuesta HTTP y errores.', 'echos' ); ?>
							</p>
						</td>
					</tr>
				</tbody>
			</table>

			<h2><?php esc_html_e( 'Mini manual de configuracion Google Sheets', 'echos' ); ?></h2>
			<ol style="max-width:980px;">
				<li><?php esc_html_e( 'Crea una hoja nueva en Google Sheets y abre Extensiones > Apps Script.', 'echos' ); ?></li>
				<li><?php esc_html_e( 'Reemplaza el contenido del editor con el script de ejemplo de abajo.', 'echos' ); ?></li>
				<li><?php esc_html_e( 'Verifica que exista function doPost(e) en el archivo principal (nivel global, no anidada).', 'echos' ); ?></li>
				<li><?php esc_html_e( 'No cambies los nombres doGet y doPost; WordPress depende de esos endpoints exactos.', 'echos' ); ?></li>
				<li><?php esc_html_e( 'Edita SHARED_SECRET y coloca el mismo token que guardaras en WordPress (o deja vacio ambos lados).', 'echos' ); ?></li>
				<li><?php esc_html_e( 'Guarda el proyecto y luego publica: Deploy > New deployment > Web app.', 'echos' ); ?></li>
				<li><?php esc_html_e( 'Configura Execute as: Me y Who has access: Anyone.', 'echos' ); ?></li>
				<li><?php esc_html_e( 'Cada vez que cambies el script debes hacer Edit deployment > New version.', 'echos' ); ?></li>
				<li><?php esc_html_e( 'Copia exactamente la URL /exec del deployment activo (no uses /dev).', 'echos' ); ?></li>
				<li><?php esc_html_e( 'Pega la URL en "URL Web App (Apps Script)", activa Google Sheets y guarda.', 'echos' ); ?></li>
				<li><?php esc_html_e( 'Prueba la URL /exec en el navegador: debe responder JSON con {\"ok\":true,\"hasDoPost\":true}.', 'echos' ); ?></li>
				<li><?php esc_html_e( 'Envia un formulario y confirma en logs que response_received tenga JSON y sync_success.', 'echos' ); ?></li>
				<li><?php esc_html_e( 'Si aparece "Script function not found: doPost", el deployment publicado no contiene doPost(e).', 'echos' ); ?></li>
				<li><?php esc_html_e( 'Si aparece HTTP 400 HTML de Google, revisa permisos del deployment y confirma que sea la URL /exec correcta.', 'echos' ); ?></li>
			</ol>

			<p><strong><?php esc_html_e( 'Script recomendado (Apps Script):', 'echos' ); ?></strong></p>
			<textarea class="large-text code" rows="32" readonly><?php echo esc_textarea( $apps_script_code ); ?></textarea>

			<?php submit_button( __( 'Guardar configuracion de formularios', 'echos' ) ); ?>
		</form>
	</div>
	<?php
}

/**
 * Handles forms settings save action.
 *
 * @return void
 */
function echos_forms_save_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'No tienes permisos para editar esta configuracion.', 'echos' ) );
	}

	if ( ! isset( $_POST['echos_forms_options_nonce'] ) ) {
		wp_safe_redirect( admin_url( 'themes.php?page=echos-forms-options' ) );
		exit;
	}

	$nonce = sanitize_text_field( wp_unslash( $_POST['echos_forms_options_nonce'] ) );
	if ( ! wp_verify_nonce( $nonce, 'echos_forms_save_options' ) ) {
		wp_die( esc_html__( 'Nonce invalido al guardar formularios.', 'echos' ) );
	}

	$raw = array();
	if ( isset( $_POST['echos_forms_settings'] ) && is_array( $_POST['echos_forms_settings'] ) ) {
		$raw = wp_unslash( $_POST['echos_forms_settings'] );
	}

	$sanitized = echos_forms_sanitize_settings( $raw, echos_forms_get_settings() );
	update_option( 'echos_forms_settings', $sanitized, false );

	$redirect = add_query_arg(
		array(
			'page'    => 'echos-forms-options',
			'updated' => 'true',
		),
		admin_url( 'themes.php' )
	);

	wp_safe_redirect( $redirect );
	exit;
}

/**
 * Sanitizes forms settings payload.
 *
 * @param array $raw     Raw posted settings.
 * @param array $current Current saved settings.
 * @return array
 */
function echos_forms_sanitize_settings( $raw, $current ) {
	$defaults = echos_forms_default_settings();
	$raw      = is_array( $raw ) ? $raw : array();
	$current  = is_array( $current ) ? $current : array();

	$clean = array(
		'smtp_enabled'    => ! empty( $raw['smtp_enabled'] ),
		'smtp_host'       => sanitize_text_field( (string) ( $raw['smtp_host'] ?? '' ) ),
		'smtp_port'       => echos_forms_normalize_port( $raw['smtp_port'] ?? $defaults['smtp_port'] ),
		'smtp_encryption' => echos_forms_normalize_encryption( $raw['smtp_encryption'] ?? $defaults['smtp_encryption'] ),
		'smtp_username'   => sanitize_text_field( (string) ( $raw['smtp_username'] ?? '' ) ),
		'google_sheets_enabled'         => ! empty( $raw['google_sheets_enabled'] ),
		'google_sheets_webhook_url'     => echos_forms_sanitize_webhook_url( $raw['google_sheets_webhook_url'] ?? '' ),
		'google_sheets_spreadsheet_url' => echos_forms_sanitize_webhook_url( $raw['google_sheets_spreadsheet_url'] ?? '' ),
		'google_sheets_timeout'         => echos_forms_normalize_http_timeout( $raw['google_sheets_timeout'] ?? $defaults['google_sheets_timeout'] ),
		'google_sheets_logging_enabled' => ! empty( $raw['google_sheets_logging_enabled'] ),
		'google_sheets_log_max_size_kb' => echos_forms_normalize_log_size_kb( $raw['google_sheets_log_max_size_kb'] ?? $defaults['google_sheets_log_max_size_kb'] ),
	);

	$clear_password = ! empty( $raw['smtp_password_clear'] );
	$new_password   = isset( $raw['smtp_password'] ) && is_scalar( $raw['smtp_password'] ) ? trim( (string) $raw['smtp_password'] ) : '';

	if ( $clear_password ) {
		$clean['smtp_password'] = '';
	} elseif ( '' !== $new_password ) {
		$clean['smtp_password'] = $new_password;
	} else {
		$clean['smtp_password'] = isset( $current['smtp_password'] ) && is_scalar( $current['smtp_password'] )
			? (string) $current['smtp_password']
			: '';
	}

	$sheet_name = echos_forms_sanitize_sheet_tab_name( (string) ( $raw['google_sheets_sheet_name'] ?? '' ) );
	if ( '' === trim( $sheet_name ) ) {
		$sheet_name = echos_forms_sanitize_sheet_tab_name( (string) $defaults['google_sheets_sheet_name'] );
	}
	$clean['google_sheets_sheet_name'] = $sheet_name;
	$clean['google_sheets_sheet_name_home_contact'] = echos_forms_sanitize_sheet_tab_name( (string) ( $raw['google_sheets_sheet_name_home_contact'] ?? '' ) );
	$clean['google_sheets_sheet_name_contact_page'] = echos_forms_sanitize_sheet_tab_name( (string) ( $raw['google_sheets_sheet_name_contact_page'] ?? '' ) );
	$clean['google_sheets_sheet_name_popup_subscribe'] = echos_forms_sanitize_sheet_tab_name( (string) ( $raw['google_sheets_sheet_name_popup_subscribe'] ?? '' ) );

	$clear_sheet_secret = ! empty( $raw['google_sheets_secret_clear'] );
	$new_sheet_secret   = isset( $raw['google_sheets_secret'] ) && is_scalar( $raw['google_sheets_secret'] )
		? sanitize_text_field( trim( (string) $raw['google_sheets_secret'] ) )
		: '';

	if ( $clear_sheet_secret ) {
		$clean['google_sheets_secret'] = '';
	} elseif ( '' !== $new_sheet_secret ) {
		$clean['google_sheets_secret'] = $new_sheet_secret;
	} else {
		$clean['google_sheets_secret'] = isset( $current['google_sheets_secret'] ) && is_scalar( $current['google_sheets_secret'] )
			? sanitize_text_field( (string) $current['google_sheets_secret'] )
			: '';
	}

	$from_email = sanitize_email( (string) ( $raw['from_email'] ?? '' ) );
	if ( ! is_email( $from_email ) ) {
		$from_email = sanitize_email( (string) $defaults['from_email'] );
	}
	$clean['from_email'] = $from_email;

	$from_name = sanitize_text_field( (string) ( $raw['from_name'] ?? '' ) );
	if ( '' === trim( $from_name ) ) {
		$from_name = sanitize_text_field( (string) $defaults['from_name'] );
	}
	$clean['from_name'] = $from_name;

	$notify_to = echos_forms_parse_emails( (string) ( $raw['notify_to'] ?? '' ) );
	if ( empty( $notify_to ) ) {
		$notify_to = echos_forms_parse_emails( (string) $defaults['notify_to'] );
	}
	$clean['notify_to'] = implode( ', ', $notify_to );

	$success_message = sanitize_text_field( (string) ( $raw['success_message'] ?? '' ) );
	if ( '' === trim( $success_message ) ) {
		$success_message = (string) $defaults['success_message'];
	}
	$clean['success_message'] = $success_message;

	$error_message = sanitize_text_field( (string) ( $raw['error_message'] ?? '' ) );
	if ( '' === trim( $error_message ) ) {
		$error_message = (string) $defaults['error_message'];
	}
	$clean['error_message'] = $error_message;

	return $clean;
}

/**
 * Downloads Google Sheets debug log file.
 *
 * @return void
 */
function echos_forms_download_google_sheet_logs() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'No tienes permisos para descargar este archivo.', 'echos' ) );
	}

	$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'echos_forms_sheet_logs_action' ) ) {
		wp_die( esc_html__( 'Nonce invalido para descargar logs.', 'echos' ) );
	}

	$log_file = function_exists( 'echos_forms_get_google_sheet_log_file_path' ) ? echos_forms_get_google_sheet_log_file_path( false ) : '';
	if ( '' === trim( $log_file ) || ! file_exists( $log_file ) || ! is_readable( $log_file ) ) {
		wp_die( esc_html__( 'No existe un archivo de log disponible.', 'echos' ) );
	}

	nocache_headers();
	header( 'Content-Type: text/plain; charset=UTF-8' );
	header( 'Content-Disposition: attachment; filename="echos-google-sheets.log"' );
	header( 'Content-Length: ' . (string) filesize( $log_file ) );

	readfile( $log_file );
	exit;
}

/**
 * Clears Google Sheets debug log file.
 *
 * @return void
 */
function echos_forms_clear_google_sheet_logs() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'No tienes permisos para borrar este archivo.', 'echos' ) );
	}

	$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'echos_forms_sheet_logs_action' ) ) {
		wp_die( esc_html__( 'Nonce invalido para limpiar logs.', 'echos' ) );
	}

	if ( function_exists( 'echos_forms_clear_google_sheet_log_file' ) ) {
		echos_forms_clear_google_sheet_log_file();
	}

	$redirect = add_query_arg(
		array(
			'page'               => 'echos-forms-options',
			'updated'            => 'true',
			'sheet_logs_cleared' => 'true',
		),
		admin_url( 'themes.php' )
	);

	wp_safe_redirect( $redirect );
	exit;
}
