
Facebook Auto Birthday Sender v0.3
==============



We all have a lot of Facebook friends and sometimes we do not have time to send 'Happy Birthday' wishes to them. This script was made for that purpose. **Auto-Pilot your happy-birthday-wishes to your Facebook friends**

Tl;dr: Send generic 'Happy Birthday' private message to your Facebook friends on their birthday. 

*Last Update: 05/07/2020*

Change Log:
-------------
- v0.3 - 20200507 : Ported the script to Python.
- v0.2 - 20200406 : Fixed couple bugs
- v0.1 - 20160605:  Initial release

Requirements:
-------------

- XAMP server / WAMP server
- PHP *and cURL* **OR** Python
- Windows Task Scheduler / Schtasks (Windows people) | Cron (Linux people)
- Facebook Account

How does it work?
------------------

- You need your user ID and XS from Facebook. You can get those from your Facebook cookie.
- Add the command below in crontab or Windows Task Scheduler.

 **PHP Version**
> php -q FacebookAccount.php 

 **Python Version**
> python FacebookAccount.py


FAQ
------------------

- **Problem**: It stopped working after couple days, what happened?
- **Solution**: In order for the script to work for an extended amount of time (say a month), you have to remain logged in using the same session.

- **Problem**: It seems like my Facebook account got locked out. Can you please advise?
- **Solution**: Looks like you were using the script to spam other people. Use at your own risk.


**THE END. Thanks for coming!**

Any suggestions, questions, comments, feedback send them to my email address: my_username@live.com
