#bin/bash

echo "$(tput setaf 7)Running Start.sh"

# kill apache to end cUrl if stuck in loop 
echo "$(tput setaf 3)Apache Processes:"
ps aux | grep -i apache2

echo "$(tput setaf 1)Killing Apache"

if killall apache2 ; then
    echo "$(tput setaf 2)Apache2 PIDs Killed"
else
    echo "$(tput setaf 1)Apache2 Didn't Die !!!!!!"
fi

if systemctl restart apache2 ; then
    echo "$(tput setaf 2)Apache Successfully Restarted"
else
    echo "$(tput setaf 1)Restart Failed"
    systemctl status apache2
fi

# cUrl API to rebuild json results.
echo "cUrl'ing API Results"
if curl -d api=get_fonts localhost/api/cron.php ; then
    echo "$(tput setaf 2)Received Fonts .json"
else
    echo "$(tput setaf 1)FAILED to Receive Fonts .json"
fi

if curl -d api=listcolors localhost/api/cron.php ; then
    echo "$(tput setaf 2)Received Colors .json"
else
    echo "$(tput setaf 1)FAILED to Receive Colors .json"
fi

if curl -d api=listsizes localhost/api/cron.php ; then
    echo "$(tput setaf 2)Received Sizes .json"
else
    echo "$(tput setaf 1)FAILED to Received Sizes .json"
fi

if curl -d api=listcategories localhost/api/cron.php ; then
    echo "$(tput setaf 2)Received Categories .json"
else
    echo "$(tput setaf 1)FAILED to Receive Categories .json"
fi

if curl -d api=listbrands localhost/api/cron.php ; then
    echo "$(tput setaf 2)Received Brands .json"
else
    echo "$(tput setaf 1)FAILED to Receive Brands .json"
fi

echo "$(tput setaf 5)Script Complete"
