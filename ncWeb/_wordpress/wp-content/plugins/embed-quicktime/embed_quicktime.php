<?php
/*
Plugin Name: Embed QuickTime
Plugin URI: http://www.solitude.dk/archives/embedquicktime/wordpress/
Description: Embed QuickTime movies into blog posts easily.
Version: 1.1
Author: Andreas Haugstrup Pedersen
Author URI: http://www.solitude.dk/
*/
/*
Copyright (c) 2007 Andreas Haugstrup Pedersen

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

// Insert Embed QuickTime JavaScript into page <head>.
function embedquicktime_head() {
  echo "\n<script src=\"" . get_settings("siteurl") . "/wp-content/plugins/embed_quicktime" . "/jquery-1.2.1.pack.js\" type=\"text/javascript\"></script>\n";
  echo "\n<script src=\"" . get_settings("siteurl") . "/wp-content/plugins/embed_quicktime" . "/jquery.embedquicktime.js\" type=\"text/javascript\"></script>\n";
  echo '<script type="text/javascript" charset="utf-8">
  jQuery.noConflict();
  jQuery(document).ready(function() {
    jQuery.embedquicktime({jquery: "' . get_settings("siteurl") . '/wp-content/plugins/embed_quicktime/jquery-1.2.1.pack.js", plugin: "' . get_settings("siteurl") . '/wp-content/plugins/embed_quicktime/jquery.embedquicktime.js"});
  });
  </script>';
}
add_action('wp_head', 'embedquicktime_head');

// Insert code generator on write forms.
function embedquicktime_code() {
  echo "\n<script src=\"" . get_settings("siteurl") . "/wp-content/plugins/embed_quicktime" . "/jquery-1.2.1.pack.js\" type=\"text/javascript\"></script>\n";
  echo '<script type="text/javascript" charset="utf-8">
  jQuery.noConflict();
  </script>';
  echo "<script type=\"text/javascript\" charset=\"utf-8\">
	 jQuery(document).ready(function() {
	   jQuery('#embedquicktime_getcode').click(function(){
	     if (jQuery('#embedquicktime_video').val().length == 0) {
	       alert('Put in a video URL.');
	       return false;
	     }
	     if (jQuery('#embedquicktime_image').val().length == 0) {
	       alert('Put in a thumbnail URL.');
	       return false;
	     }
	     if (jQuery('#embedquicktime_text').val().length == 0) {
	       var title = '';
	     } else {
	       var title = '<br>'+jQuery('#embedquicktime_text').val();
	     }
	     var share = '';
       if (jQuery('#embedquicktime_share').is(':checked')) {
         share = ' share';
       }
	     // Make code.
	     var code = '<div class=\"hvlog'+share+'\"> <a href=\"'+jQuery('#embedquicktime_video').val()+'\" rel=\"enclosure\"> <img src=\"'+jQuery('#embedquicktime_image').val()+'\">'+title+'</a> </div>';
      jQuery('#embedquicktime_code').val(code).select().focus();
      jQuery('#embedquicktime_code').select().focus();
      jQuery('#embedquicktime_codewrapper').show();
      jQuery('#embedquicktime_code').select().focus();
      return false;
	   });
   });
	</script>";
  echo '<div class="dbx-b-ox-wrapper">
  <fieldset id="embedquicktime_codegenerator" class="dbx-box">
  <div class="dbx-h-andle-wrapper">
  <h3 class="dbx-handle">Embed QuickTime</h3>
  </div>
  <div class="dbx-c-ontent-wrapper">
  <div class="dbx-content">
  <table>
    <col/>
    <col class="widefat" />
    <tbody>
      <tr>
        <th scope="row">
          <label for="embedquicktime_video">Video URL</label>        
        </th>
        <td>
          <input type="text" name="embedquicktime_video" id="embedquicktime_video" value="" size="35">        
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="embedquicktime_image">Thumbnail URL</label>        
        </th>
        <td>
          <input type="text" name="embedquicktime_image" id="embedquicktime_image" value="" size="35">        
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="embedquicktime_share">Allow sharing?</label>        
        </th>
        <td>
          <input type="checkbox" name="embedquicktime_share" id="embedquicktime_share" value="" size="35"> Yes, please.        
        </td>
      </tr>
      <tr>
        <th scope="row">
          <label for="embedquicktime_text">Title <em>(optional)</em></label>        
        </th>
        <td>
          <input type="text" name="embedquicktime_text" id="embedquicktime_text" value="" size="35"> <button type="embedquicktime_button" id="embedquicktime_getcode">Get my code</button>        
        </td>
      </tr>
      <tr>
        <th scope="row">
        </th>
        <td>
          <div style="display:none;" id="embedquicktime_codewrapper"><textarea name="embedquicktime_code" id="embedquicktime_code" rows="6" cols="30"></textarea></div>
        </td>
      </tr>
    </tbody>
  </table>
  </div>
  </div>
  </fieldset>
  </div>';
}
add_action("simple_edit_form","embedquicktime_code");
add_action("edit_form_advanced","embedquicktime_code");
add_action("edit_page_form","embedquicktime_code");


?>