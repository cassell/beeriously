#!/usr/bin/env bash
docker run --rm --network beeriously_default --volume `pwd`:/app --workdir /app beeriously_webpack yarn run encore dev