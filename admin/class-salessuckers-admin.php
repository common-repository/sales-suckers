<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.sales-suckers.com
 * @since      1.0.0
 *
 * @package    Salessuckers
 * @subpackage Salessuckers/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Salessuckers
 * @subpackage Salessuckers/admin
 * @author     Sales-Suckers <hello@sales-suckers.com>
 */
class Salessuckers_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Salessuckers_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Salessuckers_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/salessuckers-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Salessuckers_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Salessuckers_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name.'_salessuckers', plugin_dir_url(__FILE__) . 'js/sales-suckers.js', $this->version, false);
        wp_enqueue_script($this->plugin_name.'_api', plugin_dir_url(__FILE__) . 'js/api.js', $this->version, false);
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/admin.js', array('jquery', $this->plugin_name.'_api', $this->plugin_name.'_salessuckers'), $this->version, false);
    }

    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu()
    {

        /*
         * Add a settings page for this plugin to the Settings menu.
         *
         * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
         *
         *        Administration Menus: http://codex.wordpress.org/Administration_Menus
         *
         */
        add_options_page('Sales-Suckers Settings', 'Sales-Suckers', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page')
        );
    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */

    public function add_action_links($links)
    {
        /*
         *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
         */
        $settings_link = array(
            '<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>',
        );
        return array_merge($settings_link, $links);

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */

    public function display_plugin_setup_page()
    {
        include_once 'partials/salessuckers-admin-display.php';
    }

    public function options_update()
    {
        register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
    }

    public function validate($input)
    {
        // All checkboxes inputs
        $valid = array();

        // validate the settings and register them for the options
        $valid['active'] = (isset($input['active']) && !empty($input['active'])) ? 1 : 0;
        $valid['in_footer'] = (isset($input['in_footer']) && !empty($input['in_footer'])) ? 1 : 0;
        $valid['customer_id'] = isset($input['customer_id']) && is_numeric($input['customer_id']) ? $input['customer_id'] : '';
        $valid['domain_id'] = isset($input['domain_id']) && is_numeric($input['domain_id']) ? $input['domain_id'] : '';
        $valid['script'] = esc_html($input['script']);
        $valid['image'] = esc_html($input['image']);
        $valid['style'] = esc_html($input['style']);

        return $valid;
    }

}
