=== WordPress Analytics ===
Contributors: joostdevalk
Donate link: http://www.escalateseo.com
Tags: analytics, google analytics, statistics, tracking, stats, google
Requires at least: 2.8
Tested up to: 3.2
Stable tag: 1.2.0

Track your WordPress site easily and with lots of metadata: views per author & category, automatic tracking of outbound clicks and pageviews.

== Description ==

The WordPress Analytics plugin allows you to track your blog easily and with lots of metadata. 

Full list of features:

* Simple installation through integration with Google Analytics API: authenticate, select the site you want to track and you're done.
* This plugin uses the asynchronous Google Analytics tracking code, the fastest and most reliable tracking code Google Analytics offers.
* Option to manually place the tracking code in another location.
* Automatic Google Analytics site speed tracking.
* Outbound link & downloads tracking.
	* Configurable options to track outbound links either as pageviews.
	* Option to track just downloads as pageviews in Google Analytics.
* Allows usage of custom variables in Google Analytics to track meta data on pages. Support for the following custom variables:
	* Author
	* Single category and / or multiple categories
	* Post type (especially useful if you use custom post types)
	* Logged in users
	* Publication Year
	* Tags
* Possibility to ignore any user level and up, so all editors and higher for instance.
* Easily connect your Google AdSense and Google Analytics accounts.
* Option to tag links with Google Analytics campaign tracking, with the option to use hashes (#).
* Option anonymize IP's, for use in countries like Germany.
* Full [debug mode](http://www.escalateseo.comgoogle-analytics-debug-mode/), including Firebug lite and ga_debug.js for debugging Google Analytics issues.
* Allow local hosting of ga.js file.
* Tracking of search engines not included in Google Analytics default tracking.
* Tracking of login and registration forms.

== Installation ==

This section describes how to install the plugin and get it working.

1. Delete any existing `gapp` or `wordpress-analytics` folder from the `/wp-content/plugins/` directory
1. Upload `wordpress-analytics` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to the options panel under the 'Settings' menu and add your Analytics account number and set the settings you want.

== Frequently Asked Questions ==

= Can I run this plugin together with another Google Analytics plugin? =

No. You can not. It will break tracking.

= Another profile than the one I selected is showing as selected? =

You probably have multiple profiles for the same website, that share the same UA-code. If so, it doesn't matter which of the profiles is shown as selected, tracking will be correct.

= I've just installed the new tracking and Google Analytics says it's not receiving data yet? =

Give it a couple of hours, usually it'll be fixed. It can take up to 24 hours to appear though.

= Google Analytics says it's receiving data, but I don't see any stats yet? =

This can take up to 24 hours after the installation of the new tracking code.

= Why is the tracking code loaded in the head section of the site? =

Because that's where it belongs. It makes the page load faster (yes, faster, due to the asynchronous method of loading the script) and tracking more reliable. If you must place it in the footer anyway, switch to manual mode.

== Screenshots ==

1. Screenshot of the basic settings panel for this plugin.
2. Screenshot of the custom variable settings panel.
3. Screenshot of the link tracking panel.
4. Screenshot of the advanced settings panel.

== Changelog ==

This is the first release of WordPress Analytics made available to WordPress.org users.

== Upgrade Notice ==

This is the first release of WordPress Analytics made available to WordPress.org users.