#!/usr/bin/env bash

packages=(Customer Message Scheduler)

for package in ${packages[@]}; do
        echo "testing ${package}"
        cd ${package}
        bin/phpspec run
        cd ..
done

exit 0