=== Peers.me ===
Contributors: danielsteginga
Donate link: http://peers.me/
Tags: peers.me, community, API, groups, group conversation, forums, messaging, networking, profiles, social
Requires at least: 3.0.4
Tested up to: 3.0.4
Stable tag: 0.1

Peers.me is an group conversation tool for your company, school, sports team or community. This plugin makes it easy to access the public profiles and publications through the Peers.me API and display them in your WordPress site.

== Installation ==

1. Upload the `peersme` to the `/wp-content/plugins/` directory or install directly through the plugin installer.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enter your Peers.me API credentials on the settings page
4. Create a page: 'users'. Make sure the slug is the same name. Place the following shortcode [peers_me list="users"]
5. Create a page: 'groups'. Make sure the slug is the same name. Place the following shortcode [peers_me list="groups"]
6. Create a page: 'publications'. Make sure the slug is the same name. Place the following shortcode [peers_me list="publications"]

== Frequently Asked Questions ==

= How can I limit my list?  =

Use the following shortcode to show only 5 users: [peers_me list="users" limit="5"]

= Can I sort my list? =

Use the following shortcode to show the latest users on top: [peers_me list="users" on="created_at" sort="DESC"]

== Changelog ==

= 0.1 =
This version is the first release. You can list publications, users and groups.