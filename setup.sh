#!/bin/sh

touch .htaccess && chmod 777 .htaccess

# Create Wordpress Uploads Folder symlink
# New Project
git remote rm origin
projectname=`pwd | awk 'BEGIN {FS="/"} {print $NF}'`
username=`whoami`

echo $username


cp wp/wp-config-sample.php wp/wp-config.php
sed -i "s/database_name_here/$projectname/" wp/wp-config.php
sed -i "s/your_project_name/$projectname/" wp/wp-config.php
sed -i "s/username_here/root/" wp/wp-config.php
sed -i "s/your_user_name/$username/" wp/wp-config.php
sed -i "s/password_here/GuRuStu1881/" wp/wp-config.php


# Create link
[ ! -d /var/www/wp-uploads/$projectname ] && mkdir /var/www/wp-uploads/$projectname
[ ! -d /var/www/wp-uploads/$projectname ] && ln -s /var/www/wp-uploads/$projectname wp/wp-content/uploads


git remote add origin git@localhost:$projectname.git
git remote add upstream git@localhost:cleanslate.git

[ ! -d wp/wp-content/themes/$projectname ] && git mv wp/wp-content/themes/cleanslate wp/wp-content/themes/$projectname
sed -i "s/Theme Name: Cleanslate/Theme Name: $projectname/" wp/wp-content/themes/$projectname/style.css

chmod 777 /var/www/wp-uploads/$projectname

