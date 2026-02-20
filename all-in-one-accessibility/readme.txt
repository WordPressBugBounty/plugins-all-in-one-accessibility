=== All in One Accessibility ===
Plugin name: All in One Accessibility
Contributors: skynettechnologies
Tags: WCAG, ADA, EAA, IS 5568, Section 508
Requires at least: 4.9
Tested up to: 6.9
Stable tag: 1.18
License: GPLv2 or later
Requires PHP: 7.0

AI based Website Accessibility Solution Supporting ADA, WCAG 2.0, 2.1 & 2.2, Section 508, California Unruh Act and Other accessibility standards.

== Description ==
The [WordPress Accessibility Widget](https://www.skynettechnologies.com/wordpress-accessibility-plugin) - All in One Accessibility® gives businesses, agencies, non-profits, and organizations a quicker way to enhance accessibility on their WordPress websites.Built for the WordPress environment, the plugin adds an accessibility widget that supports WCAG 2.1, 2.2 guidelines, ADA, EAA, and Section 508 compliance, California Unruh, France RGAA, European EAA EN 301 549, UK Equality Act (EA), Spain UNE 139803:2012, Australian DDA, Israeli Standard 5568, Ontario AODA, Canada ACA, German BITV, Brazilian Inclusion Law (LBI 13.146/2015), JIS X 8341 (Japan), Italian Stanca Act, Indian RPwD Act, Switzerland DDA and other [web accessibility standards](https://www.skynettechnologies.com/accessibility-standards) requirements - helping improve usability for visitors with visual, motor, cognitive, and learning disabilities.

This [AI accessibility widget](https://www.skynettechnologies.com/all-in-one-accessibility) is ideal for websites built with WordPress themes, page builders, custom layouts, and multisite environments, offering quick, flexible, and scalable accessibility support.

**The features of WordPress WCAG ADA EAA accessibility module:**
* AI assisted enhancements including alternative text remediation, screen reader (voice can be customized) are the key features.
* Voice Navigation, Dictionary, Virtual Keyboard, Accessibility Profiles, Sign language Libras (Brazilian Portuguese) Custom Widget Color, Icon size, Position, Custom trigger setup, GA4 Tracking, Adobe Accessibility Analytics Tracking, custom accessibility statement link are the top features.
* Accessibility dashboard includes managing setting for customization of widget including size, icon, colors, position, user access management, widget open / close sound preferences, and more.
* Supports over 140 languages. Perfect for multilingual WordPress websites, global businesses, and sites serving diverse communities.

Explore the comprehensive [features of WP WCAG accessibility widget](https://www.skynettechnologies.com/sites/default/files/accessibility-widget-features-list.pdf).

**Why is this WP accessibility widget the preferred choice for WordPress websites?**

* Works seamlessly with classic themes, block themes, and most page builders (Elementor, Divi, Beaver Builder, Gutenberg, WPBakery, Astra, Kadence, Oxygen, Bricks, etc.).
* The WP accessibility module enhances accessibility across pages, posts, WooCommerce stores, landing pages, blogs, and custom templates.
* Compatible with WordPress multisite - individual sites can configure their own settings.
* It requires minimal setup and can be managed directly from the WordPress dashboard, requires no code changes, and adapts automatically to theme updates.




**Security and privacy aligned**

* It follows data protection and security practices aligned with: ISO 9001: 2015, ISO 27001: 2022, GDPR, CCPA, COPPA, HIPAA, and SOC 2 Type II.
* Skynet Technologies USA LLC is an organizational member of IAAP and of W3C.
* This helps to maintain accessibility features while respecting privacy, data protection, and security expectations required in many U.S. and international sectors such as healthcare, education, and public services.
* No personal data is intentionally stored by the module itself.
* Site owners are responsible for reviewing their own compliance requirements.

This helps meet expectations for industries like healthcare, education, government, and enterprise operations.

**Who does this WordPress accessibility plugin help?**

* It is suitable for small and mid-size businesses, ecommerce/WooCommerce stores, nonprofits and community organizations, schools, universities, and educational institutions, healthcare providers, government and public sector websites, enterprises managing large scale WordPress environments, agencies delivering accessible WordPress builds for clients.

For more details, visit [WordPress accessibility plugin](https://www.skynettechnologies.com/wordpress-accessibility-plugin).

**Installation**

* <strong>Prerequisites</strong>
 * WordPress 4.9 or above
* <strong>Steps</strong>
 * Check out our [WordPress WCAG Accessibility plugin](https://www.skynettechnologies.com/blog/wp-accessibility-widget-installation-guide) installation steps blog
* <strong>Add Script</strong>
 Place the following script in the header or footer section of your website or frontend:
 * **Option A: Plain HTML**
      Place this script before the closing </body> tag (or in the footer template). The script loads the widget after a short delay to avoid blocking page rendering.
><strong>&lt;script id="aioa-adawidget" src="https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode=#420083&token=&position=bottom_right"&gt;&lt;/script&gt;</strong>

 * **Option B: React/Next.js**
      Add this to a client component (e.g., your layout or a top-level page).
> <strong>&lt;script&gt;
    function load_aioa_script() { let aioa_script_tag = document.createElement(&quot;script&quot;);
        aioa_script_tag.id = &quot;aioa-adawidget&quot; aioa_script_tag.src = &quot;https://www.skynettechnologies.com/accessibility/js/all-in-one-accessibility-js-widget-minify.js?colorcode=#420083&amp;token=&amp;position=bottom_right&quot;        document.getElementsByTagName(&quot;head&quot;)[0].appendChild(aioa_script_tag); } setTimeout(() =&gt; {
        load_aioa_script(); }, 5000); &lt;/script&gt;
</strong>

* <strong>WordPress Accessibility DEMO URL</strong>
[https://wp.skynettechnologies.us](https://wp.skynettechnologies.us/)

* <strong>CORS Policy Configuration</strong>
To avoid CORS policy issues, ensure the following URLs are allowed in your website. These URLs should be added to your CORS configuration or trusted domains list.
> **Allowed Domains**
>
> - **https://*.skynettechnologies.com**  
>   *Description:* Skynet Technologies (Global Domain)  
>   *Usage:* API access and resources
>
> - **https://*.skynettechnologies.us**  
>   *Description:* Skynet Technologies (US Domain)  
>   *Usage:* API access and resources
>
> - **https://*.googleapis.com**  
>   *Description:* Google APIs  
>   *Usage:* Services like Fonts, Translation
>
> - **https://*.gstatic.com**  
>   *Description:* Fonts APIs  
>   *Usage:* Custom Fonts
>
> - **https://vlibras.gov.br**  
>   *Description:* VLibras - Brazilian Sign Language Service  
>   *Usage:* Sign Language

* <strong>Instructions</strong>
1.	Update your server's CORS configuration to include these URLs.
2.	Ensure wildcard subdomains (*) are supported where necessary.
3.	Verify the application functionality by testing requests to these domains.
4.	If issues persist, consult the documentation for CORS configuration guidance.


**Documentation**

* [WordPress Accessibility Plugin](https://www.skynettechnologies.com/wordpress-accessibility-plugin)
* [How to install WP accessibility Plugin](https://www.skynettechnologies.com/blog/wp-accessibility-widget-installation-guide)
* [Top WordPress Accessibility Plugin - Features Guide](https://www.skynettechnologies.com/sites/default/files/accessibility-widget-features-list.pdf)

**Submit a Support Request**
Please visit our [support page](https://www.skynettechnologies.com/report-accessibility-problem) and fill out the form. Our team will get back to you as soon as possible.

**Send Us an Email**
Alternatively, you can send an email to our support team: [hello@skynettechnologies.com](mailto:hello@skynettechnologies.com)

**WP accessibility widget paid add-ons**

* <strong>[WordPress Manual Accessibility Audit](https://www.skynettechnologies.com/website-accessibility-audit)</strong>
 * Enhance inclusivity and user experience by evaluating your website’s accessibility by accessibility experts.
 * WCAG 2.0 / WCAG 2.1 / WCAG 2.2 Level AA conformance testing
 * Automated, semi-automated testing
 * Manual testing
 * Simple before-after UI/UX recommendations on how to fix the issues
 * Comprehensive audit report

* <strong>[WordPress Manual Accessibility Remediation](https://www.skynettechnologies.com/full-website-accessibility-remediation)</strong>
 * Enhance website accessibility and inclusivity with our Manual Accessibility Remediation add-on. This service includes fixing accessibility issues and thorough remediation of your website manually. Our experts ensure accessibility with WCAG standards, improve user experience for those with disabilities, and provide a detailed report on the improvements made.

* <strong>[WordPress PDF / Document Accessibility Remediation](https://www.skynettechnologies.com/pdf-accessibility-remediation)</strong>
 * The PDF / Document Remediation provides a list of inaccessible PDFs and remediated PDFs from where you can request PDF remediation service.

* <strong>[WordPress website VPAT /ACR report service](https://www.skynettechnologies.com/vpat-accessibility-conformance-report)</strong>
 * The Voluntary Product Accessibility Template (VPAT), also known as an ACR (Accessibility Conformance Report) starts with an audit and provides current details for an accessible website, application, or any other digital assets.

* <strong>[WordPress White Label Accessibility](https://www.skynettechnologies.com/all-in-one-accessibility/addons#accessibility-widget-add-ons)</strong>
 * Remove the Skynet Technologies logo as well as all of the footer links, popups, report a problem link and more for full white label control.
* <strong>[WP site live translations](https://www.skynettechnologies.com/all-in-one-accessibility/addons#accessibility-widget-add-ons)</strong>
 * Translate your site into over 140 languages instantly to enhance accessibility for non-native speakers, individuals with language acquisition difficulties, and those with learning disabilities.
* <strong>[Modify Accessibility Menu for WordPress website](https://www.skynettechnologies.com/all-in-one-accessibility/addons#accessibility-widget-add-ons)</strong>
 * Build and fine-tune your widget with the Modify Menu option. Reorder, remove and restructure the widget buttons to fit your users’ specific accessibility needs.

**Accessibility Partnership Opportunities**

* <strong>[WordPress Accessibility Agencies Partnership](https://www.skynettechnologies.com/agency-partners)</strong>
    Partner with us as an agency to provide comprehensive accessibility solutions to your clients. Get access to exclusive resources, training, and support to help you implement and manage accessibility features effectively.

* <strong>[WordPress Accessibility Affiliated Partnership](https://www.skynettechnologies.com/affiliate-partner)</strong>
  Join our affiliate program and earn commissions by promoting All in One Accessibility®. Share our Widget with your network and help businesses improve their website accessibility while generating revenue.

For more details, please visit [Accessibility Partnership Opportunities](https://www.skynettechnologies.com/partner-program) Page

== Third Party Libraries ==

This plugin bundles jscolor (https://jscolor.com)  
License: GPLv3

== External Services ==

This plugin connects to external services operated by Skynet Technologies to provide automated accessibility scanning, widget rendering, and accessibility feature processing. These services perform real-time processing on external servers that cannot be reasonably performed locally within WordPress.

1. Service: ADA Widget Platform API  
   Domain: https://ada.skynettechnologies.us  
   Purpose: Performs server-side processing required to generate and manage the accessibility widget, register the site domain, and apply widget configuration changes.  
   Data Sent: Site URL and plugin configuration options when the plugin is activated or when settings are updated.  
   Terms of Service: https://www.skynettechnologies.com/terms-conditions  
   Privacy Policy: https://www.skynettechnologies.com/privacy-policy  

2. Service: ADA Add-User-Domain API  
   Domain: https://ada.skynettechnologies.us/api/add-user-domain  
   Purpose: Registers the site domain with the accessibility platform so that automated accessibility processing and widget services can be provided.  
   Data Sent: Site domain name.  
   Terms of Service: https://www.skynettechnologies.com/terms-conditions  
   Privacy Policy: https://www.skynettechnologies.com/privacy-policy  

3. Service: ADA Widget Script Hosting  
   Domain: https://www.skynettechnologies.com  
   Purpose: Delivers JavaScript and SVG assets required to render the accessibility widget on the front end.  
   Data Sent: None. (Static assets only)  
   Terms of Service: https://www.skynettechnologies.com/terms-conditions  
   Privacy Policy: https://www.skynettechnologies.com/privacy-policy  

4. Service: Widget Setting Update Platform API  
   Domain: https://ada.skynettechnologies.us/api/widget-setting-update-platform  
   Purpose: Processes and applies widget configuration changes on the accessibility platform servers.  
   Data Sent: Plugin configuration settings when saved by the site administrator.  
   Terms of Service: https://www.skynettechnologies.com/terms-conditions  
   Privacy Policy: https://www.skynettechnologies.com/privacy-policy  


==Screenshots==
1. Supports 140 languages and 70 plus features
2. 9 Personalize Accessibility Profile
3. Voice Navigation
4. Flexible Widget Options
5. Supports 51 plus accessibility standards
6. Security and Compliance
7. Automated Scanning Report and Accessibility Score


**WordPress Accessibility Widget Demo Video**
[youtube https://www.youtube.com/watch?v=X70XtvGyvSs]

== Frequently Asked Questions ==
= Is this accessibility plugin compatible with WordPress multisite? =
Yes

= Does it support multilingual WordPress sites? =
Yes. The widget supports 140+ languages, and works seamlessly with WordPress multilingual setups, including WPML, Polylang, and core language packs. The interface automatically adapts to the preferred language of the user when available.

= Is it compatible with all WordPress themes and page builders? =
Yes. It works with most WordPress themes, and builders, including Elementor, Divi, Gutenberg, Beaver Builder, Avada, Astra, GeneratePass, and other custom themes.

= Does this plugin work with WooCommerce? =
Absolutely

= Supported Languages (140+ Languages) =
English (USA), English (UK), English (Australian), English (Canadian), English (South Africa), Español, Español (Mexicano), Deutsch, عربى, Português, Português (Brazil), 日本語, Français, Italiano, Polski, Pусский, 中文, 中文 (Traditional), עִברִית, Magyar, Slovenčina, Suomenkieli, Türkçe, Ελληνικά, Latinus, Български, Català, Čeština, Dansk, Nederlands, हिंदी, Bahasa Indonesia, 한국인, Lietuvių, Bahasa Melayu, Norsk, Română, Slovenščina, Svenska, แบบไทย, Українська, Việt Nam, বাঙালি, සිංහල, አማርኛ, Hmoob, မြန်မာ, Eesti keel, latviešu, Cрпски, Hrvatski, ქართული, ʻŌlelo Hawaiʻi, Cymraeg, Cebuano, Samoa, Kreyòl ayisyen, Føroyskt, Crnogorski, Azerbaijani, Euskara, Tagalog, Galego, Norsk Bokmål, فارسی, ਪੰਜਾਬੀ, shqiptare, Hայերեն, অসমীয়া, Aymara, Bamanankan, беларускі, bosanski, Corsu, ދިވެހި, Esperanto, Eʋegbe, Frisian, guarani, ગુજરાતી, Hausa, íslenskur, Igbo, Gaeilge, basa jawa, ಕನ್ನಡ, қазақ, ខ្មែរ, Kinyarwanda, Kurdî, Кыргызча, ພາສາລາວ, Lingala, Luganda, lëtzebuergesch, македонски, Malagasy, മലയാളം, Malti, Maori, मराठी, Монгол, नेपाली, Sea, ଓଡିଆ, Afaan Oromoo, پښتو, Runasimi, संस्कृत, Gàidhlig na h-Alba, Sesotho, Shona, سنڌي, Soomaali, basa Sunda, kiswahili, тоҷикӣ, தமிழ், Татар, తెలుగు, ትግሪኛ, Tsonga, Türkmenler, Ride, اردو, ئۇيغۇر, o'zbek, isiXhosa, יידיש, Yoruba, Zulu, भोजपुरी, डोगरी, कोंकणी, Kurdî, Krio, मैथिली, Meiteilon, Mizo tawng, Sepedi, Ilocano, دری


== Changelog ==

= 1.18 =
* Update a plugin as per wordpress guideline, remove licence-key field and updated readme.

