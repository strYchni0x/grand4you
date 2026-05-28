=== Grand4You ===
Requires at least: 4.5
Requires PHP: 5.4
Tested up to: 6.1
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Grand4You is a fork of the Eksell theme by Anders Norén, extended with Fediverse social icons
(Mastodon, BlueSky, Pixelfed, Friendica), configurable numbered pagination, and other customizations.


== Installation ==

1. Upload the theme folder to wp-content/themes/
2. Activate the theme in Appearance → Themes


== Browser Support ==

Grand4You supports all modern browsers. Due to the lack of support for CSS variables in older
browsers (including Internet Explorer 11), some visual differences are to be expected there.


== How to Use the No Title Template ==

The Only Content Template hides all elements in the content area except the block editor content,
allowing you to create completely custom layouts. The site header, aside, and footer are still displayed.

1. Go to Pages → Add New or edit an existing page.
2. In the righthand sidebar, expand "Page Attributes", click the "Template" dropdown, and select
   "No Title Template".
3. Add your block editor content, then click "Publish" or "Update".


== How to Use the Blank Canvas Template ==

The Blank Canvas Template hides everything except the block editor content.

1. Go to Pages → Add New or edit an existing page.
2. Select "Blank Canvas Template" from the Template dropdown in Page Attributes.
3. Add your block editor content, then click "Publish" or "Update".


== How to Use the Blank Canvas with Menu Template ==

Shows the block editor content and the aside (navigation toggle) on the left side.

1. Go to Pages → Add New or edit an existing page.
2. Select "Blank Canvas with Menu Template" from the Template dropdown in Page Attributes.
3. Add your block editor content, then click "Publish" or "Update".


== Change Pagination Type ==

1. Go to Appearance → Customize → Theme Options → Archive Pages.
2. Four options are available:
   a. "Load more button" – Click to load more posts without a hard reload.
   b. "Load more on scroll" – Loads more posts when reaching the bottom.
   c. "Links" – Prev/next links with hard reload.
   d. "Numbered pages" – Numbered page links with a page counter. Set the desired number
      of posts per page in the "Posts per Page" field that appears below.


== Fediverse Social Icons ==

Add social menu links for Mastodon, BlueSky, Pixelfed, or Friendica via
Appearance → Menus. The icons are detected automatically from the link URL.
If your instance is not recognised, add it to the `$social_icons_map` array in
inc/classes/class-eksell-svg-icons.php.


== Change Colors ==

1. Go to Appearance → Customize → Colors.
2. Select the colors you want to use and click "Publish".


== Block Patterns ==

Grand4You includes block patterns available via the "+" button → Patterns in the block editor.


== Licenses ==

Grand4You is a fork of Eksell, Copyright (c) 2021-2023 Anders Norén.
Eksell is distributed under the terms of the GNU GPL version 2.0.
https://wordpress.org/themes/eksell/

Icons in the "UI" group by Anders Norén
License: Creative Commons Zero (CC0), https://creativecommons.org/publicdomain/zero/1.0/

Fediverse icons (Mastodon, BlueSky, Pixelfed) from Simple Icons
License: CC0 1.0, https://creativecommons.org/publicdomain/zero/1.0/
Source: https://simpleicons.org/

Public Sans font
License: SIL Open Font License 1.1, https://opensource.org/licenses/OFL-1.1
Source: https://fonts.google.com/specimen/Public+Sans/

css-vars-ponyfill
License: MIT, https://opensource.org/licenses/MIT
Source: https://github.com/jhildenbiddle/css-vars-ponyfill

Dot Pulse Loading Animation
License: MIT, https://opensource.org/licenses/MIT
Source: https://nzbin.github.io/three-dots/

Code from Twenty Twenty-One
Copyright (c) 2020-2021 WordPress.org
License: GPLv2
Source: https://wordpress.org/themes/twentytwentyone/


== Changelog ==

Version 1.0.0
-------------
- Initial release of Grand4You fork based on Eksell 1.9.5.
- Added Fediverse social icons: Mastodon, BlueSky, Pixelfed, Friendica.
- Social icons always visible in header on all screen sizes.
- Added "Numbered pages" pagination type with configurable posts-per-page and page counter.
