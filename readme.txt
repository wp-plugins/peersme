=== Peers.me ===
Contributors: danielsteginga
Donate link: http://peers.me/
Tags: peers.me, community, API, groups, group conversation, forums, messaging, networking, profiles, social
Requires at least: 3.0.4
Tested up to: 3.1.2
Stable tag: 0.8

Peers.me is an group conversation tool for your company, school, sports team or community. This plugin makes it easy to access the public profiles and publications through the Peers.me API and display them in your WordPress site.

*NEW*

You can now create your FREE network account and personal account at www.peers.me. 

== Installation ==

1. Upload the `peersme` to the `/wp-content/plugins/` directory or install directly through the plugin installer.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Enter your Peers.me API credentials on the settings page
4. Create a page: 'users'. Make sure the slug is the same name. Place the following shortcode [peersme list="users"]
5. Create a page: 'groups'. Make sure the slug is the same name. Place the following shortcode [peersme list="groups"]
6. Create a page: 'publications'. Make sure the slug is the same name. Place the following shortcode [peersme list="publications"]
7. Select pages at the settings page.

You can change the paths for 'users', 'groups' and 'publications'. 

== Frequently Asked Questions ==

= Is there a open API for testing purposes? =

We've opened the API of our developers community on dev.peers.me. Just authenticate with username "dev" and password "633bf1c1".

= How can I limit my list?  =

Use the following shortcode to show only 5 users: [peersme list="users" limit="5"]

= Can I sort my list? =

Use the following shortcode to show the latest users on top: [peersme list="users" on="created_at" sort="DESC"]

= Is there a widget? =

We've developed a widget which let you configure resource, sorting and limiting. Just drag the Peers.me widget to a widget area and configure.

= Can I meet other developers using this plugin? =

Yes, we've got a developers community on http://dev.peers.me for ideas and questions. If you would like to signup, please mail me at daniel [at] peers.me.

= I get an error about some SSL stuff. What's the problem? =

Currently the API is connected over SSL. Some hostingproviders doesn't update their SSL Certicates archive. The connection tries to connect over this secure line by checking the certificate, but when this certificate isn't available we try to connect over SSL without the certificate but keep the connection encrypted.

== Changelog ==

= 0.8 =

Let you visitors create a wave with you by using the following short code:

[peersme create="wave" address="(your_wave_address)" email="(your_emailaddress_in_peers)"]

In the nearby future, we're going to change this feature and will only use the address. For now, make sure you fill in your email address.

= 0.7.2 = 

Temp fix for problem with error handling.

= 0.7.1 =

Problem fixed with ” in the examples on the settings page. Changed to ".

= 0.7 =

- Changed the method for connecting with the API. 
- The settings page will show information if your API credentials are wrong
- Changed also the used CSS classes in the templates and CSS

!! PLEASE MAKE NOTICE OF THE CSS CHANGE IF YOU USED THE CLASSES !!

= 0.6 =

Change to use the Peers.me API over HTTPS

= 0.5 =

Fixed some bugs with the widget.
Fixed problems with the CSS on the settings page.
Also a new 'login' widget which links to your peers.me inbox. This will be changed in future with a real login box.
Select pages (users, groups and publications) instead of entering a path

!! IMPORTANT UPDATE NOTICE !!
!! Make sure to update your settings by selecting the right pages !!

= 0.4 =

Added support for publications index for a specific address. You can use the shortcode [peersme list="publications" address="daniel"] 

Fixed some minor problems with defining variables and a problem with the check for duplicate published waves.

Also a new settings screen with our new getting started video.

= 0.3.1 =

Fixed problems with including the 'includes' folder

= 0.3 =

Some code cleanup and these features:
*   Filter groups on "Label"; eg. [peersme list="groups" label="Project"]
*   Customizable templates; copy default.tpl and rename and edit it. Choose your template from settings
*   Customizable stylesheet; copy default.css and rename and edit it. Choose your stylesheet from settings
*   Tags on publications
*   Filter publications on duplicate waves

It's also possible to make a ajax call to api.php. Just include jQuery like this:

`<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>`

And add this in your HTML:
`<div id="users"></div>`

And:

`<script type="text/javascript">
	var ajax_load = "<img src='/wp-content/plugins/peersme/loading.gif' alt='loading...' />";
	var loadUsers = "/wp-content/plugins/peersme/api.php?q=users";
	$(document).ready(function () {
		$("#users").html(ajax_load).load(loadUsers);
	});
</script>`


= 0.2 =
This version has templates and configurable username and password for the Peers.me API.
Also two widgets for users and groups.

= 0.1 =
This version is the first release. You can list publications, users and groups.