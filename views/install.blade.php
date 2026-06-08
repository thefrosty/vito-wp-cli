#!/bin/bash

cd "$HOME"

# https://make.wordpress.org/cli/handbook/guides/installing/#recommended-installation
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar

# Quick verification using GPG:
curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar.asc
curl -L https://raw.githubusercontent.com/wp-cli/builds/gh-pages/wp-cli.pgp | gpg --import

if ! gpg --verify wp-cli.phar.asc wp-cli.phar; then
    rm -f wp-cli.*
    echo 'VITO_SSH_ERROR' && exit 1
fi

chmod +x wp-cli.phar
sudo mv wp-cli.phar /usr/local/bin/wp

wp --info
