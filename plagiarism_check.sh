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
/usr/local/bin/phylip/neighbor <<eof
y
y
eof

cp outtree intree

if [ -f plotfile ]
then
	rm -f plotfile
fi

/usr/local/bin/phylip/drawgram <<eof
/home/www/html/hupload/stu_task/fontfile
y
eof

cp plotfile plotfile.ps
convert plotfile.ps ../DrawT/$1.svg
