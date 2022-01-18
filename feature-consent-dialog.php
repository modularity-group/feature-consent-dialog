<?php

add_action('acf/init', function(){
  require_once 'feature-consent-dialog.fields.php';
});

add_action('acf/init','feature_consent_dialog_options');
function feature_consent_dialog_options(){
  if( function_exists('acf_add_options_page') ) {

    acf_add_options_sub_page(array(
      'page_title'  => __('Consent Dialog','theme'),
      'menu_title'  => __('Consent Dialog','theme'),
      'menu_slug'   => 'feature-consent-dialog',
      'parent_slug' => 'options-general.php',
      'capability'  => 'manage_options',
    ));

  }
}

add_action('wp_body_open', function() {
  if(get_field('feature_consent_dialog_active','option')){
    require_once 'feature-consent-dialog.template.php';
  }
});

add_action( 'wp_enqueue_scripts', function() {
  if(get_field('feature_consent_dialog_active','option')){
    $module_basename = 'feature-consent-dialog';
    $module_directory_path = dirname( __FILE__ );
    $module_directory_uri = strpos($module_directory_path,'/themes/') ? get_stylesheet_directory_uri().'/'.$module_basename : WP_CONTENT_URL.'/modules/'.$module_basename;

    wp_enqueue_script(
      'consent-dialog-ajax',
      $module_directory_uri. '/feature-consent-dialog.ajax.js',
      array('core-module-script-loader-theme'),
      filemtime($module_directory_path. '/feature-consent-dialog.ajax.js'),
      true
    );

    wp_localize_script(
      'consent-dialog-ajax',
      'optional_scripts',
      array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce')
      )
    );
  }
});

add_action( 'wp_ajax_feature_consent_dialog_load_scripts', 'feature_consent_dialog_load_scripts' );
add_action( 'wp_ajax_nopriv_feature_consent_dialog_load_scripts', 'feature_consent_dialog_load_scripts' );
function feature_consent_dialog_load_scripts() {
  if(get_field('feature_consent_dialog_active','option')){
    $nonce = $_POST['nonce'];
    $type = $_POST['type'];
    if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) ) {
      die( 'Nonce value cannot be verified.' );
    }
    if ( isset($_REQUEST) ) {
      $optional_scripts = get_field('feature_consent_dialog_'.$type.'_scripts','option');
      echo json_encode($optional_scripts);
    }
    die();
  }
}

function consent_dialog_blocked($type){
  if(get_field('feature_consent_dialog_active','option')){
  ?>
  <div class="feature-consent-dialog__blocked">
    <div>
      <?= get_field('feature_consent_dialog_'.$type.'_blocked','option') ?><br>
      <a href="#consent-dialog"><?= get_field('feature_consent_dialog_consent_setup','option'); ?></a>
    </div>
  </div>
  <?php
  }
}

add_shortcode('consent_dialog_infotext',function($atts){
  if(!get_field('feature_consent_dialog_active','option')){
    return '';
  }
  $atts = shortcode_atts( array(
    'type' => 'essential'
  ), $atts, 'consent_dialog_infotext' );

  if(get_field('feature_consent_dialog_active','option')){
    return get_field('feature_consent_dialog_'.$atts['type'].'_text','option');
  }
});

function is_consent_dialog_selected($type){
  if(get_field('feature_consent_dialog_active','option')){
    $scriptGroups = array();
    if (isset($_COOKIE['consent-dialog'])) {
      $scriptGroups = json_decode(html_entity_decode(stripslashes($_COOKIE['consent-dialog'])));
    }
    if(is_array($scriptGroups) && in_array($type,$scriptGroups)){
      return true;
    }
  } else {
    return true;
  }
}
