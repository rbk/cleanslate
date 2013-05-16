#!/bin/sh

# set up the htaccess so you can use the permalinks admin
# page without it chiding you for not having your htaccess
# editable
touch .htaccess && chmod 777 .htaccess

# remove original git origin
git remote rm origin

# figure out the project name from the directory structure
projectname=`pwd | awk 'BEGIN {FS="/"} {print $NF}'`
# and username for the wp-config.php
username=`whoami`

# set up the wp-config.php
cp wp/wp-config-sample.php wp/wp-config.php
sed -i "s/database_name_here/$projectname/" wp/wp-config.php
sed -i "s/your_project_name/$projectname/" wp/wp-config.php
sed -i "s/username_here/root/" wp/wp-config.php
sed -i "s/your_user_name/$username/" wp/wp-config.php
sed -i "s/password_here/GuRuStu1881/" wp/wp-config.php


# Create Wordpress Uploads Folder symlink if they don't already exist.
[ ! -d /var/www/wp-uploads/$projectname ] && mkdir /var/www/wp-uploads/$projectname
[ ! -d /var/www/wp-uploads/$projectname ] && ln -s /var/www/wp-uploads/$projectname /home/~$username/wp/wp-content/uploads
chmod 777 /var/www/wp-uploads/$projectname

# set up the new git remotes. "origin" will be the current project's repo
# in gitlab, and "upstream" will be cleanslate, so you can pull in changes
# from it with "git pull upstream master"
git remote add origin git@gurustudev.com:webprojects/$projectname.git
git remote add upstream git@gurustudev.com:gurustu/cleanslate.git

# rename the cleanslate themes.  
[ ! -d wp/wp-content/themes/$projectname ] && git mv wp/wp-content/themes/cleanslate wp/wp-content/themes/$projectname
sed -i "s/Theme Name: Cleanslate/Theme Name: $projectname/" wp/wp-content/themes/$projectname/style.css

[ ! -d wp/wp-content/themes/$projectname-neue ] && git mv wp/wp-content/themes/cleanslate-neue wp/wp-content/themes/$projectname-neue
sed -i "s/Theme Name: cleanslate-neue/Theme Name: $projectname-neue/" wp/wp-content/themes/$projectname-neue/style.css