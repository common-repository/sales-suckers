<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.sales-suckers.com
 * @since      1.0.0
 *
 * @package    Salessuckers
 * @subpackage Salessuckers/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Salessuckers
 * @subpackage Salessuckers/public
 * @author     Sales-Suckers <hello@sales-suckers.com>
 */
class Salessuckers_Public
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    public function head()
    {
        $data = get_option($this->plugin_name);
        if (!isset($data['in_footer']) || empty($data['in_footer'])) {
            echo isset($data['script']) ? $this->decode($data['script']) : '';
            echo isset($data['style']) ? $this->decode($data['style']) : '';
		}
    }
    public function footer()
    {
        $data = get_option($this->plugin_name);
        if (isset($data['in_footer']) && !empty($data['in_footer'])) {
            echo isset($data['script']) ? $this->decode($data['script']) : '';
            echo isset($data['image']) ? $this->decode($data['image']) : '';
		}

	}
	
	public function decode($code) {
		//str_replace("&#039;", "'"
		$code = html_entity_decode(str_replace("&#039;", "'", $code));
		return $code;
	}

}
