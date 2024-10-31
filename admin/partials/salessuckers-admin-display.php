<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.sales-suckers.com
 * @since      1.0.0
 *
 * @package    Salessuckers
 * @subpackage Salessuckers/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
/**
 *
 * admin/partials/wp-salessuckers-admin-display.php - Don't add this comment
 *
 **/
?>

<div class="wrap sasu">

    <h2><?php echo esc_html(get_admin_page_title()); ?></h2>

    <form method="post" name="cleanup_options" action="options.php">

        <?php
//Grab all options
$options = get_option($this->plugin_name);

// Cleanup
$sasu_active = $options['active'];
$sasu_in_footer = $options['in_footer'];
$sasu_customer_id = $options['customer_id'];
$sasu_domain_id = $options['domain_id'];
$sasu_script = $options['script'];
$sasu_image = $options['image'];
$sasu_style = $options['style'];
?>

    <?php
settings_fields($this->plugin_name);
do_settings_sections($this->plugin_name);
?>
<div id="plugin_salessuckers_connector"></div>
<?php if (!empty($sasu_script) && !empty($sasu_image) && !empty($sasu_style)): ?>
    <?php if ($sasu_active): ?>
        <div class="notice-success notice sasu-showable" id="sasu_ready">
            <p><?php _e('Tracking is active', $this->plugin_name);?></p>
        </div>
    <?php else: ?>
        <div class="notice-warning notice sasu-showable" id="sasu_ready">
            <p><?php _e('Tracking is inactive', $this->plugin_name);?></p>
        </div>
    <?php endif;?>
    <script>
        var sasuIsLoginShown=false;
    </script>
<?php else: ?>
    <div class="notice-warning notice sasu-showable" id="sasu_missing_code">
        <p><?php _e('Please login with your Sales-Suckers user, to include the code', $this->plugin_name);?></p>
    </div>

    <script>
        var sasuIsLoginShown=true;
        window.setTimeout(() => {
            salessuckers_show('#sasu_missing_code', false)
        }, 5000);
    </script>

<?php endif;?>
<!-- Browser not supported -->
<div class="notice-error notice sasu-showable sasu-hidden" id="sasu_browser_warning">
    <p><?php _e('Your Browser is not supported, please use another e.g. Firefox, Chrome, ...', $this->plugin_name);?></p>
</div>
<script>
    // detect IE
    if(document.documentMode) {
        document.getElementById('sasu_browser_warning').setAttribute('class', 'notice-error notice');
    }
</script>

<!-- Login -->
<div class="sasu-showable sasu-hidden" id="sasu_login">
    <div class="notice-error notice sasu-showable sasu-hidden" id="sasu_login_failed">
        <p><?php _e('Login failed, wrong username or password', $this->plugin_name);?></p>
    </div>
    <div class="notice-success notice sasu-showable sasu-hidden" id="sasu_login_successfull">
        <p><?php _e('Login successfull', $this->plugin_name);?></p>
    </div>

    <h3><?php _e('Login to Sales-Suckers', $this->plugin_name);?></h3>
    <?php _e('Please login with your Sales-Suckers credentials to get the code for this website. Your credentials will not be saved, or used on other places in the application!', $this->plugin_name);?>
    <table class="form-table">
        <tr>
            <th scope="row"><label for="username"><?php _e('Username', $this->plugin_name);?></label></th>
            <td>
                <input type="text" class="regular-text" id="username" name="username" value="" placeholder="<?php _e('your@email.com', $this->plugin_name);?>" />
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="password"><?php _e('Password', $this->plugin_name);?></label></th>
            <td>
                <input type="password" class="regular-text" id="password" name="password" value="" placeholder="<?php _e('your password', $this->plugin_name);?>" />
            </td>
        </tr>
    </table>
    <a class="button button-primary js-action-login"><?php _e('Login', $this->plugin_name);?></a>
</div>

<div class="sasu-showable sasu-hidden sasu-loader-container" id="sasu_login_loader"><a class="sasu-loader">Loading</a></div>

<div class="error notice sasu-showable sasu-hidden" id="sasu_select_failed">
    <p><?php _e('Failed to select the domain, please try again', $this->plugin_name);?></p>
</div>

<!-- Domain List -->
<div class="sasu-showable sasu-hidden" id="sasu_domains">
    <p><?php _e('Please select your current domain', $this->plugin_name);?></p>
    <div id="sasu_domain_list" class="sasu-domains"></div>
