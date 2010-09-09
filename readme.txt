=== hreflang Flag ===
Contributors: julienvdg
Donate link: http://silicone.homelinux.org/
Tags: flag, flags, css, hreflang, lang, language
Requires at least: 2.7
Tested up to: 3.0.1
Stable tag: trunk

Add a flag icon to link corresponding to the hreflang attribute.

== Description ==

hreflang Flag plugin uses [css3 selectors](http://www.w3.org/TR/css3-selectors/#attribute-selectors "W3C CSS3 Attribute selectors description") to add a flag icon to your links depending on their [hreflang attribute](http://www.w3.org/TR/html401/struct/links.html#adef-hreflang "hreflang attribute description on W3C").

This is really useful if you regularly link to pages in other languages and you want to inform your visitors about the language of the link target.

It's even more useful if your own blog is multilingual.

== Installation ==

1. Upload the `hreflang-flag` directory to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to setting -> hreflang Flag configuration and configure the flags you want to see (some sample flags are already filled in).
1. Use the [hreflang attribute](http://www.w3.org/TR/html401/struct/links.html#adef-hreflang "hreflang attribute description on W3C") in the links you want to see flags.

== Frequently Asked Questions ==

= I have external link icon the way wikipedia does it, is it compatible with hreflang Flag ? =
Well, no :( 

hreflang Flag uses the same technique of setting the css background of the a tag, so the displayed icon will be the last css match (probably the flag) you have to choose one.
There could be a possibility as described here: http://www.quirksmode.org/css/multiple_backgrounds.html
but this only work on webkit based browser. However this is not implemented in hreflang Flag now.

= More questions ? =

Please see plugin homepage: http://silicone.homelinux.org/projects/hreflang-flag

Or search wordpress.org Forums.

== Screenshots ==

1. Sample flagged links.

== Changelog ==

= 1.1 =
* configuration is not reseted after re-enabling the plugin anymore.

= 1.0 =
* initial release
