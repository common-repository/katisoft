<?php
	// Catch the test form
	if ( isset( $_POST['mail_smtp_nonce_test'] ) ) {

		if ( ! wp_verify_nonce( trim( $_POST['mail_smtp_nonce_test'] ), 'mail-smtp-nonce' ) ) {
			wp_die('Security check not passed!');
		}

		$to = sanitize_text_field( trim( $_POST['mail_smtp_to'] ) );
		$subject = 'Katisoft Plugin - Mail SMTP: Test Mail';
		$message = 'Congrats, test email was sent successfully!';
		$status = false;
		$class = 'error';
		
		if ( ! empty( $to ) && is_email( $to ) ) {
			try {
					$result = wp_mail( $to, $subject, $message );
			} catch (Exception $e) {
					$status = $e->getMessage();
			}
		} else {
				$status ='Send to fields is empty or an invalid email supplied';
		}

		if ( ! $status ) {
			if ( $result === true ) {
					$status = 'Test email was sent successfully! Please check your inbox to make sure it is delivered!';
					$class = 'success';
			} else {
					$status = $this->phpmailer_error->get_error_message();
			}
		}

		echo '<div id="message" class="notice notice-' . $class . ' is-dismissible"><p><strong>' . $status . '</strong></p></div>';
	}
?>

<div class="wrap">
	<h1>WP Mail SMTP Manager</h1>
    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Settings</a></li>
		<li>
			<a href="#tab-2">
				Email Test
			</a>
		</li>
    </ul>
    
    <div class="tab-content">
		<div id="tab-1" class="tab-pane active">
			<form method="post" action="options.php">
				<?php 
					settings_fields( 'katisoft_plugin_mail_smtp_settings' );
					do_settings_sections( 'katisoft_mail_smtp' );
					submit_button();
				?>
			</form>
		</div>

		<div id="tab-2" class="tab-pane">
			<form action="" method="post" enctype="multipart/form-data" name="mail_smtp_testform">
		<h2>Send a Test Email</h2>
		<p>Change an email address a test email will be sent to.</p>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">
                    Send To
                </th>
                <td>
                    <label>
                        <input type="email" class="regular-text" name="mail_smtp_to" value="" placeholder="user@example.com" required />
                    </label>
                </td>
            </tr>
        </table>
        <p class="submit">
            <input type="hidden" name="mail_smtp_nonce_test" value="<?php echo wp_create_nonce("mail-smtp-nonce") ?>"/>
            <input type="submit" class="button-primary" value="Send Email"/>
        </p>
    	</form>
		</div>
	</div>
</div>