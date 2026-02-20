<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Plugin Name:         All in One Accessibility
 * Plugin URI:          https://www.skynettechnologies.com/all-in-one-accessibility
 * Description:         A plugin to create ADA Accessibility
 * Version:             1.18
 * Requires at least:   4.9
 * Requires PHP:        7.0
 * Author:              Skynet Technologies USA LLC
 * Author URI:          https://www.skynettechnologies.com
 * License:             GPL v2 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 */

define( 'AIOA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );


$aioa_ada_widget_settings = (object) array();

add_action('admin_init', 'aioa_check_and_register_widget');
function aioa_check_and_register_widget() {
   // Only proceed if the option isn't set
    $position_option = get_option('position');
    if (!empty($position_option)) {
        return; // Already set, no need to call API
    }

    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$page = isset($_GET['page']) ? sanitize_text_field( wp_unslash( $_GET['page'] ) ) : '';

	if ($page !== 'ada-accessibility-info') {
		return;
	}


     // Get site details once
    $aioa_current_url_parse = wp_parse_url(get_site_url());
    $aioa_website_hostname = $aioa_current_url_parse['host'];
    $arr_details = array(
      'name'              => get_bloginfo('name'),
      'email'             => 'no-reply@' . $aioa_website_hostname,
      'company_name'      => get_bloginfo('name'),
      'website'           => base64_encode($aioa_website_hostname),
      'package_type'      => "free-widget",
      'start_date'        => gmdate('Y-m-d H:i:s'),
      'end_date'          => '',
      'price'             => '',
      'discount_price'    => '0',
      'platform'          => 'wordpress',
      'api_key'           => '',
      'is_trial_period'   => '',
      'is_free_widget'    => '1',
      'bill_address'      => '',
      'country'           => '',
      'state'             => '',
      'city'              => '',
      'post_code'         => '',
      'transaction_id'    => '',
      'subscr_id'         => '',
      'payment_source'    => '',
    );

    $aioa_url = 'https://ada.skynettechnologies.us/api/add-user-domain';
    $aioa_args = ['sslverify' => false, 'body' => $arr_details];
    $aioa_curl_result = wp_remote_post($aioa_url, $aioa_args);
    $body = wp_remote_retrieve_body($aioa_curl_result);
    $settingURLObject = json_decode($body);

}

add_action("admin_menu", "aioa_accessibility_menu");
if (!function_exists("aioa_accessibility_menu")) {
  function aioa_accessibility_menu()
  {
    $page_title = "All in One Accessibility Settings";
    $menu_title = "All in One Accessibility";
    $capability = "manage_options";
    $menu_slug = "ada-accessibility-info";
    $function = "AIOA_info_page";
    $icon_url = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNi4wLjMsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAxNiAxNiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMTYgMTY7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOiM5Q0EyQTc7fQ0KPC9zdHlsZT4NCjxnPg0KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik04LDNDNS4zLDMsMyw1LjIsMyw4czIuMiw1LDUsNXM1LTIuMiw1LTVTMTAuNywzLDgsM3ogTTgsNC4xYzAuNSwwLDAuOCwwLjQsMC44LDAuOFM4LjUsNS44LDgsNS44DQoJCVM3LjIsNS40LDcuMiw1QzcuMiw0LjUsNy41LDQuMSw4LDQuMXogTTEwLjYsNi41TDguNyw3LjFjLTAuMSwwLTAuMiwwLjEtMC4yLDAuMmMwLDAuMywwLDEsMC4xLDEuMmMwLjIsMC43LDEsMi42LDEsMi42DQoJCWMwLjEsMC4yLDAsMC41LTAuMiwwLjZjLTAuMSwwLTAuMSwwLTAuMiwwYy0wLjIsMC0wLjMtMC4xLTAuNC0wLjNMOCw5LjdsLTAuOSwxLjhjLTAuMSwwLjItMC4yLDAuMy0wLjQsMC4zYy0wLjEsMC0wLjEsMC0wLjIsMA0KCQljLTAuMi0wLjEtMC4zLTAuNC0wLjItMC42YzAsMCwwLjgtMS45LDEtMi42YzAuMS0wLjIsMC4xLTAuOSwwLjEtMS4yYzAtMC4xLTAuMS0wLjItMC4yLTAuMkw1LjQsNi41QzUuMiw2LjUsNSw2LjIsNS4xLDYNCgkJczAuMy0wLjMsMC42LTAuM2MwLDAsMS43LDAuNSwyLjMsMC41czIuMy0wLjYsMi4zLTAuNmMwLjItMC4xLDAuNSwwLjEsMC41LDAuM0MxMC45LDYuMiwxMC44LDYuNSwxMC42LDYuNXoiLz4NCgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNOCwwQzMuNiwwLDAsMy42LDAsOHMzLjYsOCw4LDhzOC0zLjYsOC04UzEyLjQsMCw4LDB6IE04LDE0Yy0zLjMsMC02LTIuNy02LTZzMi43LTYsNi02czYsMi43LDYsNg0KCQlTMTEuMywxNCw4LDE0eiIvPg0KPC9nPg0KPC9zdmc+DQo=";
    $position = 4;
    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
  }
  // Call AIOA_update_info function to update database
  add_action("admin_init", "aioa_register_plugin_settings");
}

function aioa_accessibility_admin_styles($hook) {
    // Example: Load only on plugin settings page
    if ($hook != 'toplevel_page_ada-accessibility-info') {
        return;
    }

    wp_enqueue_style(
        'aioa-accessibility-plugin-admin-style',
        plugin_dir_url(__FILE__) . 'css/aioa_accessibility_menu.css',
        array(),
        '1.0',
        'all'
    );
}
add_action('admin_enqueue_scripts', 'aioa_accessibility_admin_styles');


if (!function_exists("AIOA_info_page")) {
  function AIOA_info_page()
  {

    global $AutologinLink, $aioa_ada_widget_settings;
    wp_enqueue_script(
		"ADA_Accessibility_Validation_js",
		plugins_url("js/validation.js", __FILE__),
		array('jquery'),    // dependencies
		"1.16",    // version
		true                // load in footer
	);
	wp_enqueue_script(
	  "ADA_Accessibility_Color_js",
	  plugins_url("/js/jscolor.js", __FILE__),	
	  array(),
	  "2.5.2",
	  true
	);
    

    /*echo "<pre>";
        print_r($aioa_ada_widget_settings);
        echo "</pre>";*/

    $highlighted_color = get_option("highlight_color");
    $highlighted_color= $highlighted_color ? $highlighted_color : "#420083";

    if(!empty($aioa_ada_widget_settings->Data->widget_color_code))
    {
            $highlighted_color = $aioa_ada_widget_settings->Data->widget_color_code;
    }

    $position = get_option("position");
    $position = $position ? $position : "bottom_right";
   
    $extra_info_position_type = get_option("is_widget_custom_position");
    $extra_info_position_type = $extra_info_position_type ? $extra_info_position_type : "0";
    
    $extra_info_widget_size = get_option("widget_size");
    $extra_info_widget_size = $extra_info_widget_size ? $extra_info_widget_size : "0";
    
    $extra_info_icon_type = get_option("aioa_icon_type");
    $extra_info_icon_type = $extra_info_icon_type ? $extra_info_icon_type : "aioa-icon-type-1";
  
    $extra_info_icon_size = get_option("aioa_icon_size");
    $extra_info_icon_size = $extra_info_icon_size ? $extra_info_icon_size : "aioa-medium-icon";
   
    $widget_position_left = get_option("widget_position_left");
    $widget_position_left = $widget_position_left ? $widget_position_left : "0";
	

    $widget_position_right = get_option("widget_position_right");
    $widget_position_right = $widget_position_right ? $widget_position_right : "0";

    $widget_position_top = get_option("widget_position_top");
    $widget_position_top = $widget_position_top ? $widget_position_top : "";

    $widget_position_bottom = get_option("widget_position_bottom");
    $widget_position_bottom = $widget_position_bottom ? $widget_position_bottom : "";

    $is_widget_custom_size = get_option("is_widget_custom_size");
    $is_widget_custom_size = $is_widget_custom_size ? $is_widget_custom_size : "0";
    
    $widget_icon_size_custom = get_option("widget_icon_size_custom");
    $widget_icon_size_custom = $widget_icon_size_custom ? $widget_icon_size_custom : "";
  

    $protocols = array('http://', 'http://www.', 'www.', 'https://', 'https://www.');
    $store_url = str_replace($protocols, '', get_bloginfo('wpurl'));
?>

    <div class="aioa-widget-settigs-container">
      <div class="heading-wrapper">
        <p>All in One Accessibility widget improves website ADA compliance and browser experience for ADA, WCAG 2.1 &amp; 2.2, Section 508, California Unruh Act, Australian DDA, European EAA EN 301 549, UK Equality Act (EA), Israeli Standard 5568, Ontario AODA, Canada ACA, German BITV, France RGAA, Brazilian Inclusion Law (LBI 13.146/2015), Spain UNE 139803:2012, JIS X 8341 (Japan), Italian Stanca Act and Switzerland DDA Standards without changing your website's existing code.</p>
      </div>
      <form method="post" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" onsubmit="return validate_data()">

		  
		<?php wp_nonce_field('aioa_save_settings', 'aioa_nonce'); ?>
  

        <?php settings_fields("ada-accessibility-info-settings"); ?>

        <?php do_settings_sections("ada-accessibility-info-settings"); ?>

		<input type="hidden" name="action" value="AIOA_update_info">  
        <table class="form-table" style=" background:white; padding-left:30px;">
          <tr valign="top">
            <td>
              <h3>Pick a color for widget:</h3>
              <input type="text" class="jscolor" name="highlight_color" value="<?php echo esc_attr($highlighted_color); ?>" />
              <p>You can cutomize the ADA Widget color. For example: #FF5733</p>
            </td>
          </tr>
          <tr valign="top">
            <td>
              <h3>Select Position Type:</h3>
              <div class="form-radios">
                <div class="form-radio-item">
                  <input data-drupal-selector="edit-is-widget-custom-position-0" type="radio" <?php echo ($extra_info_position_type == "0" ? "checked" : ""); ?> id="edit-is-widget-custom-position-0" name="is_widget_custom_position" value="0" checked="checked" class="form-radio form-boolean form-boolean--type-radio" wfd-id="id3">
                  <label for="edit-is-widget-custom-position-0" class="form-item__label option">Fix Position</label>
                </div>
                <div class="form-radio-item">
                  <input data-drupal-selector="edit-is-widget-custom-position-1" type="radio" <?php echo ($extra_info_position_type == "1" ? "checked" : ""); ?> id="edit-is-widget-custom-position-1" name="is_widget_custom_position" value="1" class="form-radio form-boolean form-boolean--type-radio" wfd-id="id4">
                  <label for="edit-is-widget-custom-position-1" class="form-item__label option">Custom Position</label>
                </div>
              </div>
              <fieldset class="edit-is-widget-custom-position-0">
                <legend>Fixed Position Options</legend>
                <div class="fieldset-wrapper">
                  <select name="position" default="bottom_right">
                    <option value="top_left" <?php if ($position == "top_left") {
                                                echo "Selected";
                                              } ?>>Top left</option>
                    <option value="top_center" <?php if ($position == "top_center") {
                                                  echo "Selected";
                                                } ?>>Top center</option>
                    <option value="top_right" <?php if ($position == "top_right") {
                                                echo "Selected";
                                              } ?>>Top right</option>
                    <option value="middle_left" <?php if ($position == "middle_left") {
                                                  echo "Selected";
                                                } ?>>Middle left</option>
                    <option value="middle_right" <?php if ($position == "middle_right") {
                                                    echo "Selected";
                                                  } ?>>Middle right</option>
                    <option value="bottom_left" <?php if ($position == "bottom_left") {
                                                  echo "Selected";
                                                } ?>>Bottom left</option>
                    <option value="bottom_center" <?php if ($position == "bottom_center") {
                                                    echo "Selected";
                                                  } ?>>Bottom center</option>
                    <option value="bottom_right" <?php if ($position == "bottom_right") {
                                                    echo "Selected";
                                                  } ?>>Bottom right</option>
                  </select>
                </div>
              </fieldset>
			  <fieldset class="edit-is-widget-custom-position-1">
                <legend>Custom Postion Options</legend>
                <div class="fieldset-wrapper">
                  <div class="horizontal-container js-form-wrapper form-wrapper" data-drupal-selector="edit-horizontal" id="edit-horizontal" style="display: flex">
                    <div class="js-form-item form-item js-form-type-textfield form-type--textfield js-form-item-widget-position-left form-item--widget-position-left">
                      <label for="edit-widget-position-left" class="form-item__label">Horizontal (px)</label>
                      <input placeholder="Enter pixels" data-drupal-selector="edit-widget-position-left" type="text" id="edit-widget-position-left" name="widget_position_left" value="<?php echo esc_attr($widget_position_left); ?>" size="10" maxlength="128" class="form-text form-element form-element--type-text form-element--api-textfield" wfd-id="id13">
                    </div>
                    <div class="js-form-item form-item js-form-type-select form-type--select js-form-item-widget-position-top form-item--widget-position-top">
                      <label for="edit-widget-position-top" class="form-item__label">Position</label>
                      <select data-drupal-selector="edit-widget-position-top" id="edit-widget-position-top" name="widget_position_top" class="form-select form-element form-element--type-select">
                        <option value="" selected="selected">- Select -</option>
                        <option value="left" <?php echo ($widget_position_top == "left" ? "selected" : ""); ?>>to the Left</option>
                        <option value="right" <?php echo ($widget_position_top == "right" ? "selected" : ""); ?>>to the Right</option>
                      </select>
                    </div>
                  </div>
                  <div class="vertical-container js-form-wrapper form-wrapper" data-drupal-selector="edit-vertical" id="edit-vertical" style="display: flex">
                    <div class="js-form-item form-item js-form-type-textfield form-type--textfield js-form-item-widget-position-right form-item--widget-position-right">
                      <label for="edit-widget-position-right" class="form-item__label">Vertical (px)</label>
                      <input placeholder="Enter pixels" data-drupal-selector="edit-widget-position-right" type="text" id="edit-widget-position-right" name="widget_position_right" value="<?php echo esc_attr($widget_position_right); ?>" size="10" maxlength="128" class="form-text form-element form-element--type-text form-element--api-textfield" wfd-id="id14">
                    </div>
                    <div class="js-form-item form-item js-form-type-select form-type--select js-form-item-widget-position-bottom form-item--widget-position-bottom">
                      <label for="edit-widget-position-bottom" class="form-item__label">Position</label>
                      <select data-drupal-selector="edit-widget-position-bottom" id="edit-widget-position-bottom" name="widget_position_bottom" class="form-select form-element form-element--type-select">
                        <option value="" selected="selected">- Select -</option>
                        <option value="top" <?php echo ($widget_position_bottom == "top" ? "selected" : ""); ?>>to the Top</option>
                        <option value="bottom" <?php echo ($widget_position_bottom == "bottom" ? "selected" : ""); ?>>to the Bottom</option>
                      </select>
                    </div>
                  </div>
                </div>
              </fieldset>
          </tr>
          <tr valign="center">
            <td>
              <h3>Select Widget Size:</h3>
              <div class="form-radios">
                <div class="form-radio-item">
                  <input data-drupal-selector="edit-widget-size-regularsize" aria-describedby="edit-widget-size--description" <?php echo ($extra_info_widget_size == "0" ? "checked" : ""); ?> type="radio" id="edit-widget-size-regularsize" name="widget_size" value="0" checked="checked" class="form-radio form-boolean form-boolean--type-radio" wfd-id="id15">
                  <label for="edit-widget-size-regularsize" class="form-item__label option">Regular Size</label>
                </div>
                <div class="form-radio-item">
                  <input data-drupal-selector="edit-widget-size-oversize" aria-describedby="edit-widget-size--description" type="radio" <?php echo ($extra_info_widget_size == "1" ? "checked" : ""); ?> id="edit-widget-size-oversize" name="widget_size" value="1" class="form-radio form-boolean form-boolean--type-radio" wfd-id="id16">
                  <label for="edit-widget-size-oversize" class="form-item__label option">Oversize</label>
                </div>
                <div style="font-size: small;" id="edit-widget-size--wrapper--description" data-drupal-field-elements="description" class="fieldset__description">It only works on desktop view.</div>
              </div>
            </td>
          </tr>
          <tr valign="center">
            <td>
              <h3>Select Icon Type:</h3>
              <div class="icon-type-wrapper row">
                <div class="col-sm-12">
                  <div class="row" style="display:flex; align-items:center;">
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-1" <?php echo ($extra_info_icon_type == "aioa-icon-type-1" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-1" class="form-radio">
                        <label for="edit-type-1" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-1.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 1</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-2" <?php echo ($extra_info_icon_type == "aioa-icon-type-2" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-2" class="form-radio">
                        <label for="edit-type-2" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-2.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 2</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-3" <?php echo ($extra_info_icon_type == "aioa-icon-type-3" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-3" class="form-radio">
                        <label for="edit-type-3" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-3.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 3</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-4" <?php echo ($extra_info_icon_type == "aioa-icon-type-4" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-4" class="form-radio">
                        <label for="edit-type-4" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-4.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 4</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-5" <?php echo ($extra_info_icon_type == "aioa-icon-type-5" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-5" class="form-radio">
                        <label for="edit-type-5" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-5.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 5</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-6" <?php echo ($extra_info_icon_type == "aioa-icon-type-6" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-6" class="form-radio">
                        <label for="edit-type-6" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-6.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 6</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-7" <?php echo ($extra_info_icon_type == "aioa-icon-type-7" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-7" class="form-radio">
                        <label for="edit-type-7" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-7.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 7</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-8" <?php echo ($extra_info_icon_type == "aioa-icon-type-8" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-8" class="form-radio">
                        <label for="edit-type-8" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-8.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 8</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-9" <?php echo ($extra_info_icon_type == "aioa-icon-type-9" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-9" class="form-radio">
                        <label for="edit-type-9" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-9.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 9</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-10" <?php echo ($extra_info_icon_type == "aioa-icon-type-10" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-10" class="form-radio">
                        <label for="edit-type-10" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-10.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 10</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-11" <?php echo ($extra_info_icon_type == "aioa-icon-type-11" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-11" class="form-radio">
                        <label for="edit-type-11" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-11.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 11</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-12" <?php echo ($extra_info_icon_type == "aioa-icon-type-12" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-12" class="form-radio">
                        <label for="edit-type-12" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-12.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 12</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-13" <?php echo ($extra_info_icon_type == "aioa-icon-type-13" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-13" class="form-radio">
                        <label for="edit-type-13" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-13.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 13</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-14" <?php echo ($extra_info_icon_type == "aioa-icon-type-14" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-14" class="form-radio">
                        <label for="edit-type-14" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-14.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 14</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-15" <?php echo ($extra_info_icon_type == "aioa-icon-type-15" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-15" class="form-radio">
                        <label for="edit-type-15" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-15.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 15</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-16" <?php echo ($extra_info_icon_type == "aioa-icon-type-16" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-16" class="form-radio">
                        <label for="edit-type-16" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-16.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 16</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-17" <?php echo ($extra_info_icon_type == "aioa-icon-type-17" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-17" class="form-radio">
                        <label for="edit-type-17" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-17.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 17</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-18" <?php echo ($extra_info_icon_type == "aioa-icon-type-18" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-18" class="form-radio">
                        <label for="edit-type-18" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-18.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 18</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-19" <?php echo ($extra_info_icon_type == "aioa-icon-type-19" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-19" class="form-radio">
                        <label for="edit-type-19" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-19.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 19</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-20" <?php echo ($extra_info_icon_type == "aioa-icon-type-20" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-20" class="form-radio">
                        <label for="edit-type-20" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-20.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 20</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-21" <?php echo ($extra_info_icon_type == "aioa-icon-type-21" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-21" class="form-radio">
                        <label for="edit-type-21" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-21.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 21</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-22" <?php echo ($extra_info_icon_type == "aioa-icon-type-22" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-22" class="form-radio">
                        <label for="edit-type-22" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-22.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 22</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-23" <?php echo ($extra_info_icon_type == "aioa-icon-type-23" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-23" class="form-radio">
                        <label for="edit-type-23" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-23.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 23</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-24" <?php echo ($extra_info_icon_type == "aioa-icon-type-24" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-24" class="form-radio">
                        <label for="edit-type-24" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-24.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 24</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-25" <?php echo ($extra_info_icon_type == "aioa-icon-type-25" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-25" class="form-radio">
                        <label for="edit-type-25" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-25.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 25</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-26" <?php echo ($extra_info_icon_type == "aioa-icon-type-26" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-26" class="form-radio">
                        <label for="edit-type-26" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-26.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 26</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-27" <?php echo ($extra_info_icon_type == "aioa-icon-type-27" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-27" class="form-radio">
                        <label for="edit-type-27" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-27.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 27</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-28" <?php echo ($extra_info_icon_type == "aioa-icon-type-28" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-28" class="form-radio">
                        <label for="edit-type-28" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-28.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 28</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-29" <?php echo ($extra_info_icon_type == "aioa-icon-type-29" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-29" class="form-radio">
                        <label for="edit-type-29" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-29.svg' ); ?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 29</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr valign="center">
            <td>
              <h3>Widget Icon Size for Desktop:</h3>
              <div class="form-radios">
                <div id="edit-is-widget-custom-size" class="form-radio-item">
                  <div class="form-radio-item">
                    <input data-drupal-selector="edit-is-widget-custom-size-0" type="radio" id="edit-is-widget-custom-size-0" <?php echo ($is_widget_custom_size == "0" ? "checked" : ""); ?> name="is_widget_custom_size" value="0" checked="checked" class="form-radio form-boolean form-boolean--type-radio" wfd-id="id46">
                    <label for="edit-is-widget-custom-size-0" class="form-item__label option">Fixed Icon Size</label>
                  </div>
                  <div class="form-radio-item">
                    <input data-drupal-selector="edit-is-widget-custom-size-1" type="radio" id="edit-is-widget-custom-size-1" <?php echo ($is_widget_custom_size == "1" ? "checked" : ""); ?> name="is_widget_custom_size" value="1" class="form-radio form-boolean form-boolean--type-radio" wfd-id="id47">
                    <label for="edit-is-widget-custom-size-1" class="form-item__label option">Custom Icon Size</label>
                  </div>
                </div>
              </div>
            </td>
          </tr>
          <tr valign="center" class="edit-is-widget-custom-size-1" style="display: none;">
            <td>
              <h3>Custom Widget Icon Size for Desktop (px):</h3>
              <input data-drupal-selector="edit-widget-icon-size-custom" aria-describedby="edit-widget-icon-size-custom--description" type="number" id="edit-widget-icon-size-custom" name="widget_icon_size_custom" value="<?php echo esc_attr($widget_icon_size_custom); ?>" step="1" min="20" max="150" placeholder="20" size="10" class="form-number form-element form-element--type-number form-element--api-number">
              <div id="edit-widget-icon-size-custom--description" class="form-item__description" style="font-size: 14px;">
                20-150 px are recommended values.
              </div>
            </td>
          </tr>
          <tr valign="top" class="edit-is-widget-custom-size-0" style="display: none;">
            <td>
              <h3>Fixed Icon Size:</h3>
              <div class="icon-size-wrapper row ">
                <div class="col-sm-12">
                  <div class="row" style="display:flex;align-items:center;">
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-size-big" <?php echo ($extra_info_icon_size == "aioa-big-icon" ? "checked" : ""); ?> name="aioa_icon_size" value="aioa-big-icon" class="form-radio">
                        <label for="edit-size-big" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-1.svg')?>" loading="lazy" width="75" height="75" />
                          <span class="visually-hidden" style="display:none">Big</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-size-medium" <?php echo ($extra_info_icon_size == "aioa-medium-icon" ? "checked" : ""); ?> name="aioa_icon_size" value="aioa-medium-icon" class="form-radio">
                        <label for="edit-size-medium" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-1.svg')?>" loading="lazy" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Medium</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-size-default" <?php echo ($extra_info_icon_size == "aioa-default-icon" ? "checked" : ""); ?> name="aioa_icon_size" value="aioa-default-icon" class="form-radio">
                        <label for="edit-size-default" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-1.svg')?>" loading="lazy" width="55" height="55" />
                          <span class="visually-hidden" style="display:none">Default</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-size-small" <?php echo ($extra_info_icon_size == "aioa-small-icon" ? "checked" : ""); ?> name="aioa_icon_size" value="aioa-small-icon" class="form-radio">
                        <label for="edit-size-small" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-1.svg')?>" loading="lazy" width="45" height="45" />
                          <span class="visually-hidden" style="display:none">Small</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-size-extra-small" <?php echo ($extra_info_icon_size == "aioa-extra-small-icon" ? "checked" : ""); ?> name="aioa_icon_size" value="aioa-extra-small-icon" class="form-radio">
                        <label for="edit-size-extra-small" class="option">
                          <img src="<?php echo esc_url( AIOA_PLUGIN_URL . 'images/aioa-icon-type-1.svg')?>" loading="lazy" width="35" height="35" />
                          <span class="visually-hidden" style="display:none">Extra Small</span>
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </td>
          </tr>
        </table>
        <table>
          <tr>
            <td>
            <input type="hidden" name="aioa_settgins_form_submitted" value="1">
            <?php submit_button(); ?></td>
            <td>
              <?php /* if (isset($AutologinLink->link)) { ?>
                <p class="submit"><input style="border-color: chocolate;background: chocolate;" type="button" id="advance-settgins" class="button button-primary" value="Go to Advance Settings"></p>
                <script>
                  document.getElementById("advance-settgins").addEventListener("click", function() {
                    // URL to open
                    const url = "<?php echo $AutologinLink->link; ?>";

                    // Open the URL in a new tab
                    window.open(url, "_blank");
                  });
                </script>
                <?php } */ ?>
            </td>
          
          </tr>
        </table>

      </form>
    </div>

    <script>
      const sizeOptions = document.querySelectorAll('input[name="aioa_icon_size"]');
      const sizeOptionsImg = document.querySelectorAll('input[name="aioa_icon_size"] + label img');
      const typeOptions = document.querySelectorAll('input[name="aioa_icon_type"]');

      
      sizeOptionsImg.forEach(option2 => {
        var ico_type = <?php echo wp_json_encode( $extra_info_icon_type ); ?>;
        option2.setAttribute("src", "https://www.skynettechnologies.com/sites/default/files/" + ico_type + ".svg");
      });
    
      typeOptions.forEach(option => {
        option.addEventListener("click", (event) => {
          sizeOptionsImg.forEach(option2 => {
            var ico_type = document.querySelector('input[name="aioa_icon_type"]:checked').value;
            option2.setAttribute("src", "https://www.skynettechnologies.com/sites/default/files/" + ico_type + ".svg");
          });
        });
      });

      function position_options(a) {
        if (a == 0) {
          document.querySelector('.edit-is-widget-custom-position-1').style.display = "none";
          document.querySelector('.edit-is-widget-custom-position-0').style.display = "block";
        } else {

          document.querySelector('.edit-is-widget-custom-position-0').style.display = "none";
          document.querySelector('.edit-is-widget-custom-position-1').style.display = "block";
        }
      }
      position_options(document.querySelector('input[name="is_widget_custom_position"]:checked').value);
      const positionOptions = document.querySelectorAll('input[name="is_widget_custom_position"]');

      positionOptions.forEach(option => {
        option.addEventListener("click", (event) => {
          position_options(event.target.value);
          // Add your custom logic here
        });
      });


      function size_options(a) {
        if (a == 0) {
          document.querySelector('.edit-is-widget-custom-size-1').style.display = "none";
          document.querySelector('.edit-is-widget-custom-size-0').style.display = "block";
        } else {

          document.querySelector('.edit-is-widget-custom-size-0').style.display = "none";
          document.querySelector('.edit-is-widget-custom-size-1').style.display = "block";
        }
      }
      size_options(document.querySelector('input[name="is_widget_custom_size"]:checked').value);
      const widgetIconSizeOptions = document.querySelectorAll('input[name="is_widget_custom_size"]');

      widgetIconSizeOptions.forEach(option => {
        option.addEventListener("click", (event) => {
          size_options(event.target.value);
          // Add your custom logic here
        });
      });
    </script>

<?php
  }
}
if (!function_exists("aioa_register_plugin_settings")) {
  function aioa_register_plugin_settings()
  {

    
		register_setting(
			"ada-accessibility-info-settings",
			"highlight_color",
			array(
				"type" => "string",
				"sanitize_callback" => "sanitize_text_field",
			)
		);

		register_setting(
			"ada-accessibility-info-settings",
			"is_widget_custom_position",
			array(
				"type" => "boolean",
				"sanitize_callback" => "rest_sanitize_boolean",
			)
		);

		register_setting(
			"ada-accessibility-info-settings",
			"widget_size",
			array(
				"type" => "string",
				"sanitize_callback" => "sanitize_text_field",
			)
		);

		register_setting(
			"ada-accessibility-info-settings",
			"position",
			array(
				"type" => "string",
				"sanitize_callback" => "sanitize_text_field",
			)
		);

		register_setting(
			"ada-accessibility-info-settings",
			"aioa_icon_type",
			array(
				"type" => "string",
				"sanitize_callback" => "sanitize_text_field",
			)
		);

		register_setting(
			"ada-accessibility-info-settings",
			"aioa_icon_size",
			array(
				"type" => "string",
				"sanitize_callback" => "sanitize_text_field",
			)
		);

		register_setting(
			"ada-accessibility-info-settings",
			"widget_position_left",
			array(
				"type" => "string",
				"sanitize_callback" => "sanitize_text_field",
			)
		);

		register_setting(
			"ada-accessibility-info-settings",
			"widget_position_right",
			array(
				"type" => "integer",
				"sanitize_callback" => "absint",
			)
		);

		register_setting(
			"ada-accessibility-info-settings",
			"widget_position_top",
			array(
				"type" => "string",
				"sanitize_callback" => "sanitize_text_field",
			)
		);

		register_setting(
			"ada-accessibility-info-settings",
			"widget_position_bottom",
			array(
				"type" => "string",
				"sanitize_callback" => "sanitize_text_field",
			)
		);

		register_setting(
			"ada-accessibility-info-settings",
			"is_widget_custom_size",
			array(
				"type" => "boolean",
				"sanitize_callback" => "rest_sanitize_boolean",
			)
		);

		register_setting(
			"ada-accessibility-info-settings",
			"widget_icon_size_custom",
			array(
				"type" => "string",
				"sanitize_callback" => "sanitize_text_field",
			)
		);

  }
}


add_action('admin_post_AIOA_update_info', 'AIOA_update_info');

function AIOA_update_info() {
	
	// ✅ Capability check
    if ( ! current_user_can('manage_options') ) {
        wp_die('Unauthorized access');
    }

   // Check nonce
    if ( ! isset( $_POST['aioa_nonce'] ) || 
         ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['aioa_nonce'] ) ), 'aioa_save_settings' ) ) {
        wp_die( 'Security check failed' );
    }
	
	// Save options safely
	
	if ( isset( $_POST['highlight_color'] ) ) {
		update_option( 'highlight_color', sanitize_text_field( wp_unslash( $_POST['highlight_color'] ) ) );
	}

	if ( isset( $_POST['is_widget_custom_position'] ) ) {
		update_option( 'is_widget_custom_position', sanitize_text_field( wp_unslash( $_POST['is_widget_custom_position'] ) ) );
	}

	if ( isset( $_POST['widget_size'] ) ) {
		update_option( 'widget_size', sanitize_text_field( wp_unslash( $_POST['widget_size'] ) ) );
	}

	if ( isset( $_POST['position'] ) ) {
		update_option( 'position', sanitize_text_field( wp_unslash( $_POST['position'] ) ) );
	}

	if ( isset( $_POST['aioa_icon_type'] ) ) {
		update_option( 'aioa_icon_type', sanitize_text_field( wp_unslash( $_POST['aioa_icon_type'] ) ) );
	}

	if ( isset( $_POST['aioa_icon_size'] ) ) {
		update_option( 'aioa_icon_size', sanitize_text_field( wp_unslash( $_POST['aioa_icon_size'] ) ) );
	}

	if ( isset( $_POST['widget_position_left'] ) ) {
		update_option( 'widget_position_left', sanitize_text_field( wp_unslash( $_POST['widget_position_left'] ) ) );
	}

	if ( isset( $_POST['widget_position_right'] ) ) {
		update_option( 'widget_position_right', sanitize_text_field( wp_unslash( $_POST['widget_position_right'] ) ) );
	}

	if ( isset( $_POST['widget_position_top'] ) ) {
		update_option( 'widget_position_top', sanitize_text_field( wp_unslash( $_POST['widget_position_top'] ) ) );
	}

	if ( isset( $_POST['widget_position_bottom'] ) ) {
		update_option( 'widget_position_bottom', sanitize_text_field( wp_unslash( $_POST['widget_position_bottom'] ) ) );
	}

	if ( isset( $_POST['is_widget_custom_size'] ) ) {
		update_option( 'is_widget_custom_size', sanitize_text_field( wp_unslash( $_POST['is_widget_custom_size'] ) ) );
	}

	if ( isset( $_POST['widget_icon_size_custom'] ) ) {
		update_option( 'widget_icon_size_custom', sanitize_text_field( wp_unslash( $_POST['widget_icon_size_custom'] ) ) );
	}
	
	



     /* Start Save widget Settings on Dashboard */


        global $aioa_ada_widget_settings;

        $extra_info_high_link = get_option("highlight_color") ? get_option("highlight_color") : (!empty($aioa_ada_widget_settings->Data->widget_color_code) ? $aioa_ada_widget_settings->Data->widget_color_code :"f15a22");
        $extra_info_position = get_option("position") ? get_option("position") : "bottom_right";
        $extra_info_position_type = get_option("is_widget_custom_position") ? get_option("is_widget_custom_position") : "0";
        $extra_info_icon_type = get_option("aioa_icon_type") ? get_option("aioa_icon_type") : "aioa-icon-type-1";
        $extra_info_icon_size = get_option("aioa_icon_size") ? get_option("aioa_icon_size") : "aioa-medium-icon";
        $extra_info_widget_size = get_option("widget_size") ? get_option("widget_size") : "0";
        $widget_position_left = get_option("widget_position_top") && get_option("widget_position_top") == "left" ? get_option("widget_position_left") : "";
        $widget_position_right = get_option("widget_position_top") && get_option("widget_position_top") == "right" ? get_option("widget_position_left") : "";
        $widget_position_top = get_option("widget_position_bottom") && get_option("widget_position_bottom") == "top" ? get_option("widget_position_right") : "";
        $widget_position_bottom = get_option("widget_position_bottom") && get_option("widget_position_bottom") == "bottom" ? get_option("widget_position_right") : "";
        $is_widget_custom_size = get_option("is_widget_custom_size") ? get_option("is_widget_custom_size") : "0";
        $widget_icon_size_custom = get_option("widget_icon_size_custom") ? get_option("widget_icon_size_custom") : "";

        $postdata = [
          'u' => get_home_url(),
          'widget_position' => $extra_info_position,
          'widget_color_code' => $extra_info_high_link,
          //'statement_link' => (!empty($values['statement_link']) ? $values['statement_link'] : ""),
          'widget_size' => $extra_info_widget_size,
          'widget_icon_type' => $extra_info_icon_type,
          'widget_icon_size' => $extra_info_icon_size,
          //'widget_icon_size_mobile' => (!empty($values['aioa_icon_sizes']) ? $values['aioa_icon_sizes'] : "aioa-medium-icon"),
          //'is_widget_custom_size_mobile' => (!empty($values['is_widget_custom_size_mobile']) ? $values['is_widget_custom_size_mobile'] : "0"),
          'is_widget_custom_size' => $is_widget_custom_size,
          'widget_icon_size_custom' => $widget_icon_size_custom,
          //'widget_icon_size_custom_mobile' => (!empty($values['widget_icon_size_custom_mobile']) ? $values['widget_icon_size_custom_mobile'] : ""),
          'is_widget_custom_position' => $extra_info_position_type,
          'widget_position_left' => $widget_position_left,
          'widget_position_top' => $widget_position_top,
          'widget_position_right' => $widget_position_right,
          'widget_position_bottom' => $widget_position_bottom,

        ];
	
		///add JS

        $args = array('postdata' => $postdata);
        $url = 'https://ada.skynettechnologies.us/api/widget-setting-update-platform';
        $args = ['sslverify' => false, 'body' => $postdata];
        $result = wp_remote_post($url, $args);
        $resp = (object)json_decode(wp_remote_retrieve_body($result), true);


		// Redirect to admin page after saving settings
		wp_safe_redirect( admin_url( 'admin.php?page=ada-accessibility-info&status=updated' ) );


		
        //print_r($resp);
        /* End Save widget Settings on Dashboard */
   

  
}
function aioa_admin_notice() {

    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$status = isset( $_GET['status'] ) ? sanitize_text_field( wp_unslash( $_GET['status'] ) ) : '';

    if ( $status === 'updated' ) {
        ?>
        <div class="notice notice-success is-dismissible">
            <p><?php esc_html_e( 'Settings saved successfully.', 'all-in-one-accessibility' ); ?></p>
        </div>
        <?php
    }
}

