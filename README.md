Cleanslate is a base wordpress install and theme that we use as the basis for most of our websites. 
It handles some basic stuff for us and has many features that we use regularly. It is meant to be 
used frequently and modified as necessary when we find better ways of doing things.

Some features it provides:

* Cleanslate theme based on HTML5 boilerplate, which is more-or-less unstyled but includes some 
basic compass-based stylesheets which are assembled in a mobile-first fashion. In other words, the 
basic application.scss has the basic styling at the top, as you would like the site to work on a 
mobile device, and then has a media query for device width > 550px, which is where most of our 
styles would go. Since this approach has evolved over time, these stylesheets are not necessarily 
set up perfectly, so please keep the spirit in mind but build your stylesheets as you see fit. If 
you improve upon what's there, please consider incorporating those improvements back into this git 
repo. After you run setup.sh, cleanslate will be renamed to your project name.
* Cleanslate-Neue theme, a child of TwentyTwelve. It is meant to be a replacement for Cleanslate, 
removing most of the cruft and being based on a more modern codebase. After you run setup.sh, 
cleanslate-neue will be renamed to your project name-neue (ie, "foo-neue").
* a **wp-config-sample.php** that includes our block of custom code that makes our sites work 
correctly on the dev server.
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

Ideally, when new versions of Wordpress come out, you can update Cleanslate, commit & push it. 
Then on cleanslate-derived projects, you can do "git pull upstream master" to pull in the new
wordpress code and then run the upgrade. Every time I've tried this, it has worked just fine, but
YMMV with future wordpress upgrades. A small but signficant part of the reason for doing this is
so that when pulling in the new wordpress, you can remove the "Just another wordpress site" BS
from the code before updating wordpress on other sites, because if you don't have the subtitle
set it will put that in whether you like it or not. 

Also, when upgrading wordpress, you need to bring in the changes from wp-config-sample.php
so the setup script will work properly for new sites.