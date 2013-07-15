#
# do something for lunch the whole app
#

#delete all in asset
rm -rf ./assets/*
rm -rf ./protected/runtime/*

#set chmod
chmod -R 777 ./assets
chmod -R 777 ./protected/runtime
