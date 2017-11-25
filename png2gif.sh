#!/bin/bash
# Using ImageMagick to create icon/gif files from image files
# Quote arg if using wildcard characters e.g. ./JPG2ICO.sh '*.jpeg'

for file in $@
do
    name=$(echo $file| cut -d'.' -f1)
    #echo "Created: $name.ico"
    #convert -resize x16 -gravity center -crop 32x32+0+0 +repage $file -flatten -colors 256 -background transparent "./$name.ico"
    convert -define jpeg:size=50x50 $file -thumbnail 10000@ -gravity center -background transparent -extent 50x50 "./$name.gif"
done
