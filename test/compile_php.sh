#!/bin/bash

echo "Beginning\n\n" > results.txt
for file in ../regi/*
do
    echo "$file"
    php $file 2>> results.txt
done

echo
echo "******************************************************************"
echo "          ANY ERRORS WILL BE LISTED HERE"
echo
echo
echo
cat results.txt | grep "PHP Parse error"
echo "******************************************************************"