</div>

<div class="sasu-showable sasu-hidden" id="sasu_domain_choose">
    <p><?php _e('Should this domain be used for tracking? Or choose the correct from above.', $this->plugin_name);?></p>
    <p class="sasu-large"><span id="sasu_selected_name"></span> <span id="sasu_selected_url" class="sasu-lighter"></span></p>
    <?php submit_button(__('Yes', $this->plugin_name), 'primary', 'applyDomain', false);?>
</div>

<div class="sasu-showable sasu-hidden sasu-loader-container" id="sasu_domain_loader"><a class="sasu-loader">Loading</a></div>

<!-- If in footer or not -->
<?php if (!empty($sasu_script) && !empty($sasu_image) && !empty($sasu_style)): ?>
    <div class="sasu-showable sasu-hidden" id="sasu_config">
        <table class="form-table">
            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-active"><?php _e('Active', $this->plugin_name);?></label></th>
                <td>
                    <label for="<?php echo $this->plugin_name; ?>-active">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-active" name="<?php echo $this->plugin_name; ?>[active]" value="1" <?php checked($sasu_active, 1);?>/>
                        <span><?php _e('Active Tracking', $this->plugin_name);?></span>
                    </label>
                    <br><em><b><?php _e('If the Tracking should be active on your website', $this->plugin_name);?></b></em>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="<?php echo $this->plugin_name; ?>-in_footer"><?php _e('Include in Footer', $this->plugin_name);?></label></th>
                <td>
                    <label for="<?php echo $this->plugin_name; ?>-in_footer">
                        <input type="checkbox" id="<?php echo $this->plugin_name; ?>-in_footer" name="<?php echo $this->plugin_name; ?>[in_footer]" value="1" <?php checked($sasu_in_footer, 1);?>/>
                        <span><?php _e('Should the Tracking code be in the footer, otherwise it will be placed in the header', $this->plugin_name);?></span>
                    </label>
                    <br><em><b><?php _e('When included in the footer, the performance is better', $this->plugin_name);?></b></em>
                </td>
            </tr>
        </table>
    </div>
<?php else: ?>
    <input type="hidden" data-id="in_footer" id="<?php echo $this->plugin_name; ?>-in_footer" name="<?php echo $this->plugin_name; ?>[in_footer]" value="1" />
    <input type="hidden" data-id="active" id="<?php echo $this->plugin_name; ?>-active" name="<?php echo $this->plugin_name; ?>[active]" value="1" />
<?php endif;?>

<!-- Settings -->
        <input type="hidden" data-id="domain_id" id="<?php echo $this->plugin_name; ?>-domain_id" name="<?php echo $this->plugin_name; ?>[domain_id]" value="<?php if (!empty($sasu_domain_id)) {
    echo $sasu_domain_id;
}
?>" />
        <input type="hidden" data-id="customer_id" id="<?php echo $this->plugin_name; ?>-customer_id" name="<?php echo $this->plugin_name; ?>[customer_id]" value="<?php if (!empty($sasu_customer_id)) {
    echo $sasu_customer_id;
}
?>" />
        <input type="hidden" data-id="script" id="<?php echo $this->plugin_name; ?>-script" name="<?php echo $this->plugin_name; ?>[script]" value="<?php if (!empty($sasu_script)) {
    echo $sasu_script;
}
?>" />
        <input type="hidden" data-id="image" id="<?php echo $this->plugin_name; ?>-image" name="<?php echo $this->plugin_name; ?>[image]" value="<?php if (!empty($sasu_image)) {
    echo $sasu_image;
}
?>" />
        <input type="hidden" data-id="style" id="<?php echo $this->plugin_name; ?>-style" name="<?php echo $this->plugin_name; ?>[style]" value="<?php if (!empty($sasu_style)) {
    echo $sasu_style;
}
?>" />

        <p>
            <a class="button sasu-showable js-action-reload"><?php _e('Cancel', $this->plugin_name);?></a>
            <a class="button sasu-showable sasu-hidden js-action-recheck" id="sasu_button_recheck"><?php _e('Reload the code', $this->plugin_name);?></a>
        </p>

        <?php submit_button(__('Save all changes', $this->plugin_name), 'primary sasu-showable sasu-hidden', 'sasu_button_save', true);?>
    </form>

</div>