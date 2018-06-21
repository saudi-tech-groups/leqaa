#!/usr/bin/env bash

IMAGE=composer:1

docker run \
	--rm \
	-t \
	-v $PWD/:/app/ \
	-v ~/.composer:/tmp \
	$IMAGE \
	composer install \
		--ignore-platform-reqs \
		--prefer-dist \
		--no-interaction \
		--no-scripts
