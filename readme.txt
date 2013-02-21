=== Plugin Name ===
Name: CM Email Blacklist
Contributors: CreativeMinds (http://www.cminds.com/)
Donate link: http://www.cminds.com/plugins
Tags: Blacklist, Whitelist, E-mail, email, registration, domain, DNSBL, spam, block, SpamAssassin, Spam
Requires at least: 3.2
Tested up to: 3.5
Stable tag: 1.1

Block users using blacklists domain from registering to your WordPress site.

== Description ==
This plug will check if a user trying to register to your WordPress site is using an email from a domain which is defined in blacklists. 

The plug use several method to detect is domain is in blacklists:

Use a list of free email domains downloaded from SpamAssassin

Use [DNSBL online service](http://www.spamhaus.org/zen/)

Use user defined own domain Bloacklist and whitelist

**More About this Plugin**
	
You can find more information about CM Email Blacklist at [CreativeMinds Website](http://www.cminds.com/plugins/).


**More Plugins by CreativeMinds**

* [CM Enhanced ToolTip Glossary](http://wordpress.org/extend/plugins/enhanced-tooltipglossary/) - Parses posts for defined glossary terms and adds links to the static glossary page containing the definition and a tooltip with the definition. 

* [CM Multi MailChimp List Manager](http://wordpress.org/extend/plugins/multi-mailchimp-list-manager/) - Allows users to subscribe/unsubscribe from multiple MailChimp lists. 

* [CM Invitation Codes](http://wordpress.org/extend/plugins/cm-invitation-codes/) - Allows more control over site registration by adding managed groups of invitation codes. 


== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Manage your CM Email Blacklist from Left Side Admin Menu

Note: You must have a call to wp_head() in your template in order for the JS plugin files to work properly.  If your theme does not support this you will need to link to these files manually in your theme (not recommended).
PHP Version:  Plugin uses a structure which was introduced only with PHP 5.3.0. So if the version of PHP is lower Plugin does not work

== Frequently Asked Questions ==



== Screenshots ==

1. User interface of CM Email Blacklist Admin setting screen.
2. User Blacklist UI.
3. Error message which appears on login screen once domain is in blacklist.

== Changelog ==
= 1.1 =
* Minor fix in styling
* Added verification of PHP version

= 1.0 =
* Initial release

