<?php

/**
 * Plugin Name:         All in One Accessibility
 * Plugin URI:          https://www.skynettechnologies.com/all-in-one-accessibility
 * Description:         A plugin to create ADA Accessibility
 * Version:             1.9
 * Requires at least:   4.9
 * Requires PHP:        7.0
 * Author:              Skynet Technologies USA LLC
 * Author URI:          https://www.skynettechnologies.com
 * License:             GPL v2 or later
 * License URI:         https://www.gnu.org/licenses/gpl-2.0.html
 */

if (is_admin()){
  $aioa_current_url_parse = parse_url(get_site_url());
  $aioa_website_hostname = $aioa_current_url_parse['host'];

  $aioa_url = 'https://ada.skynettechnologies.us/api/get-autologin-link';
  $aioa_args = ['sslverify' => false, 'body' => array('website' => "'" . base64_encode($aioa_website_hostname) . "'")];
  $aioa_curl_result = wp_remote_post($aioa_url, $aioa_args);
  $AutologinLink = (object)json_decode(wp_remote_retrieve_body($aioa_curl_result), true);

  $widget_settings = (object) array();

  if ($AutologinLink->status == 0) {
    $aioa_current_url_parse = parse_url(get_site_url());
    $aioa_website_hostname = $aioa_current_url_parse['host'];

    $package_type = "free-widget";

    $arr_details = array(
      'name'              => get_bloginfo('name'),
      'email'             => get_bloginfo('admin_email'),
      'company_name'      => get_bloginfo('name'),
      'website'           => base64_encode($aioa_website_hostname),
      'package_type'      => $package_type,
      'start_date'        => date('Y-m-d H:i:s'),
      'end_date'          => '',
      'price'             => '',
      'discount_price'    => '0',
      'platform'           => 'wordpress',
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
    $settingURLObject = (object)json_decode(wp_remote_retrieve_body($aioa_curl_result), true);


    $aioa_url = 'https://ada.skynettechnologies.us/api/get-autologin-link';
    $aioa_args = ['sslverify' => false, 'body' => array('website' =>  base64_encode($aioa_website_hostname))];
    $aioa_curl_result = wp_remote_post($aioa_url, $aioa_args);
    $AutologinLink = (object)json_decode(wp_remote_retrieve_body($aioa_curl_result), true);


    $aioa_url = 'https://ada.skynettechnologies.us/api/widget-settings-platform';
    $aioa_args = ['sslverify' => false, 'body' => array('website_url' => $aioa_website_hostname)];
    $aioa_curl_result = wp_remote_post($aioa_url, $aioa_args);
    //print_r($aioa_curl_result);
    $widget_settings1 = (object)json_decode(wp_remote_retrieve_body($aioa_curl_result), true);
    $widget_settings->Data = (object) $widget_settings1->Data;
  } else {


    $aioa_url = 'https://ada.skynettechnologies.us/api/widget-settings-platform';
    $aioa_args = ['sslverify' => false, 'body' => array('website_url' => $aioa_website_hostname)];
    $aioa_curl_result = wp_remote_post($aioa_url, $aioa_args);
    //print_r($aioa_curl_result);
    $widget_settings1 = (object)json_decode(wp_remote_retrieve_body($aioa_curl_result), true);
    $widget_settings->Data = (object) $widget_settings1->Data;
    
  }
}


add_action("admin_menu", "ada_accessibility_menu");
if (!function_exists("ada_accessibility_menu")) {
  function ada_accessibility_menu()
  {
    $page_title = "All in One Accessibility Settings";
    $menu_title = "All in One Accessibility";
    $capability = "manage_options";
    $menu_slug = "ada-accessibility-info";
    $function = "ADAC_info_page";
    $icon_url = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyNi4wLjMsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAxNiAxNiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgMTYgMTY7IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+DQoJLnN0MHtmaWxsOiM5Q0EyQTc7fQ0KPC9zdHlsZT4NCjxnPg0KCTxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik04LDNDNS4zLDMsMyw1LjIsMyw4czIuMiw1LDUsNXM1LTIuMiw1LTVTMTAuNywzLDgsM3ogTTgsNC4xYzAuNSwwLDAuOCwwLjQsMC44LDAuOFM4LjUsNS44LDgsNS44DQoJCVM3LjIsNS40LDcuMiw1QzcuMiw0LjUsNy41LDQuMSw4LDQuMXogTTEwLjYsNi41TDguNyw3LjFjLTAuMSwwLTAuMiwwLjEtMC4yLDAuMmMwLDAuMywwLDEsMC4xLDEuMmMwLjIsMC43LDEsMi42LDEsMi42DQoJCWMwLjEsMC4yLDAsMC41LTAuMiwwLjZjLTAuMSwwLTAuMSwwLTAuMiwwYy0wLjIsMC0wLjMtMC4xLTAuNC0wLjNMOCw5LjdsLTAuOSwxLjhjLTAuMSwwLjItMC4yLDAuMy0wLjQsMC4zYy0wLjEsMC0wLjEsMC0wLjIsMA0KCQljLTAuMi0wLjEtMC4zLTAuNC0wLjItMC42YzAsMCwwLjgtMS45LDEtMi42YzAuMS0wLjIsMC4xLTAuOSwwLjEtMS4yYzAtMC4xLTAuMS0wLjItMC4yLTAuMkw1LjQsNi41QzUuMiw2LjUsNSw2LjIsNS4xLDYNCgkJczAuMy0wLjMsMC42LTAuM2MwLDAsMS43LDAuNSwyLjMsMC41czIuMy0wLjYsMi4zLTAuNmMwLjItMC4xLDAuNSwwLjEsMC41LDAuM0MxMC45LDYuMiwxMC44LDYuNSwxMC42LDYuNXoiLz4NCgk8cGF0aCBjbGFzcz0ic3QwIiBkPSJNOCwwQzMuNiwwLDAsMy42LDAsOHMzLjYsOCw4LDhzOC0zLjYsOC04UzEyLjQsMCw4LDB6IE04LDE0Yy0zLjMsMC02LTIuNy02LTZzMi43LTYsNi02czYsMi43LDYsNg0KCQlTMTEuMywxNCw4LDE0eiIvPg0KPC9nPg0KPC9zdmc+DQo=";
    $position = 4;
    add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
  }
  // Call update_ADAC_info function to update database
  add_action("admin_init", "update_ADAC_info");
}

if (!function_exists("ADAC_info_page")) {
  function ADAC_info_page()
  {

    global $AutologinLink, $widget_settings;
    wp_enqueue_script("ADA_Accessibility_Validation_js", plugins_url("js/validation.js", __FILE__));
    wp_enqueue_script("ADA_Accessibility_Color_js", plugins_url("/js/jscolor.js", __FILE__));
    $userid = get_option("userid") ? get_option("userid") : "";
    if(!empty($widget_settings->Data->api_key) && isset($AutologinLink->link) && $AutologinLink->status == 1){
      $userid = $widget_settings->Data->api_key;
    }

    /*echo "<pre>";
        print_r($widget_settings);
        echo "</pre>";*/

    $highlighted_color = get_option("highlight_color") ? get_option("highlight_color") : "#f15a22";
    if(!empty($widget_settings->Data->widget_color_code))
    {
            $highlighted_color = $widget_settings->Data->widget_color_code;
    }

    $position = get_option("position") ? get_option("position") : "bottom_right";
    /*if(!empty($widget_settings->Data->widget_position))
        {
            $position = $widget_settings->Data->widget_position;
    }*/

    $extra_info_position_type = get_option("is_widget_custom_position") ? get_option("is_widget_custom_position") : "0";
    /*if(!empty($widget_settings->Data->is_widget_custom_position))
        {
            $extra_info_position_type = $widget_settings->Data->is_widget_custom_position;
        }*/

    $extra_info_widget_size = get_option("widget_size") ? get_option("widget_size") : "regularsize";
    /*if(!empty($widget_settings->Data->widget_size))
        {
            $extra_info_widget_size = $widget_settings->Data->widget_size;
        }*/

    $extra_info_icon_type = get_option("aioa_icon_type") ? get_option("aioa_icon_type") : "aioa-icon-type-1";
    /*if(!empty($widget_settings->Data->widget_icon_type))
        {
            $extra_info_icon_type = $widget_settings->Data->widget_icon_type;
        }*/

    $extra_info_icon_size = get_option("aioa_icon_size") ? get_option("aioa_icon_size") : "aioa-medium-icon";
    /*if(!empty($widget_settings->Data->widget_icon_size))
        {
            $extra_info_icon_size = $widget_settings->Data->widget_icon_size;
        }*/

    $widget_position_left = get_option("widget_position_left") ? get_option("widget_position_left") : "";

    $widget_position_right = get_option("widget_position_right") ? get_option("widget_position_right") : "";
    $widget_position_top = get_option("widget_position_top") ? get_option("widget_position_top") : "";
    $widget_position_bottom = get_option("widget_position_bottom") ? get_option("widget_position_bottom") : "";

    /*if(!empty($widget_settings->Data->widget_position_left))
        {
            $widget_position_left = $widget_settings->Data->widget_position_left;
        }
        if(!empty($widget_settings->Data->widget_position_right))
        {
            $widget_position_right = $widget_settings->Data->widget_position_right;
        }
        if(!empty($widget_settings->Data->widget_position_top))
        {
            $widget_position_top = $widget_settings->Data->widget_position_top;
        }
        if(!empty($widget_settings->Data->widget_position_bottom))
        {
            $widget_position_bottom = $widget_settings->Data->widget_position_bottom;
        }*/

    $is_widget_custom_size = get_option("is_widget_custom_size") ? get_option("is_widget_custom_size") : "0";
    /* if(!empty($widget_settings->Data->is_widget_custom_size))
        {
            $is_widget_custom_size = $widget_settings->Data->is_widget_custom_size;
        }*/

    $widget_icon_size_custom = get_option("widget_icon_size_custom") ? get_option("widget_icon_size_custom") : "";
    /*if(!empty($widget_settings->Data->widget_icon_size_custom))
        {
            $widget_icon_size_custom = $widget_settings->Data->widget_icon_size_custom;
        }*/

    $protocols = array('http://', 'http://www.', 'www.', 'https://', 'https://www.');
    $store_url = str_replace($protocols, '', get_bloginfo('wpurl'));
?>

    <style>
      [type="radio"]:checked,
      [type="radio"]:not(:checked) {
        position: absolute;
        left: -9999px;
      }

      [type="radio"]:checked+label,
      [type="radio"]:not(:checked)+label {
        position: relative;
        padding-left: 28px;
        cursor: pointer;
        line-height: 20px;
        display: inline-block;
        color: #000;
      }

      [type="radio"]:checked+label:before,
      [type="radio"]:not(:checked)+label:before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 18px;
        height: 18px;
        border: 1px solid #ced4da;
        border-radius: 100%;
        background: #fff;
      }

      [type="radio"]:checked+label:after,
      [type="radio"]:not(:checked)+label:after {
        content: "";
        width: 10px;
        height: 10px;
        background: #420083;
        position: absolute;
        top: 5px;
        left: 5px;
        border-radius: 100%;
        -webkit-transition: all 0.2s ease;
        transition: all 0.2s ease;
      }

      [type="radio"]:not(:checked)+label:after {
        opacity: 0;
        -webkit-transform: scale(0);
        transform: scale(0);
      }

      [type="radio"]:checked+label:after {
        opacity: 1;
        -webkit-transform: scale(1);
        transform: scale(1);
      }

      .col-form-label {
        font-weight: bold;
      }

      .icon-size-wrapper .option,
      .icon-type-wrapper .option {
        width: 130px;
        height: 130px;
        padding: 10px !important;
        text-align: center;
        background-color: #fff;
        outline: 4px solid #fff;
        outline-offset: -4px;
        border-radius: 10px;
      }

      .icon-size-wrapper .option::after,
      .icon-type-wrapper .option::after {
        content: none !important;
        display: none !important;
      }

      .icon-size-wrapper .option img,
      .icon-type-wrapper .option img {
        position: relative;
        top: 50%;
        transform: translateY(-50%);
      }

      .icon-size-wrapper input[type="radio"]:not(:checked)+label::before,
      .icon-type-wrapper input[type="radio"]:not(:checked)+label::before {
        content: none;
        display: none;
      }

      .icon-size-wrapper input[type="radio"]:checked+label,
      .icon-type-wrapper input[type="radio"]:checked+label {
        outline-color: #80c944;
      }

      .icon-size-wrapper input[type="radio"]:checked+label::before,
      .icon-type-wrapper input[type="radio"]:checked+label::before {
        content: "";
        width: 20px;
        height: 20px;
        position: absolute;
        left: auto;
        right: -4px;
        top: -4px;
        background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 25 25' class='aioa-feature-on'%3E%3Cg%3E%3Ccircle fill='%2343A047' cx='12.5' cy='12.5' r='12'%3E%3C/circle%3E%3Cpath fill='%23FFFFFF' d='M12.5,1C18.9,1,24,6.1,24,12.5S18.9,24,12.5,24S1,18.9,1,12.5S6.1,1,12.5,1 M12.5,0C5.6,0,0,5.6,0,12.5S5.6,25,12.5,25S25,19.4,25,12.5S19.4,0,12.5,0L12.5,0z'%3E%3C/path%3E%3C/g%3E%3Cpolygon fill='%23FFFFFF' points='9.8,19.4 9.8,19.4 9.8,19.4 4.4,13.9 7.1,11.1 9.8,13.9 17.9,5.6 20.5,8.4 '%3E%3C/polygon%3E%3C/svg%3E") no-repeat center center/contain !important;
        border: none;
      }

      .save-changes-btn {
        text-align: center;
      }

      .save-changes-btn .btn {
        border-radius: 0.36rem;
        padding: 10px 22px;
      }

      table tr td>h3 {
        margin-top: 0;
        margin-bottom: 10px;
      }

      .heading-wrapper p {
        font-size: 16px;
      }

      fieldset {
        border: 1px solid #c0c0c0;
        position: relative;
        min-width: 0;
        margin-top: 1em;
        padding: 40px 18px 20px 18px;
        border-radius: 2px;

        >legend {
          position: absolute;
          top: 10px;
          font-weight: bold;
        }
      }

      .form-radios .form-radio-item {
        margin-bottom: 10px;
      }
    </style>

    <h1>All in One Accessibility® Settings</h1>
    <hr>
    <style>
      .get-strated-btn,
      .get-strated-btn:hover {
        background-color: #2855d3;
        color: white;
        padding: 5px 5px;
        text-decoration: none;
      }

      .aioa-cancel-button {
        text-decoration: none;
        display: inline-block;
        vertical-align: middle;
        border: 2px solid #dd2755;
        border-radius: 4px 4px 4px 4px;
        background-color: #ea2362;
        box-shadow: 0px 0px 2px 0px #333333;
        color: #ffffff;
        text-align: center;
        box-sizing: border-box;
        padding: 10px;
      }

      .aioa-cancel-button:hover {
        border-color: #e21f4a;
        background-color: white;
        box-shadow: 0px 0px 2px 0px #333333;
      }

      .aioa-cancel-button:hover .mb-text {
        color: #e82757;
      }

      .icon-type-wrapper .row label,
      .icon-size-wrapper .row label {
        background: #211f1f;
      }

      .icon-type-wrapper .row {
        flex-wrap: wrap;
      }

      .horizontal-container,
      .vertical-container {
        display: flex;
        flex-wrap: wrap;
        column-gap: 20px;
        color: black;

      }

      .horizontal-container div,
      .vertical-container div {
        min-width: 150px;
        margin-top: 0;
      }

      .horizontal-container label,
      .vertical-container label {
        display: block !important;
      }

      .horizontal-container select,
      .horizontal-container input,
      .vertical-container select,
      .vertical-container input {
        width: 100%;
      }

      .horizontal-container label,
      .horizontal-container input,
      .horizontal-container select .vertical-container label,
      .vertical-container input,
      .vertical-container select {
        display: block;
      }
    </style>
    <div class="aioa-widget-settigs-container">
      <div class="heading-wrapper">
        <p>All in One Accessibility widget improves website ADA compliance and browser experience for ADA, WCAG 2.1 &amp; 2.2, Section 508, California Unruh Act, Australian DDA, European EAA EN 301 549, UK Equality Act (EA), Israeli Standard 5568, Ontario AODA, Canada ACA, German BITV, France RGAA, Brazilian Inclusion Law (LBI 13.146/2015), Spain UNE 139803:2012, JIS X 8341 (Japan), Italian Stanca Act and Switzerland DDA Standards without changing your website's existing code.</p>
      </div>
      <form method="post" action="options.php" onSubmit="return validate_data()">

        <?php settings_fields("ada-accessibility-info-settings"); ?>

        <?php do_settings_sections("ada-accessibility-info-settings"); ?>

        <table class="form-table" style=" background:white; padding-left:30px;">
          <tr valign="top">
            <td>
              <h3>License key required for full version:</h3>
              <input type="text" name="userid" value="<?php echo esc_attr($userid); ?>" size=60 />
              <?php
              
              if ($userid == "") { ?>
                <p>Please <a href="https://www.skynettechnologies.com/add-ons/product/all-in-one-accessibility-pro/?attribute_package-name=Medium+Site+%28100K+Page+Views%2Fmo%29&attribute_subscription=1+Year&utm_source=<?php echo $store_url; ?>&utm_medium=wordpress-module&&utm_campaign=purchase-plan">Upgrade</a> to paid version of All in One Accessibility®.</p>
              <?php } ?>
            </td>
          </tr>
          <tr valign="top">
            <td>
              <h3>Pick a color for widget:</h3>
              <input type="text" class="jscolor" name="highlight_color" value="<?php echo esc_attr($highlighted_color); ?>" />
              <p>You can cutomize the ADA Widget color. For example: FF5733</p>
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
                    <option value="mideel_left" <?php if ($position == "mideel_left") {
                                                  echo "Selected";
                                                } ?>>Middle left</option>
                    <option value="middel_right" <?php if ($position == "middel_right") {
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
                  <input data-drupal-selector="edit-widget-size-regularsize" aria-describedby="edit-widget-size--description" <?php echo ($extra_info_widget_size == "regularsize" ? "checked" : ""); ?> type="radio" id="edit-widget-size-regularsize" name="widget_size" value="regularsize" checked="checked" class="form-radio form-boolean form-boolean--type-radio" wfd-id="id15">
                  <label for="edit-widget-size-regularsize" class="form-item__label option">Regular Size</label>
                </div>
                <div class="form-radio-item">
                  <input data-drupal-selector="edit-widget-size-oversize" aria-describedby="edit-widget-size--description" type="radio" <?php echo ($extra_info_widget_size == "oversize" ? "checked" : ""); ?> id="edit-widget-size-oversize" name="widget_size" value="oversize" class="form-radio form-boolean form-boolean--type-radio" wfd-id="id16">
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
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-1.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 1</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-2" <?php echo ($extra_info_icon_type == "aioa-icon-type-2" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-2" class="form-radio">
                        <label for="edit-type-2" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-2.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 2</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-3" <?php echo ($extra_info_icon_type == "aioa-icon-type-3" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-3" class="form-radio">
                        <label for="edit-type-3" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-3.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 3</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-4" <?php echo ($extra_info_icon_type == "aioa-icon-type-4" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-4" class="form-radio">
                        <label for="edit-type-4" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-4.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 4</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-5" <?php echo ($extra_info_icon_type == "aioa-icon-type-5" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-5" class="form-radio">
                        <label for="edit-type-5" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-5.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 5</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-6" <?php echo ($extra_info_icon_type == "aioa-icon-type-6" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-6" class="form-radio">
                        <label for="edit-type-6" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-6.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 6</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-7" <?php echo ($extra_info_icon_type == "aioa-icon-type-7" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-7" class="form-radio">
                        <label for="edit-type-7" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-7.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 7</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-8" <?php echo ($extra_info_icon_type == "aioa-icon-type-8" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-8" class="form-radio">
                        <label for="edit-type-8" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-8.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 8</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-9" <?php echo ($extra_info_icon_type == "aioa-icon-type-9" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-9" class="form-radio">
                        <label for="edit-type-9" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-9.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 9</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-10" <?php echo ($extra_info_icon_type == "aioa-icon-type-10" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-10" class="form-radio">
                        <label for="edit-type-10" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-10.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 10</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-11" <?php echo ($extra_info_icon_type == "aioa-icon-type-11" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-11" class="form-radio">
                        <label for="edit-type-11" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-11.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 11</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-12" <?php echo ($extra_info_icon_type == "aioa-icon-type-12" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-12" class="form-radio">
                        <label for="edit-type-12" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-12.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 12</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-13" <?php echo ($extra_info_icon_type == "aioa-icon-type-13" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-13" class="form-radio">
                        <label for="edit-type-13" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-13.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 13</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-14" <?php echo ($extra_info_icon_type == "aioa-icon-type-14" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-14" class="form-radio">
                        <label for="edit-type-14" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-14.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 14</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-15" <?php echo ($extra_info_icon_type == "aioa-icon-type-15" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-15" class="form-radio">
                        <label for="edit-type-15" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-15.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 15</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-16" <?php echo ($extra_info_icon_type == "aioa-icon-type-16" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-16" class="form-radio">
                        <label for="edit-type-16" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-16.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 16</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-17" <?php echo ($extra_info_icon_type == "aioa-icon-type-17" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-17" class="form-radio">
                        <label for="edit-type-17" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-17.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 17</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-18" <?php echo ($extra_info_icon_type == "aioa-icon-type-18" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-18" class="form-radio">
                        <label for="edit-type-18" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-18.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 18</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-19" <?php echo ($extra_info_icon_type == "aioa-icon-type-19" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-19" class="form-radio">
                        <label for="edit-type-19" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-19.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 19</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-20" <?php echo ($extra_info_icon_type == "aioa-icon-type-20" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-20" class="form-radio">
                        <label for="edit-type-20" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-20.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 20</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-21" <?php echo ($extra_info_icon_type == "aioa-icon-type-21" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-21" class="form-radio">
                        <label for="edit-type-21" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-21.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 21</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-22" <?php echo ($extra_info_icon_type == "aioa-icon-type-22" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-22" class="form-radio">
                        <label for="edit-type-22" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-22.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 22</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-23" <?php echo ($extra_info_icon_type == "aioa-icon-type-23" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-23" class="form-radio">
                        <label for="edit-type-23" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-23.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 23</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-24" <?php echo ($extra_info_icon_type == "aioa-icon-type-24" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-24" class="form-radio">
                        <label for="edit-type-24" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-24.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 24</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-25" <?php echo ($extra_info_icon_type == "aioa-icon-type-25" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-25" class="form-radio">
                        <label for="edit-type-25" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-25.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 25</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-26" <?php echo ($extra_info_icon_type == "aioa-icon-type-26" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-26" class="form-radio">
                        <label for="edit-type-26" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-26.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 26</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-27" <?php echo ($extra_info_icon_type == "aioa-icon-type-27" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-27" class="form-radio">
                        <label for="edit-type-27" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-27.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 27</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-28" <?php echo ($extra_info_icon_type == "aioa-icon-type-28" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-28" class="form-radio">
                        <label for="edit-type-28" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-28.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Type 28</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-type-29" <?php echo ($extra_info_icon_type == "aioa-icon-type-29" ? "checked" : ""); ?> name="aioa_icon_type" value="aioa-icon-type-29" class="form-radio">
                        <label for="edit-type-29" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-29.svg" width="65" height="65" />
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
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-1.svg" width="75" height="75" />
                          <span class="visually-hidden" style="display:none">Big</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-size-medium" <?php echo ($extra_info_icon_size == "aioa-medium-icon" ? "checked" : ""); ?> name="aioa_icon_size" value="aioa-medium-icon" class="form-radio">
                        <label for="edit-size-medium" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-1.svg" width="65" height="65" />
                          <span class="visually-hidden" style="display:none">Medium</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-size-default" <?php echo ($extra_info_icon_size == "aioa-default-icon" ? "checked" : ""); ?> name="aioa_icon_size" value="aioa-default-icon" class="form-radio">
                        <label for="edit-size-default" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-1.svg" width="55" height="55" />
                          <span class="visually-hidden" style="display:none">Default</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-size-small" <?php echo ($extra_info_icon_size == "aioa-small-icon" ? "checked" : ""); ?> name="aioa_icon_size" value="aioa-small-icon" class="form-radio">
                        <label for="edit-size-small" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-1.svg" width="45" height="45" />
                          <span class="visually-hidden" style="display:none">Small</span>
                        </label>
                      </div>
                    </div>
                    <div class="col-auto mb-30" style="padding:10px;">
                      <div class="js-form-item form-item js-form-type-radio form-type-radio js-form-item-position form-item-position">
                        <input type="radio" id="edit-size-extra-small" <?php echo ($extra_info_icon_size == "aioa-extra-small-icon" ? "checked" : ""); ?> name="aioa_icon_size" value="aioa-extra-small-icon" class="form-radio">
                        <label for="edit-size-extra-small" class="option">
                          <img src="https://www.skynettechnologies.com/sites/default/files/aioa-icon-type-1.svg" width="35" height="35" />
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
            <td><?php submit_button(); ?></td>
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
        var ico_type = '<?php echo $extra_info_icon_type; ?>';
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
if (!function_exists("update_ADAC_info")) {
  function update_ADAC_info()
  {
    register_setting("ada-accessibility-info-settings", "userid");
    register_setting("ada-accessibility-info-settings", "highlight_color");
    register_setting("ada-accessibility-info-settings", "is_widget_custom_position");
    register_setting("ada-accessibility-info-settings", "widget_size");
    register_setting("ada-accessibility-info-settings", "position");
    register_setting("ada-accessibility-info-settings", "aioa_icon_type");
    register_setting("ada-accessibility-info-settings", "aioa_icon_size");
    register_setting("ada-accessibility-info-settings", "widget_position_left");
    register_setting("ada-accessibility-info-settings", "widget_position_right");
    register_setting("ada-accessibility-info-settings", "widget_position_top");
    register_setting("ada-accessibility-info-settings", "widget_position_bottom");
    register_setting("ada-accessibility-info-settings", "is_widget_custom_size");
    register_setting("ada-accessibility-info-settings", "widget_icon_size_custom");


    /* Start Save widget Settings on Dashboard */


    global $AutologinLink, $widget_settings;

    $extra_info_high_link = get_option("highlight_color") ? get_option("highlight_color") : (!empty($widget_settings->Data->widget_color_code) ? $widget_settings->Data->widget_color_code :"f15a22");
    $extra_info_position = get_option("position") ? get_option("position") : "bottom_right";
    $extra_info_position_type = get_option("is_widget_custom_position") ? get_option("is_widget_custom_position") : "0";
    $extra_info_icon_type = get_option("aioa_icon_type") ? get_option("aioa_icon_type") : "aioa-icon-type-1";
    $extra_info_icon_size = get_option("aioa_icon_size") ? get_option("aioa_icon_size") : "aioa-medium-icon";
    $extra_info_widget_size = get_option("widget_size") ? get_option("widget_size") : "regularsize";
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

    
    //print_r($resp);
    /* End Save widget Settings on Dashboard */
  }
}

function add_ADAC()
{
  global $AutologinLink, $widget_settings;

  $extra_infouserid = get_option("userid") ? get_option("userid") : "";
 
  $extra_info_high_link = get_option("highlight_color") ? get_option("highlight_color") :  (!empty($widget_settings->Data->widget_color_code) ? $widget_settings->Data->widget_color_code :"f15a22");
  $extra_info_position = get_option("position") ? get_option("position") : "bottom_right";
  $extra_info_widget_size = get_option("widget_size") ? get_option("widget_size") : "regularsize";
  $extra_info_position_type = get_option("is_widget_custom_position") ? get_option("is_widget_custom_position") : "0";
  $extra_info_icon_type = get_option("aioa_icon_type") ? get_option("aioa_icon_type") : "aioa-icon-type-1";
  $extra_info_icon_size = get_option("aioa_icon_size") ? get_option("aioa_icon_size") : "aioa-medium-icon";
  $widget_position_left = get_option("widget_position_left") ? get_option("widget_position_left") : "";
  $widget_position_right = get_option("widget_position_right") ? get_option("widget_position_right") : "";
  $widget_position_top = get_option("widget_position_top") ? get_option("widget_position_top") : "";
  $widget_position_bottom = get_option("widget_position_bottom") ? get_option("widget_position_bottom") : "";
  $is_widget_custom_size = get_option("is_widget_custom_size") ? get_option("is_widget_custom_size") : "0";

  $activeColor = "#" . $extra_info_high_link;
  $userid = $extra_infouserid;
  if (empty($userid)) {
    $userid = "null";
  }
  $baseURL = "https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js";
  $ADAC_args = ["colorcode" => str_replace("#", "", $activeColor), "token" => $userid, "t" => rand(1, 10000000), "position" => $extra_info_position . "." . $extra_info_icon_type . "." . $extra_info_icon_size];
  wp_enqueue_script("aioa-adawidget", add_query_arg($ADAC_args, $baseURL), [], null, true);
}
add_filter("script_loader_tag", function ($tag, $handle) {
  if ("aioa-adawidget" !== $handle) {
    return $tag;
  }
  return str_replace(" src", " defer src", $tag); // defer the script

}, 10, 2);
//add_action('wp_body_open', 'add_ADAC');
add_action("wp_head", "add_ADAC");
function ADAC_deactivation()
{
  $userid = "userid";
  $highlight_color = "highlight_color";
  $position = "position";
  delete_option($userid);
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
register_deactivation_hook(__FILE__, "ADAC_deactivation");
add_filter("clean_url", "ADAC_strip_ampersand", 99, 3);
function ADAC_strip_ampersand($url, $original_url, $_context)
{
  if (strstr($url, "skynettechnologies.com") !== false) {
    $url = str_replace("&#038;", "&", $url);
  }
  return $url;
}
?>