=== JavaScript AutoLoader ===
Contributors: smartware.cc
Tags: javascript, jquery, header, footer, wp_enqueue_script, load, autoload
Requires at least: 2.6
Tested up to: 4.1
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Load JavaScript files without changing files in the theme directory or installing several plugins to add all the desired functionality

== Description ==

> This Plugin allows you to load additional JavaScript files without the need to change files in the theme directory or to install several plugins to add all the desired functionality.

See also [Plugin Homepage](http://smartware.cc/free-wordpress-plugins/javascript-autoloader/)

To load additional JavaScript files just put them into a directory named **jsautoload**. This directory can be placed in three different locations that are loaded in the following order:

* Child Theme dependent (if using a Child Theme) : in the Child Theme's directory
* Theme dependent : in the Theme's directory
* Theme independent : in the wp-content directory

Only files with extension .js are added, all other files are ignored. Subdirectories can be used and will also be scanned. To ignore a complete directory (including all subdirectories) name the directory beginning with an underscore (_). The files are added in alphabetical order. Directories always are added **after** files. 

To load one ore more JavaScript files at the end of your HTML file just place them into a directory named **footer**. To add the files to the footer of your theme it is required to call wp_footer() in your footer.php.

= Languages =

* English
* German
* Spanish (thanks to [Gaston](http://cosa-de-mandinga.blogspot.de))

**Translators welcome!** The languages directory contains POT files to start new translations. Please [contact Author](http://smartware.cc/) if you would like to do a translation.

= Do you like the JavaScript AutoLoader Plugin? =

Thanks, I appreciate that. You don't need to make a donation. No money, no beer, no coffee. Please, just [tell the world that you like what I'm doing](http://smartware.cc/make-a-donation/)! And that's all.

= More plugins from smartware.cc =

* **[hashtagger](https://wordpress.org/plugins/hashtagger/)** - Use #hashtags and @usernames in your posts
* **[404page](https://wordpress.org/plugins/404page/)** Define any of your WordPress pages as 404 error page 
* **[link-log](https://wordpress.org/plugins/link-log/)** - Find out where your visitors leave to. Track clicks on external links. 
* **[smart Archive Page Remove](https://wordpress.org/plugins/smart-archive-page-remove/)** - Completely remove unwated Archive Pages from your Blog 
* **[smart User Slug Hider](https://wordpress.org/plugins/smart-user-slug-hider/)** - Hide usernames in author pages URLs to enhance security 

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins' -> 'Add New'
1. Search for 'JavaScript AutoLoader'
1. Activate the plugin through the 'Plugins' menu in WordPress

= Manually from wordpress.org =

1. Download JavaScript AutoLoader from wordpress.org and unzip the archive
1. Upload the `javascript-autoloader` folder to your `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Go to 'Tools' -> 'JS AutoLoader' in your WordPress dashboard to see the possible paths where to store your JavaScript files and the currently loaded files

== Changelog ==

= 1.2 (2015-03-11) =
* Spanish translation

= 1.1 (2014-11-08) =
* Technical Improvements
* WP 4.0 Style
* German translation

= 1.0 (2013-09-13) =
* Initial Release