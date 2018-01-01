#!/bin/bash

# BUILD COMMAND FILE LIST
touch sftp_batch
echo "cd 'StineBilleder/Fotos/2018/'" >> sftp_batch
for f in $@; do
  echo "put $f" >> sftp_batch
done

echo "bye" >> sftp_batch

sftp lotusregnbue.dk@ftp.lotusregnbue.dk < sftp_batch

# CLEAN
rm sftp_batch
