=== CC Food Truck ===

Contributors: pjaudiomv
Tags: cc, food truck
Tested up to: 6.3.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

**CC Food Truck** is a plugin designed to fetch food truck data from a Google Spreadsheet and display it on your website.

== Description ==

**CC Food Truck** is a plugin designed to fetch food truck data from a Google Spreadsheet and display it on your website.

SHORTCODE
- Basic Usage: `[cc_food_truck]`
    * Ensure your Google Sheet has the row headers: `date, name, url, event_info, truck_info`. The date should be formatted as mm/dd/yyyy. Implement data validation on the date and url rows to prevent errors. Note: This plugin also offers built-in data validation.
    * Regarding the Google API Key: You'll need an API key with Spreadsheet access. The sheet should either be set to "anyone with the link can view" or you should add a service user. If you're utilizing server-side event loading, restrict the key by server IP. For client-side loading, restrict the key by domain.

MORE INFORMATION

<a href="https://github.com/pjaudiomv/cc-food-truck" target="_blank">https://github.com/pjaudiomv/cc-food-truck</a>

== Installation ==

This section describes how to install the plugin and get it working.

1. Download and install the plugin via the WordPress dashboard, or upload the entire **CC Food Truck Plugin** folder to `/wp-content/plugins/`.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Insert the `[cc_food_truck]` shortcode into your WordPress page or post.

== Changelog ==

= 1.0.0 =

* Initial Release
