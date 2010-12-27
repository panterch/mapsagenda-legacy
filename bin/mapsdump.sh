#!/bin/sh

# dumps 2 years of maps events

cd ~/staging/src 
nice /usr/bin/python2.5 static.py 

rsync -a ~/staging/public/img/ ~/live/img/
rsync -a ~/staging/public/style/ ~/live/style/

