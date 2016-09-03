#!/bin/bash

vendor/bin/schema generate-types ./ schemas/jobs.yml

if [ $? -eq 0 ]; then

    cp -r ./JobApis/Jobs/Client/* ./src 2> /dev/null

    if [ $? -eq 0 ]; then

        rm -rf ./JobApis 2> /dev/null

        if [ $? -eq 0 ]; then

            echo "Created schema classes and copied to ./src"

        else

            echo "Failed to remove ./JobApis/Jobs/Client directory"

        fi

    else

        echo "Failed to copy code from ./JobApis/Jobs/Client to ./src"

    fi

fi
