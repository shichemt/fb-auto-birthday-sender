Facebook Auto Birthday Sender
==============

We all have a lot of Facebook friends and sometimes we do not have time to send 'Happy Birthday' wishes to them. This script is made for that purpose. **Auto-Pilot your happy-birthday-wishes to your Facebook friends**

Tl;dr: Send generic 'Happy Birthday' private message to your Facebook friends when their birthday come. 

Requirements:
-------------

- XAMP server / WAMP server
- PHP (Obviously)
- cURL (because file_get_contents is terrible)
- Windows Task Scheduler / Schtaks (Windows people) | Cron (Linux people)
- Facebook account


How does it work?
------------------

- You need your user ID and XS from Facebook. You can get those from your Facebook cookie.
- Add the command below in crontab or Windows Task Scheduler.
> php -q FacebookAccount.php



**THE END. Thanks for coming!**<br/>

Any suggestions, questions, comments, feedbacks send them to my email address: my_username@live.com
