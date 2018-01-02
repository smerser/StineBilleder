#!/bin/bash
# Using ImageMagick to create thumbnail gif files from image files
# Quote arg if using wildcard characters e.g. ./JPG2ICO.sh '*.jpeg'

# find . -iname "28_12__14_21_00.jpg" -maxdepth 1 -exec convert -auto-orient {} thumbs/{} \;

for file in $@
do
    convert $file --auto-orient # iPhone/iPad photos may display with incorrect rotatation
    name=$(echo $file| cut -d'.' -f1)
    #echo "Created: $name.ico"
    #convert -resize x16 -gravity center -crop 32x32+0+0 +repage $file -flatten -colors 256 -background transparent "./$name.ico"
    convert -define jpeg:size=50x50 $file -thumbnail 10000@ -gravity center -background transparent -extent 50x50 "./$name.gif"
done:
