<?php

/*
Plugin Name: Audio Player Widget
Plugin URI: http://cyclometh.com/audio-player-wordpress-widget/
Description: Audio Player Widget is a simple sidebar widget that allows you to embed Martin Lane's Audio Player in sidebars and other locations where a widget can be used.
Version: 1.0
Author: Corey Snow
Author URI: http://cyclometh.com

License:

Copyright (c) 2011 Corey Snow
Portions Copyright (c) 2010 Justin Tadlock

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

add_action( 'widgets_init', 'load_audioplayer_widget' );

/*
 * Register the widget with WordPress.
 * @since 0.1
 */
function load_audioplayer_widget() {
	register_widget( 'AudioPlayer_Widget' );
}

/*
 * The actual AudioPlayer_Widget class.
 * @since 0.1
 */
class AudioPlayer_Widget extends WP_Widget {

	function AudioPlayer_Widget() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'audioplayer', 'description' => 'A widget that embeds an audio player. Requires the audio-player plugin.');

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'audioplayer-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'audioplayer-widget', 'Audio', $widget_ops, $control_ops );
	}

	/*
	 * Displays the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* load the label and URL from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$audioUri = $instance['audioUri'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Display the widget title if one was specified. */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display the audio file from widget settings if it was specified.
		   Note that if the audio-player plugin is not present nothing is displayed.
		*/
		
		if ( $audioUri ) {
			if (function_exists("insert_audio_player")) {   
				insert_audio_player(sprintf("[audio:%1s]", $audioUri) );
			}
		}
		/* any content required after a widget(for theme support). */
		echo $after_widget;
	}

	/*
	 * Save the settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags for title and name to remove HTML (important for text inputs). */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['audioUri'] = strip_tags( $new_instance['audioUri'] );

		return $instance;
	}

	/*
	 * Displays the widget settings controls on the widget panel.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Label', 'audioUri' => 'http://domain.com/audio/file.mp3' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Label -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php echo 'Label:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- Audio URI -->
		<p>
			<label for="<?php echo $this->get_field_id( 'audioUri' ); ?>"><?php echo 'Audio File URL:'; ?></label>
			<input id="<?php echo $this->get_field_id( 'audioUri' ); ?>" name="<?php echo $this->get_field_name( 'audioUri' ); ?>" value="<?php echo $instance['audioUri']; ?>" style="width:100%;" />
		</p>

	<?php
	}
}

?>