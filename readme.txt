=== WP Robots Txt ===
Contributors: pattihis
Donate link: https://profiles.wordpress.org/pattihis/
Tags: robots.txt, robots, seo
Requires at least: 5.3.0
Tested up to: 7.1
Requires PHP: 7.0
Stable tag: 1.3.6
License: GPL2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Robots Txt Allows you to edit the content of your robots.txt file.

== Description ==

WordPress, by default, includes a simple robots.txt file that's dynamically generated from within the WP application. This is great, but how do you easily change the content?

Enter **WP Robots Txt**, a plugin that adds an additional field to the "Reading" admin page where you can do just that. No manual coding or file editing required!

Simply visit https://your-site.com/wp-admin/options-reading.php and you can control the contents of your https://your-site.com/robots.txt

[Changelog](https://wordpress.org/plugins/wp-robots-txt/#developers)

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

= Does discouraging search engines change robots.txt? =

No. Since WordPress 5.3 that setting adds a `noindex` meta tag. It does not add `Disallow: /` to `robots.txt`. Your saved rules are still served. Add `Disallow: /` yourself if you want crawlers to skip the site.

= Why is my edited robots.txt not used? =

WordPress only serves the virtual `robots.txt` when there is no physical `robots.txt` file in the site root. Delete or rename that file to use this plugin.

= Where can I learn more about `robots.txt` files? =

[Here](https://developers.google.com/webmasters/control-crawl-index/docs/robots_txt) is a general guide by Google and [here](https://wordpress.org/support/article/search-engine-optimization/) is the WordPress SEO documentation.

== Changelog ==

= 1.3.6 =
* Compatibility with WordPress 7.1
* Stop HTML-escaping robots.txt output (it is text/plain; this broke URLs with `&`)
* Store sanitized plain text instead of `esc_html()` in the option
* Decode legacy HTML entities from older saved content
* Fix default `Disallow`/`Allow` paths on subdirectory installs (match core `admin_url()`)
* Guard sitemap defaults for WordPress 5.3–5.4 and when sitemaps are disabled
* Use `esc_url_raw()` for the default Sitemap line
* Warn when a physical robots.txt file will override this plugin
* Keep saved rules when search engines are discouraged (WordPress does not add `Disallow: /`)
* Harden admin and plugin-row markup escaping
* Add `ABSPATH` guards on included files

= 1.3.5 =
* Compatibility with WordPress 6.8

= 1.3.4 =
* Compatibility with WordPress 6.7

= 1.3.3 =
* Add Line Break to allow appending more rules. Thanks @flberger

= 1.3.2 =
* Add translation template

= 1.3.1 =
* Compatibility with WordPress 6.4
* WP Coding Standards compliant

= 1.3 =
* Ensure Compatibility with WP v6.3
* Increase PHP minimum required version

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

= 1.3.6 =
* Security and compatibility release for WordPress 7.1. Saved robots.txt is no longer HTML-escaped.

= 1.1 =
* Should actually work in 3.5+ now

= 1.0 =
* Everyone wants to edit their `robots.txt` files.
