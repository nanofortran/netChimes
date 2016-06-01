<?php
/*
Plugin Name: JavaScript AutoLoader
Plugin URI: http://smartware.cc/free-wordpress-plugins/javascript-autoloader/
Description: This Plugin allows you to load additional JavaScript files without the need to change files in the Theme directory. To load additional JavaScript files just put them into a directory named jsautoload.
Version: 1.2
Author: smartware.cc
Author URI: http://smartware.cc
License: GPL2
*/

/*  Copyright 2015  smartware.cc  (email : sw@smartware.cc)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class Swcc_Javascript_Autoloader {

  public function __construct() {
    add_action( 'init', array( $this, 'load' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'jsautoloader' ), 999 );
    add_action( 'admin_init', array( $this, 'admininit' ) );
    add_action( 'admin_menu', array( $this, 'adminmenu' ) );
  }
  
  function load () {
    load_plugin_textdomain( 'jsautoload_general', false, basename( dirname( __FILE__ ) ) . '/languages' );
    load_plugin_textdomain( 'jsautoload', false, basename( dirname( __FILE__ ) ) . '/languages' );
  }
  
  function admininit() {
    add_meta_box( 'swcc_jsal_meta_box_like', __( 'Like this Plugin?', 'jsautoload_general' ), array( $this, 'swcc_jsal_add_meta_box_like' ), 'swcc_jsal', 'side' );
    add_meta_box( 'swcc_jsal_meta_box_help', __( 'Need help?', 'jsautoload_general' ), array( $this, 'swcc_jsal_add_meta_box_help' ), 'swcc_jsal', 'side' );
  }
  
  // add like meta box 
  function swcc_jsal_add_meta_box_like() {
    ?>
    <ul>
      <li><div class="dashicons dashicons-wordpress"></div>&nbsp;&nbsp;<a href="https://wordpress.org/plugins/javascript-autoloader/"><?php _e( 'Please rate the plugin', 'jsautoload_general' ); ?></a></li>
      <li><div class="dashicons dashicons-admin-home"></div>&nbsp;&nbsp;<a href="http://smartware.cc/free-wordpress-plugins/javascript-autoloader/"><?php _e( 'Plugin homepage', 'jsautoload_general'); ?></a></li>
      <li><div class="dashicons dashicons-admin-home"></div>&nbsp;&nbsp;<a href="http://smartware.cc/"><?php _e( 'Author homepage', 'jsautoload_general' );?></a></li>
      <li><div class="dashicons dashicons-googleplus"></div>&nbsp;&nbsp;<a href="https://plus.google.com/+SmartwareCc"><?php _e( 'Authors Google+ Page', 'jsautoload_general' ); ?></a></li>
      <li><div class="dashicons dashicons-facebook-alt"></div>&nbsp;&nbsp;<a href="https://www.facebook.com/smartware.cc"><?php _e( 'Authors facebook Page', 'jsautoload_general' ); ?></a></li>
    </ul>
    <?php
  }

  // add help meta box 
  function swcc_jsal_add_meta_box_help() {
    ?>
    <ul>
      <li><div class="dashicons dashicons-wordpress"></div>&nbsp;&nbsp;<a href="https://wordpress.org/plugins/javascript-autoloader/faq/"><?php _e( 'Take a look at the FAQ section', 'jsautoload_general' ); ?></a></li>
      <li><div class="dashicons dashicons-wordpress"></div>&nbsp;&nbsp;<a href="https://wordpress.org/plugins/javascript-autoloader"><?php _e( 'Take a look at the Support section', 'jsautoload_general'); ?></a></li>
      <li><div class="dashicons dashicons-admin-comments"></div>&nbsp;&nbsp;<a href="http://smartware.cc/contact/"><?php _e( 'Feel free to contact the Author', 'jsautoload_general' ); ?></a></li>
    </ul>
    <?php
  }
  
  // returns an array of files to add
  function getFiles( $dir, $suffix='', $urlprefix='', $prefix='', $depth=0, $footer=0, $source ) {
    $dir = rtrim( $dir, '\\/' );
    $files = array();
    $result = array();
    if( $urlprefix != '' && substr( $urlprefix, -1 ) != '/' ) {
      $urlprefix .= '/';
    }
    $suffix = strtolower( $suffix );
    if ( file_exists( $dir ) ) {
      foreach ( scandir( $dir ) as $f ) {
        if ( $f !== '.' && $f !== '..' ) {
          if ( is_dir( "$dir/$f" ) && substr( $f, 0, 1 ) != '_' ) {
            if( $f == 'footer' || $footer == 1 ) {
              $ft = 1;
            } else {
              $ft = 0;
            }
            $result = array_merge( $result, $this->getFiles( "$dir/$f", "$suffix", "$urlprefix", "$prefix$f/", $depth+1, $ft, $source ) );
          } else {
            if ( $suffix=='' || ( $suffix != '' && strtolower( substr( $f, -strlen( $suffix ) ) ) == $suffix ) ) {
              $file['name'] = $urlprefix.$prefix.$f;
              $file['depth'] = $depth;
              $file['footer'] = $footer;
              $file['source'] = $source;
              $result[] = $file;
            }
          }
        }
      }
    }
    return $result;
  }

  // get an sorted array of all *.js files in all possible loactions 
  function getAllFiles() {
    $dir = 'jsautoload';
    $filesarray = array();
    if ( is_child_theme() ) { $filesarray = $this->getFiles( get_stylesheet_directory() . '/' . $dir, '.js', get_stylesheet_directory_uri() . '/' . $dir, '', 0, 0, 1 ); }
    $filesarray = array_merge( $filesarray, $this->getFiles( get_template_directory() . '/' . $dir, '.js', get_template_directory_uri(). '/' . $dir, '', 0, 0, 2 ) );
    $filesarray = array_merge( $filesarray, $this->getFiles( WP_CONTENT_DIR . '/' . $dir, '.js', content_url() . '/' . $dir, '', 0, 0, 3 ) );
    $files = array();
    $depth = array();
    $source = array();
    $footer = array();
    foreach ( $filesarray as $file ) {
      $files[] = $file['name'];
      $depth[] = $file['depth'];
      $source[] = $file['source'];
      $footer[] = $file['footer'];
    }
    array_multisort( $footer, SORT_NUMERIC, $source, SORT_NUMERIC, $depth, SORT_NUMERIC, $files, SORT_ASC, $filesarray );
    return $filesarray;
  }

  // adds an js file to header
  function add( $jsfile, $footer ) {
    wp_enqueue_script( 'swcc-js-autoloader-' . basename($jsfile), $jsfile, array(), false, ( $footer==1 ) );
  }

  // show admin page
  function showadmin() {
    if ( !current_user_can( 'activate_plugins' ) )  {
      wp_die( ___( 'You do not have sufficient permissions to access this page.' ) );
    }
    $dir = 'jsautoload'; 
    ?>
    <div class="wrap">
      <?php screen_icon( 'tools' ); ?>
      <h2>JavaScript AutoLoader</h2>
      <div id="poststuff">
        <div id="post-body" class="metabox-holder columns-2">
          <div id="post-body-content">
            <div class="meta-box-sortables ui-sortable">
              <div class="postbox">
                <h3><span><?php _e( 'Possible paths to store your JavaScript files', 'jsautoload'); ?></span></h3>
                <div class="inside">
                  <h4><?php _e( 'Child Theme Directory', 'jsautoload'); ?></h4>
                  <p><?php 
                    if ( is_child_theme() ) {
                      echo __( 'Current Path', 'jsautoload' ) . ': <code>' . get_stylesheet_directory() . '/' . $dir . '</code>';
                    } else {
                      _e( 'You are not using a Child Theme', 'jsautoload' );
                    }
                  ?></p>
                  <h4><?php _e( 'Theme Directory', 'jsautoload'); ?></h4>
                  <p><?php echo __( 'Current Path', 'jsautoload' ) . ': <code>' . get_template_directory() . '/' . $dir; ?></code></p>
                  <h4><?php _e( 'General Directory', 'jsautoload'); ?></h4>
                  <p><?php echo __( 'Current Path', 'jsautoload' ) . ': <code>' . WP_CONTENT_DIR . '/' . $dir; ?></code></p>
                </div>
                <hr />
                <h3><span><?php _e( 'Currently loaded JavaScript files (in that order)', 'jsautoload'); ?></span></h3>
                <div class="inside">
                  <?php $this->showcurrent(); ?>
                </div>
              </div> 
            </div>
          </div>
          <div id="postbox-container-1" class="postbox-container">
            <?php do_meta_boxes( 'swcc_jsal', 'side', true ); ?>
          </div>
        </div>
        <br class="clear" />
      </div>    
      <br id="two_column" class="clear" />
    </div>
    <div class="clear"></div>
    <?
  }

  // list cuurently loaded js files on admin page
  function showcurrent() {
    $filesarray = $this->getAllFiles();  
    if ( empty( $filesarray ) ) {
      echo '<p>no files loaded currently</p>';
    } else {
    $loc = -1;
      foreach ( $filesarray as $file ) {
        if ( $file['footer'] != $loc) {
          if ( $file['footer'] == 0) {
            echo '<p><strong>' . __('in Header', 'jsautoload' ) . '</strong></p>';
            echo '<ul>';
          } else {
            if ( $loc != -1 ) {
              echo '</ul>';
            }
            echo '<ul>';
            echo '<p><strong>' . __( 'in Footer (be sure to call wp_footer() in your footer template!)', 'jsautoload' ) . '</strong></p>';
          }
          $loc = $file['footer'];
        }
        echo '<li><code>' . $file['name'] . '</code></li>';
      }
      echo '</ul>';
    }
  }

  // init frontend
  function jsautoloader() {
    $filesarray = $this->getAllFiles();  
    foreach ( $filesarray as $file ) {
      $this->add( $file['name'], $file['footer'] );
    }
  }

  // init backend
  function adminmenu() {
    add_management_page( 'WP JS AutoLoader', 'JS AutoLoader', 'activate_plugins', 'wpjsautoloader', array( $this, 'showadmin' ) );
  }
}

$swccJavascriptAutoloader = new Swcc_Javascript_Autoloader();
?>