=== Auto Refresh on Save ===
Contributors: Mir Monoarul Alam
Tags: auto refresh, save post, page refresh, editor tools, cache clear
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automatically refreshes the frontend page when a post or page is saved by an admin or editor. Also clears cache to reflect updated content.

== Description ==

The **Auto Refresh on Save** plugin ensures that when a page or post is updated, the frontend automatically refreshes for logged-in admins or editors. No more manual reloads! This plugin also clears the cache for the page to reflect the latest changes immediately.

**Features:**

* Auto-refresh frontend page on save/update.
* Cache clearing for updated posts.
* Works only for admins or editors.
* Lightweight and easy to use.

== Installation ==

1. Upload the `auto-refresh-on-save` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Edit a page/post, save it, and watch the magic!

== Frequently Asked Questions ==

= Does it work with all caching plugins? =

Yes, it flushes the cache using `wp_cache_flush()`, compatible with WP Super Cache and similar plugins.

= Will the refresh happen for all users? =

No, only logged-in admins or editors will experience the auto-refresh.

== Changelog ==

= 1.0.0 =
* Initial release.

== License ==

This plugin is licensed under the GPL2. See https://www.gnu.org/licenses/gpl-2.0.html for more details.