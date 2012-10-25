# Create Wordpress Uploads Folder symlink
# New Project
projectname=`pwd | awk 'BEGIN {FS="/"} {print $NF}'`
mkdir /var/www/wp-uploads/$projectname
chmod 777 /var/www/wp-uploads/$projectname

# Create link
ln -s /var/www/wp-uploads/$projectname wp/wp-content/uploads

sed -i "s/Theme Name: Cleanslate/Theme Name: $projectname/" wp/wp-content/themes/cleanslate/style.css > wp/wp-content/themes/cleanslate/style.css
mv wp/wp-content/themes/cleanslate wp/wp-content/themes/$projectname

