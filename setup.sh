# Create Wordpress Uploads Folder symlink
# New Project
git remote rm origin
projectname=`pwd | awk 'BEGIN {FS="/"} {print $NF}'`
username=`whoami`
git remote add origin git@localhost:$projectname.git
mkdir /var/www/wp-uploads/$projectname
chmod 777 /var/www/wp-uploads/$projectname

# Create link
ln -s /var/www/wp-uploads/$projectname wp/wp-content/uploads

sed -i "s/Theme Name: Cleanslate/Theme Name: $projectname/" wp/wp-content/themes/cleanslate/style.css
git mv wp/wp-content/themes/cleanslate wp/wp-content/themes/$projectname

cp wp/wp-config-sample.php wp/wp-config.php
sed -i "s/your_project_name/$projectname/" wp/wp-config.php
sed -i "s/your_user_name/$username/" wp/wp-config.php
sed -i "s/username_here/root/" wp/wp-config.php
sed -i "s/password_here/GuRuStu1881/" wp/wp-config.php
