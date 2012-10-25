Cleanslate is a base wordpress install and theme that we use as the basis for 
most of our websites. It handles some basic stuff for us and has many features 
that we use regularly. It is meant to be used frequently and modified as 
necessary when we find better ways of doing things.

Some features it provides:

* Cleanslate theme based on HTML5 boilerplate, which is more-or-less unstyled 
but includes some basic compass-based stylesheets which are assembled in a 
mobile-first fashion. In other words, the basic application.scss has the 
basic styling at the top, as you would like the site to work on a mobile device, 
and then has a media query for device width > 550px, which is where most of our s
tyles would go. Since this approach has evolved over time, these stylesheets are 
not necessarily set up perfectly, so please keep the spirit in mind but build 
your stylesheets as you see fit. If you improve upon what's there, please 
consider incorporating those improvements back into this git repo.
* a **wp-config-sample.php** that includes our block of custom code that makes our sites work correctly on the dev server.
* **setup.sh**, which automatically sets up a lot of junk we have to do every time we set up a site.
* Prevents the "just another wordpress site" BS that was easy to miss until a site went live.
* New Post Type and Mailchimp widget plugins that we use frequently
* Rotator javascript. Works, but needs to be updated or replaced with something better.
* A version of Modernizr to fix a lot of cross-browser problems for us before we even encounter it 
* and more!

Basic instructions for use:

* cd public_html
* git clone git@localhost:cleanslate.git mynewproject
* cd mynewproject
* sh setup.sh

Then you can run the wordpress install, log in as admin, and select your new theme.