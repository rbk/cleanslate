# Create Wordpress Uploads Folder symlink
# New Project
projectname=`pwd | awk 'BEGIN {FS="/"} {print $NF}'`
mkdir /usr/local/www/apache22/data/wp-uploads/$projectname
chmod 777 /usr/local/www/apache22/data/wp-uploads/$projectname

# Create link
ln -s /usr/local/www/apache22/data/wp-uploads/$projectname wp/wp-content/uploads