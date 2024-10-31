=== MyOrderDesk ===
Contributors: printreach
Tags: myorderdesk, printreach, order, order desk, web-to-print, portal, printers plan, pagepath
Requires at least: 5.0
Tested up to: 6.2.0
Stable tag: trunk
License: GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.en.html

This is a simple plugin that is used to make embedding a MyOrderDesk web page into WordPress faster and easier.

== Installation ==
For manual installation:

1. Upload the plugin files to the '/wp-content/plugins/' directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the MyOrderDesk screen to configure the plugin

== Frequently Asked Questions ==
= Setup =

To configure your plugin you need your MyOrderDesk Provider ID, site Hosted address, and your Wordpress configured landing page.

To find your Provider ID, log into your MyOrderDesk website with an administrator account. Open the administration menu by clicking the three horizontal lines in the top left corner of the screen.

You will see a dropdown menu that says "[#####] Your Company Name" The numbers inside of the square brackets will be your Provider ID.

Your Hosted Address can be found from the administration menu by visiting Site Settings > Home Page & Domains.

Your Landing Page is the Wordpress page that contains a shortcode for MyOrderDesk that handles incoming link requests. Typically this will be /w2p. This page should not be nested (/not/like/this).

Once you successfully enter your information, the page layout should change and you should see a list of shortcodes that can be used to display specific pages based on that Provider ID.

= Linking =

The final step of setup is putting the shortcode onto the respective pages that you want your site to appear on.

To do this, all you need to do is copy the [mod-xxxxxx] text, and paste it into the page that you want it to display on. The plugin will handle everything else for you, and it\'s that simple!

For more complex scenarios, where you want to embed specific order forms, catalgos, or use a branded site, you can implement that by changing the modifier designated to it.
[mod-orderform form="###"] is used to link specific order forms
[mod-catalog catalog="###"] is used to link specific catalogs
site="###" can be added to any shortcodes as well, to change what site is being displayed, rather than the master set in settings. This lets you link branded websites.

For the [mod-order] page, in some cases you may want to force the user to log in before they can view the page. For this, you can add "force" to the shortcode, like so: [mod-order force]

== Changelog ==
= 3.2.6 =
+Version URL Update

= 3.2.5 =
+Version Update

= 3.2.4 =
+Load MODSkinService directly from MyOrderDesk

= 3.2.3 =
+Added allow-popups-to-escape-sandbox iframe flag for Chromium

= 3.2.2 =
*Instructions updated and includes versioned

= 3.2.1 =
+Added option to changed hosted domain name and landing page

= 3.2.0 =
+Added iframe option for sandbox (Safari frame issues)
*Consolidated iframe code

= 3.1.2 =
+"force" is now a valid attribute for [mod-order]. Will force the user to log in before displaying the page.
*Fixed an issue where the "Locations" page would display when the user had an incorrect PID.

= 3.1.1 =
*Fixed a bug where old pages would display in the list (post_status = 'publish' was not being respected)

= 3.1 =
+"Locations" list can now search inside themefusion code blocks

= 3.0 =
+"Locations" section added. Lists all pages (that it can find in the database) with any of the shortcodes on it.
+Index.php for plugin folders. Disallows direct access.
+Support for branded sites via site="###" in all shortcodes.
*File structure subdivided (Majour change)
*Small performance increases

= 2.6.3 = 
*Compatibility for wordpress 5.0

= 2.6.2 =
*Stability changes

= 2.6.1 =
+Notify the user on the mod page when an update is released

= 2.6 =
*Fixed an issue where the iframe is generated at the top of the page no matter where the shortcode is inserted

= 2.5 =
+Email Notifications (w2p) sections
*Cleaned up notes

= 2.4 =
+Faq section
+Error message for invalid PID
*Expanded readme.txt
*Changed instruction link
*Changed how instruction link opens
*Changed plugin description

= 2.3 =
*Hid shortcode commands when the user does not enter a PID, or enters an invalid one.
*Forced numbers in the input box
*Sanitized the value field correctly
*Fixed a bug where you could not update your PID number
*Displayed instructions on how to locate your PID

= 2.2 =
*Made shortcode on the settings page a hyperlink to the respective pages.

= 2.1 =
*Fixed hardcoded plugin folder name
*Localized all files
*Enqueued all scripts

= 2.0 =
*Fixed generic function names
*Removed remote images
*Enqueued styles
*Set up a nonce for the data field
*Secured the variable for the MOD number
*Changed the plugin name

= 1.0 =
*Official Release

== Upgrade Notice ==
We are constantly rolling out updates with new features and security updates to keep you safe and help you save time.