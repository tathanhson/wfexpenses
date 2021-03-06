#!/usr/bin/env bash

# source repo
SOURCEPATH=${1}

# output folder no trailing slashes
OUTPUT=${2}

# Version number
version=${3}

if [ -z "$SOURCEPATH" ]
then
      echo "No source folder given"
      exit 0
fi


if [ -z "$OUTPUT" ]
then
      echo "No output folder given"
      exit 0
fi

if [ -z "$version" ]
then
      echo "Version number not given"
      exit 0
fi

# tempoary file location
temp=$(mktemp -d -t ci-XXXXXXXXXX)

# get variables
path=${SOURCEPATH}
zpath=${temp}/wfexpenses
output=${OUTPUT}/
fname=wfexpenses${version}

cd ${path}
echo "Running grunt updating scripts"
npm test

echo "Creating temp project"
mkdir -p ${temp}
cp -R ${path} ${temp}/${fname}

cd "${temp}"

echo "Coping files to temp"

cp -f ${fname}/index-production.php ${fname}/index.php
rm -rf ${fname}/assets/*
rm -rf ${fname}/protected/config/*
rm -rf ${fname}/protected/runtime/*

cd "${temp}" ..

echo "Creating archive"

tar --force-local -rf ${output}wfexpenses${version}.tar ${fname}/assets ${fname}/images ${fname}/protected ${fname}/public ${fname}/sql ${fname}/index.php ${fname}/.htaccess ${fname}/icon.ico
gzip -f ${output}wfexpenses${version}.tar

echo "Archive creation complete"
echo "Cleaning up assets"

rm -rf ${temp}/${fname}/
echo "All done..."

