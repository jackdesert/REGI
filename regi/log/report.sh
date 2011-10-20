# Check if there were any errors, and if so, mail them
if [ -s /home/hbboston/public_html/regi/log/php_errors.log ]
    then cat /home/hbboston/public_html/regi/log/php_errors.log | mail -s "PHP Errors in php_errors.log" jworky@gmail.com
fi


if [ -s /home/hbboston/public_html/regi/log/errorlog.log ]
    then cat /home/hbboston/public_html/regi/log/errorlog.log | mail -s "MySQL Errors in errorlog.log" jworky@gmail.com
fi

