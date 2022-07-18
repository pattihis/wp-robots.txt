=== WP Robots Txt ===
Contributors: chrisguitarguy, pattihis
Donate link: https://profiles.wordpress.org/pattihis/
Tags: robots.txt, robots, seo
Requires at least: 5.3.0
Tested up to: 6.0.1
Requires PHP: 5.6
Stable tag: 1.2
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Robots Txt Allows you to edit the content of your robots.txt file.

== Description ==

WordPress, by default, includes a simple robots.txt file that's dynamically generated from within the WP application.  This is great! but maybe you want to change the content.

Enter WP Robots Txt, a plugin that adds an additional field to the "Reading" admin page where you can do just that.

Simply visit https://your-site.com/wp-admin/options-reading.php and you can control the contents of your https://your-site.com/robots.txt

[Changelog](https://wordpress.org/plugins/wp-robots-txt/#developers)

*WP Robots Txt* was originally developed by [chrisguitarguy](https://profiles.wordpress.org/chrisguitarguy/). The plugin has been adopted and updated by [George Pattihis](https://profiles.wordpress.org/pattihis/) who will continue development.

== Installation ==

1. Download the plugin
2. Unzip it
3. Upload the unzipped folder to `wp-content/plugins` directory
4. Activate and enjoy!

Or you can simply install it through the admin area plugin installer.

== Screenshots ==

1. A view of the admin option

== Frequently Asked Questions ==

= I totally screwed up my `robots.txt` file. How can I restore the default version? =

Delete all the content from the *Robots.txt Content* field and save the privacy options.

= Could I accidently block all search bots with this? =

Yes.  Be careful! That said, `robots.txt` files are suggestions. They don't really *block* bots as much as they *suggest* that bots don't crawl portions of a site.  That's why the options on the Privacy Settings page say "Ask search engines not to index this site."

= Where can I learn more about `robots.txt` files? =

[Here](https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt) is a general guide by Google and [here](https://wordpress.org/support/article/search-engine-optimization/) is the WordPress SEO documentation.

== Changelog ==

= 1.2 =
* Update the default robots.txt content
* Include sitemap reference
* Resolve code warnings/errors
* WP Coding Standards compliant
* Ensure Compatibility with WP v6

= 1.1 =
* Moved the settings field "officially" to the reading page
* General code clean up

= 1.0 =
* Initial version

== Upgrade Notice ==

= 1.1 =
* Should actually work in 3.5+ now

= 1.0 =
* Everyone wants to edit their `robots.txt` files.
