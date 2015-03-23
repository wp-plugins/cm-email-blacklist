=== Plugin Name ===
Name: CM Email Registration Blacklist
Contributors: CreativeMindsSolutions
Donate link: http://plugins.cminds.com/
Tags: Blacklist,Whitelist,E-mail,email,registration,domain,DNSBL,spam,block,SpamAssassin,Spam,register,beta,login,antispam,defence,whitelist,comments,comment,blacklist
Requires at least: 3.2
Tested up to: 4.1.1
Stable tag: 1.2

Block users using blacklists domain from registering to your WordPress site.

== Description ==
This plugin will check if a user trying to register to your WordPress site is using an email from a domain which is defined in blacklists taken from SpamAssassin free domains list (freemail_domains.cf). The plugin stop users using blacklisted domains from registering to your WordPress site, helping to avoid unwanted spammers, viruses and Malware. 



> #### Plugin Site
> * [Plugin Site](http://plugins.cminds.com/cm-email-blacklist/)
> * [Pro Version Detailed Features List](http://plugins.cminds.com/cm-email-blacklist/)

---

> #### Other Plugins By CM Plugins
> * [Plugin Catalog](https://plugins.cminds.com/)
> * [Free Plugins](https://profiles.wordpress.org/creativemindssolutions#content-plugins)

---

**Use-Cases**

* Beta - Control users in your beta release.
* Members Only - Restrict site registration from specific domains
* Control - Control sites users domains
* Spam - Prevent spam users from registration  

**Features**

* Use a list of free email domains downloaded from SpamAssassin
* Use user defined own whitelist
* Admin can edit domain list
* Admin can define which combination of the above methods to use
* Manually update domain list from spamassassin

> #### Pro Version Features
>
> In the Pro version we have added several methods to detect whether a domain is blacklisted in real time, which > means that hackers and spammers will NEVER be able to register to harm your website in any way! This is done 
> using the following detectors:
> * Using a list of free email domains downloaded from SpamAssassin
> * Using [DNSBL online service]
> * Using Blacklists and whitelists defined by the site administrator
>
> Plugin Pro Version Features
> * Log of denied registrations
> * Manually add domains to blacklist
> * Define errors message to show to users trying to register
> * Allow only Whitelisted domains to register


***Suggested Plugins by CreativeMinds**

* [CM Ad Changer](http://wordpress.org/plugins/cm-ad-changer/) - Manage, Track and Report Advertising Campaigns Across Sites. Can turn your Turn your WP into an Ad Server
* [CM Super ToolTip Glossary](http://wordpress.org/extend/plugins/enhanced-tooltipglossary/) - Easily creates a Glossary, Encyclopaedia or Dictionary of your website's terms and shows them as a tooltip in posts and pages when hovering. With many more powerful features.
* [CM Download Manager](http://wordpress.org/extend/plugins/cm-download-manager) - Allows users to upload, manage, track and support documents or files in a download directory listing database for others to contribute, use and comment upon.
* [CM MicroPayments](https://plugins.cminds.com/cm-micropayment-platform/) - Adds the in-site support for your own "virtual currency". The purpose of this plugin is to allow in-site transactions without the necessity of processing the external payments each time (quicker & easier). Developers can use it as a platform to integrate with their own plugins.
* [CM Video Tutorials](https://wordpress.org/plugins/cm-plugins-video-tutorials/) - Video Tutorials showing how to use WordPress and CM Plugins like Q&A Discussion Forum, Glossary, Download Manager, Ad Changer and more.
* [CM OnBoarding](https://wordpress.org/plugins/cm-onboarding/) - Superb Guidance tool which improves the online experience and the user satisfaction.


== Installation ==

1. Upload the plugin folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Manage your CM Email Blacklist from Left Side Admin Menu

Note: You must have a call to wp_head() in your template in order for the JS plugin files to work properly.  If your theme does not support this you will need to link to these files manually in your theme (not recommended).
PHP Version:  Plugin uses a structure which was introduced only with PHP 5.3.0. So if the version of PHP is lower Plugin does not work

== Frequently Asked Questions ==



== Screenshots ==

1. Login screen showing registration error message
2. Plugin labels settings
3. Free domains list and update option
4. User whitelist
5. Plugin General option
6. Domain tester

== Changelog ==
= 1.2 =
* Update  free domains update is now done on demand
* Update  added labels support
* Update  improved plugin settings

= 1.1.1 =
* Update readme and plugin homepage

= 1.1 =
* Minor fix in styling
* Added verification of PHP version

= 1.0 =
* Initial release

