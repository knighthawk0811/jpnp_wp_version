=== JPNP Bot Stop ===
Contributors: Knighthawk
Donate link:
Tags: brute-force, bruteforce, login, register, registration, reset-password, form, security, protection, protect, block, bot
Requires at least: 3.5
Tested up to: 4.5
Stable tag: 2.0.201229
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Protection from Bots attempting Brute Force Attacks.

== Description ==

Forces Bots to try and prove they are human rather than using CAPTCHA to force humans to prove they are humans.


== Installation ==

1. Upload into the plugins directory
2. Activate the plugin on the Plugins page
3. Adjust the settings to your liking
4. Enjoy

== Frequently Asked Questions ==

= What is JPNP Bot-Stop? =

Originally based off of the Security-protection plugin.
I like this plugin, but I was looking for some more data so I customized it.
Eventually I added enough function and used it myself on enough sites that I thought more people might like this too.
This plugin requires a higher version of WordPress than the original Security Protection plugin because of my use of database storage.

= How does JPNP Bot-Stop plugin work in details? =

Two extra hidden fields are added to login, register and reset-password forms.
The first field is the invisible captcha (copy and paste the code) and is answered automatically with jQuery.
Second field should be left blank and is hidden by css and invisible to the user.
If the brute-force bot tries to submit the form, it will tend to get the first field wrong.
Additionally, bots don't typically leave empty fields, so it will also tend to get the second field wrong.
In either case, the bot will be stopped (if it fails any of these tests) even in the event where it gets a correct username and password.

= What are the settings? =
In the WP Settings tab you will find a "JPNP Bot Stop Pluging" link
From here you can set the:
Emergency Alert Email Address (email to send alerts to)
EA Time Limit
EA Count limit
(If "Count Limit" attempts are logged inside of "Time Limit" then an Emergency Alert Email will be sent.)


= What features might be coming soon? =
More actual settings on the setting page.
More usable data on the settings page.
Pagenation on the list of attacks.
The use of straight javascript rather than jQuery... just in case there is no jQuery on your site.
Random(ish) code generation for the copy paste field rather than the static XKCD password (Don't know what XKCD is? Google it, you are not likely to be disappointed.)

== Changelog ==

= 2.0.201229 =
* corrected 'send_successful_login_log_to_admin' to NOT store valid passwords.
* this was never used (thankfully) but would be a huge flaw if it were.
= 0.6.5 =
* 20160523
* added an install on date to the History section (along with a caveat at the bottom)
= 0.6.4 =
* 20160503
* working on removing the "via...server" in the email from address.
* show some popular password/user attempts
= 0.6.3 =
* 20151217
* revised the alert email information to be more relavent
= 0.6.2 =
* 20151016
* sorted the attack list based on number of attackes from an individual IP, so the most frequent offender is at the top of the list
* added version to alert email
= 0.6.1 =
* 20150921
* Added feature to show the number of attempts in the most recent time period set in the settings.
* Added (future) storage of attempted usernames and passwords for a future function
* set an intitial timestamp for the emergency alert, rather than just '0'
* Fixed bug where the first page load of settings shows empty values
* Fixed bug where old entries were not being deleted properly upon expiration
* Fixed bug where stored options would be overwritten upon plugin update
* Fixed bug showing error for undefind variable 'proxy' on settings page
* Security, added more sanitization
= 0.6 =
* 20150616
* corrected settings URL
= 0.5 =
* 20150419
* added some actual settings to the setting page (email, time limit, count limit)
* made plugin clean up after itself upon uninstall
= 0.4 =
* 20150416
* reduced emergency alerts to 1 per timeframe
* moved settings to the top of this file
= 0.3.1 =
* fixed a tiny typo in the emergency alert function where a > was misstyped as a <
* AAAAAAARG
= 0.3 =
* made the admin emailing false by default
* and put an emergency override in place that will send emails if a certain limit is reached inside of a certain time
= 0.2 =
* added database storage to show a list of the recently blocked attempts
= 0.1 =
* initial build via a customization of the Security Protection Plugin