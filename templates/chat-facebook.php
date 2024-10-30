<div class="wrap">
    <?php settings_errors(); ?>
    <form action="options.php" method="post">
      <?php
        settings_fields( 'katisoft_plugin_chat_facebook_settings' );
        do_settings_sections( 'katisoft_chat_facebook' );
        $katisoft_plugin_chat_facebook = get_option('katisoft_plugin_chat_facebook');
        // echo "<pre>";
        // print_r($katisoft_plugin_chat_facebook);
        // echo "</pre>";
        // die;
      ?>
      <div class="fbmcc-card card">
        <div class="intro">
          <div>
            <h2>Getting Started?</h2>
            <p class="fbmcc-instructions">Let people start a conversation on your
              website and continue in Messenger. It's easy to set up. We'll
              give you the code to add to your website.</p>
          </div>
          <div class="fbmcc-buttonContainer">
            <button
              class="fbmcc-setupButton"
              type="button"
              onclick="fbmcc_setupCustomerChat()"
            >
              <?php
                if( $katisoft_plugin_chat_facebook["fbmcc_generatedCode"] == "" ) {
                  _e( 'Setup Customer Chat', 'katisoft' );
                } else {
                  _e( 'Edit Customer Chat', 'katisoft' );
                }
              ?>
            </button>
          </div>
        </div>
      </div>
      <div
        id="fbmcc-page-params"
        class="fbmcc-card card"
        <?php if( $katisoft_plugin_chat_facebook["fbmcc_generatedCode"] == "" ) {
          _e( 'style="display:none;"', 'katisoft' );
        } ?>>
        <div>
          <p class="fbmcc-instructions">The code has already been added into your
            website. You can always go back through the setup process or edit
            the code manually below.
          </p>
        </div>
        <table class="fbmcc-settings">
          <tr valign="top">
            <th scope="row">Enabled</th>
            <td class="fbmcc-table-container">
              <div>
                <label class="fbmcc-switch">
                  <input
                    id="fbmcc-enabled"
                    value="1"
                    name="katisoft_plugin_chat_facebook[fbmcc_enabled]"
                    type="checkbox"
                    <?php checked( '1', $katisoft_plugin_chat_facebook["fbmcc_enabled"] ); ?>
                  >
                  <span class="fbmcc-slider round"></span>
                </label>
              </div>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row">Code Snippet</th>
          </tr>
        </table>
        <div class="fbmcc-codeContainer">
          <button id="fbmcc-editButton"
            class="fbmcc-editButton"
            type="button"
            onclick="fbmcc_editCode()"
          >
            Edit Code
          </button>
          <textarea
            id="fbmcc-codeArea"
            name="katisoft_plugin_chat_facebook[fbmcc_generatedCode]"
            class="fbmcc-code-area"
            rows="17"
            cols="70"
            readonly="true"
          ><?php esc_html_e( stripslashes( $katisoft_plugin_chat_facebook["fbmcc_generatedCode"] ), 'katisoft'); ?>
          </textarea>
        </div>
        <?php submit_button(); ?>
      </div>
    </form>
  </div>