picpuzzle
=========

Image Revealer by Matthew Weaver
imagepuzzle[at]tthu[dot]net

1. Select multiple images and number of boxes to overlay and submit.
2. Images will be resized based on browser window size. 
3. Images will be uploaded and stored in /images/ directory.
4. Images given random filenames to avoid conflicts.
5. The "next puzzle" will cycle through uploaded images and return to upload page when all images have been revealed.


It is recommended to add a cron job to remove old pictures to remove server bloat. The following will remove images older than 48 hours:
"find [yourdomain.com]/images/ -type f -mtime +2 -exec rm {} \;"


TODO:
- resize checking for portrait oriented screens
- better landing page
- upload progress bar
- more box options (user input)
- URL pasting for images
- randomised overlay colours
