=== Plugin Name ===
Name: CM Email Blacklist
Contributors: CreativeMinds (http://plugins.cminds.com/)
Donate link: http://plugins.cminds.com/
Tags: Blacklist,Whitelist,E-mail,email,registration,domain,DNSBL,spam,block,SpamAssassin,Spam,register,beta,login,antispam,defence,whitelist,comments,comment,blacklist,anti-spam,spammer,spambot,antispambot,guard,security,advanced user management,anti spam users,anti-splog,appthemes,black hat,blackhat,block,block agents,block bot,block bots,block domains,block e-mails,block emails,block ip,block splog,block unwanted users,block user,block users,blog secure,clean database,clean splog,clean users,ip,ip info,ip information,no captcha,plugin,protect,protect registration,recaptcha,register,registration,secure blog,secure wordpress,secure wp,security,security questions,sign up,signup,spam blog,spam blogs,splog,sploggers,standard WordPress,untrusted,untrusted users,unwanted users,user management,user registration spam,user spam,users registration,spam prevention,website security,wp secure,wp security,wp-login.php,wp-register.php,wp-signup.php
Requires at least: 3.2
Tested up to: 3.5
Stable tag: 1.1.1

Block users using blacklists domain from registering to your WordPress site.

== Description ==
This plugin will check if a user trying to register to your WordPress site is using an email from a domain which is defined in blacklists. 

**Use-Cases**

* Beta - Control users in your beta release.
* Members Only - Restrict site registration from specific domains
* Control - Control sites users domains
* Spam - Prevent spam users from registration  


**Features**

* Allow registration only by invitation code
* Use a list of free email domains downloaded from SpamAssassin
* Use [DNSBL online service](http://www.spamhaus.org/zen/)
* Use user defined own domain Bloacklist and whitelist
* Admin can edit domain list
* Admin can define which combination of the above methods to use

**More About this Plugin**
	
You can find more information about CM Email Blacklist at [CreativeMinds Website](http://plugins.cminds.com/cm-email-blacklist/).


**More Plugins by CreativeMinds**

* [CM Super ToolTip Glossary](http://wordpress.org/extend/plugins/enhanced-tooltipglossary/) - Easily create Glossary, Encyclopedia or Dictionary of your terms and show tooltip in posts and pages while hovering. Many powerful features. 
* [CM Download manager](http://wordpress.org/extend/plugins/cm-download-manager) - Allow users to upload, manage, track and support documents or files in a directory listing structure for others to use and comment.
* [CM Answers](http://wordpress.org/extend/plugins/cm-answers/) - Allow users to post questions and answers (Q&A) in a stackoverflow style forum which is easy to use, customize and install. w Social integration.. 
* [CM Invitation Codes](http://wordpress.org/extend/plugins/cm-invitation-codes/) - Allows more control over site registration by adding managed groups of invitation codes. 
* [CM Multi MailChimp List Manager](http://wordpress.org/extend/plugins/multi-mailchimp-list-manager/) - Allows users to subscribe/unsubscribe from multiple MailChimp lists. 


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
= 1.1.1 =
* Update readme and plugin homepage

= 1.1 =
* Minor fix in styling
* Added verification of PHP version

= 1.0 =
* Initial release

