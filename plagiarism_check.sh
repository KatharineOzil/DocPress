#!/bin/bash

cd upload/$1/

if [ -f outfile ]
then
	rm -f outfile
fi
if [ -f outtree ]
then
	rm -f outtree
fi
/usr/local/bin/neighbor <<eof
y
y
eof

cp outtree intree

if [ -f plotfile ]
then
	rm -f plotfile
fi

/usr/local/bin/drawgram <<eof
/Library/WebServer/Documents/stu_task/fontfile
y
eof

cp plotfile plotfile.ps
export PATH=/usr/local/bin:/usr/bin:/bin:/usr/sbin:/sbin:/usr/local/git/bin
/usr/local/bin/convert plotfile.ps ../DrawT/$1.svg
/usr/local/bin/convert plotfile.ps $1.svg
