=== BBCode Shortcut ===
Contributors: Cristiano Fino
Donate link: http://www.cristianofino.net
Tags: bbcode, link, script, autoinsert, javascript, html ,css
Requires at least: 2.3.0
Tested up to: 2.7.1
Stable tag: 1.1.0

Replaces the BBCode (up to N) automatically defined with a snippet of HTML or Javascript

== Description ==

BBCode Shortcut allows you to define many token with one or more associated values. The tokens are replaced in the post with customized snippets of code where the variables (in the form {0}...{N}) are in turn replaced with the previous values.

Features:

1. You can define an unlimited number of BBCode and scripts associated with these
2. You can define for each BBCode, a number of parameters of your choice
3. You can define a piece of alternative code to correctly display the BBCode in the RSS feed
4. You can disable each BBCode

== Installation ==

1. Download `bbcode-shortcut` compressed file and deploy it on your hard disk
2. Upload `bbcode-shortcut` folder to the `/wp-content/plugins/` directory
3. Activate the plugin *BBCode Shortcut* through the 'Plugins' menu in WordPress

== Examples of Use ==

Define your BBCode through the control panel of the plugin, and enter them in the text of your post by using the following syntax. 

Es: 
your BBCode is **youtube** and has 1 parameter (the video's *key*). 
Write **[bbcode:*key*]** in your post, where *key* is the code of your selected video. 
When the post is displayed, the plugin replaces **[bbcode:*key*]** with the code to embed the selected video.

== Frequently Asked Questions ==

= How many BBcode I can define ? =
How many you want.

= How many parameters I can define ? =
How many you want. Separate with commas. Ex.: [mybbcode:abc, xyz, efg]

= How I can define parameters in script? =
If the parameters used in your BBCode are par-0, par-1, ... par-n, you can use in the script the variables {0}, {1}, ... {n} (in this order). 
{0} will be replaced by par-0, {1} will be replaced by par-1, etc.

= Why should I use the alternative code to display the BBCode in the RSS feed ? =
The tag <script>, <option>, <embed> and others are not allowed in the RSS feed and are not displayed. 
With this code, you can define a alternative mode to link or display of your embedded object.

= The BBCode are case sensitive ? =
Yes.

== Screenshots ==

None.

== Thanks to ==

[Gioxx](http://gioxx.org/) (Giovanni Solone) to idea and testing support

== Extra ==

The plugin has two BBCode predefined (but they can be modified at will):

- [screenweek: *key*] -> It will be replaced with the card "key" from ScreenWeek.it

- [youtube: *key*] -> It will be replaced with the video "key" from YouTube.com