add_action( 'admin_notices', 'aioa_admin_notice' );


function AIOA_add()
{
  
  global $AutologinLink, $aioa_ada_widget_settings;

  
 
  $extra_info_high_link = get_option("highlight_color") ? get_option("highlight_color") :  (!empty($aioa_ada_widget_settings->Data->widget_color_code) ? $aioa_ada_widget_settings->Data->widget_color_code :"f15a22");
  $extra_info_position = get_option("position") ? get_option("position") : "bottom_right";
  //$extra_info_widget_size = get_option("widget_size") ? get_option("widget_size") : "regularsize";
  //$extra_info_position_type = get_option("is_widget_custom_position") ? get_option("is_widget_custom_position") : "0";
  $extra_info_icon_type = get_option("aioa_icon_type") ? get_option("aioa_icon_type") : "aioa-icon-type-1";
  $extra_info_icon_size = get_option("aioa_icon_size") ? get_option("aioa_icon_size") : "aioa-medium-icon";
  //$widget_position_left = get_option("widget_position_left") ? get_option("widget_position_left") : "";
  //$widget_position_right = get_option("widget_position_right") ? get_option("widget_position_right") : "";
  //$widget_position_top = get_option("widget_position_top") ? get_option("widget_position_top") : "";
  //$widget_position_bottom = get_option("widget_position_bottom") ? get_option("widget_position_bottom") : "";
  //$is_widget_custom_size = get_option("is_widget_custom_size") ? get_option("is_widget_custom_size") : "0";

  $activeColor = "#" . $extra_info_high_link;
  
  $baseURL = "https://www.skynettechnologies.com/accessibility/js/accessibility-loader.js";
	

  //$ADAC_args = ["colorcode" => str_replace("#", "", $activeColor), "t" => wp_rand(1, 10000000), "position" => $extra_info_position . "." . $extra_info_icon_type . "." . $extra_info_icon_size];
  $ADAC_args = ["colorcode" => str_replace("#", "", $activeColor)];
  if (!is_admin()) {  
    //wp_enqueue_script("aioa-adawidget", add_query_arg($ADAC_args, $baseURL), [], '1.0.0', true);
	//wp_enqueue_script('adajs',add_query_arg($ADAC_args, $baseURL),[],'1.0.0', true);  
	wp_enqueue_script('adajs', $baseURL, [], '1.0.0', true);  
  }
}
add_filter("script_loader_tag", function ($tag, $handle) {
  if ("adajs" !== $handle) {
    return $tag;
  }
  return str_replace(" src", " type='module' defer src", $tag); // defer the script

}, 10, 2);
//add_action('wp_body_open', 'AIOA_add');

add_action("wp_head", "AIOA_add");

function AIOA_deactivation()
{
  
  $highlight_color = "highlight_color";
  $position = "position";
  delete_option($highlight_color);
  delete_option($position);
  delete_option("is_widget_custom_position");
  delete_option("widget_size");
  delete_option("aioa_icon_type");
  delete_option("aioa_icon_size");
  delete_option("widget_position_left");
  delete_option("widget_position_right");
  delete_option("widget_position_top");
  delete_option("widget_position_bottom");
  delete_option("widget_icon_size_custom");
  delete_option("is_widget_custom_size");
}
register_deactivation_hook(__FILE__, "AIOA_deactivation");
?>