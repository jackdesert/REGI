# See if there are any new errors
diff /home/hbboston/public_html/regi/log/php_errors.log /home/hbboston/public_html/regi/log/php_errors_prev.log > /home/hbboston/public_html/regi/log/php_errors_diff.log
cp /home/hbboston/public_html/regi/log/php_errors.log /home/hbboston/public_html/regi/log/php_errors_prev.log


# Check if there were any errors, and if so, mail them
if [ -s /home/hbboston/public_html/regi/log/php_errors_diff.log ]
    then cat /home/hbboston/public_html/regi/log/php_errors_diff.log | mail -s "New PHP Errors in php_errors.log" jworky@gmail.com
fi
