# Grand4You

Grand4You is a feature-rich portfolio and blog theme, forked from [Eksell](https://wordpress.org/themes/eksell/) by Anders Norén. It adds Fediverse social icons, configurable numbered pagination, and other enhancements while keeping the full feature set of the original.

## Added Features

- **Fediverse social icons** in the header for Mastodon, BlueSky, Pixelfed, and Friendica — always visible on all screen sizes
- **Numbered pagination** with configurable posts-per-page and a page counter (Page X of Y)
- **Social icons always shown** in the header, not just on desktop

## Original Eksell Features

- Deep Gutenberg/block editor support with block styles and patterns
- Lazyloading category filter for posts and Jetpack Portfolio items
- Full color settings in the Customizer, including optional dark mode palette
- Blank Canvas page template
- Infinite scroll and load-more pagination options
- Optional search overlay
- Sticky header setting
- Social menu with icons, footer menu
- Custom logo support, custom post meta options
- Lightweight and developer-friendly code

## Installing

1. Copy the theme folder to `wp-content/themes/` in your WordPress installation.
2. Activate the theme via Appearance → Themes.

## Numbered Pagination

Go to **Appearance → Customize → Theme Options → Archive Pages** and select **"Numbered pages"** as the Pagination Type. Set the desired number of posts per page in the **"Posts per Page"** field. A page counter (Page X of Y) will appear below the numbered links.

## Fediverse Social Icons

Add your social links via **Appearance → Menus**. The icon is auto-detected from the URL domain. If your instance is not listed, add it to `$social_icons_map` in `inc/classes/class-eksell-svg-icons.php`.

## License

[GNU GPL v2](https://www.gnu.org/licenses/gpl-2.0.html) or later.  
© Florian Willnat. Fork of Eksell © Anders Norén.
