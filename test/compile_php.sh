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
echo "Note: errors of the /Cannot modify header/ variety are due to "
echo "having whitespace after the closing ?> tag in a php file "
echo "that is being included in another file. Watch out! Such warnings"
echo "are deadly when they occur inside an Excel export. (Took me 3 hours to debug)"
echo "Suggestion: leave off the closing ?> tag"
echo
echo
cat results.txt | grep "PHP Parse error"
cat results.txt | grep "Cannot modify header"
echo "******************************************************************"
