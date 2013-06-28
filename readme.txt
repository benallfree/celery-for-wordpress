=== Plugin Name ===
Contributors: benallfree
Tags: kickstarter, indiegogo, ecommerce, shopping, preorder, credit card, crowdfunding
Requires at least: 3.0.1
Donation Link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2JGUY2JBQSMVN
Tested up to: 3.5.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Celery for WordPress is a WordPress plugin to seamlessly integrate the Celery preorder platform into your WordPress posts and pages.

== Description ==

The [Celery preorder platform](http://trycelery.com) right from the comfort of WordPress? Yes please!

Celery allows you to accept credit card preorders safely and securely directly on your WordPress site, and charge your customers only when and if you are ready to ship.

Features:

* Easy-to-use shortcode tags to integrate Celery features into your WordPress posts and pages
* No SSL or merchant credit card account required - Celery handles everything
* Accept preorders for experimental products and services to gauge demand
* Display campaign progress bars to help visitors see your funding goals

== Installation ==

*This plugin requires a [Celery](http://trycelery.com) and [Stripe](http://stripe.com) account (Celery will help you sign up with Stripe)*

To install Celery for WordPress:

1. Go to your WordPress admin and choose `Plugins > Add New`.
1. Search for `celery` and install.
1. Activate the plugin

Note: Celery for WordPress is compatible with multisite mode. If you are running in multisite mode,
we recommend that you *do not* Network Activate the plugin unless it really does apply to all sites.
Each site will have its own configuration settings.

If you prefer, you can also download the plugin zip file here and install it manually by uploading it.

== Frequently Asked Questions ==

= What is a preorder campaign? = 

A preorder campaign allows you to being accepting orders before you are ready to ship. You accept credit cards now and charge
them only when you are ready to ship.

= What types of preorder campaigns are popular? =

Sites like Kickstarter and Indiegogo have popularized crowdfunded preorder campaigns. Instead of (or in addition to) one of those,
you may prefer extend your reach by running Celery on your WordPress site.

= Do I need an SSL certificate? =

No SSL is required. Celery presents as an IFRAME or overlay which is secured. You do not need to do anything.

= Do I need a merchant account like PayPal or Authorize.net? =

No. Celery partners with Stripe for credit card transactions. You need an account with both them.

= But I've done credit card stuff before. You definitely need an SSL cert and PCI complaince, right? =
No. Celery runs securely in an SSL IFRAME either inline or as a popup on your WordPress site. Your users' card information never
touches your site; it goes straight to Celery and then to Stripe. Stripe is the only one that stores card info. Stripe is a
[PCI Service Provider Level 1](https://stripe.com/help/security), the highest security standard in the industry.

= What does all this cost? =
Celery takes 2% and [Stripe takes 3%](https://stripe.com/us/help/pricing).

== Screenshots ==

1. The Celery popup. This is a sample preorder page that will pop up on your WordPress site when the user clicks your 'Order Now' button created with the `[celery-button]` shortcode.
2. Customers input credit card and preorder information without ever leaving your WordPress site or branding.
3. An example showing a preorder button linked to Celery using `[celery-connect]`.

== Changelog ==

= 1.0 =
* Initial version

