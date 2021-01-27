<?php
/******************************
Plugin Name: JPNP Bot Stop
Plugin URI: http://neathawk.us
Description: Protection from Bots attempting Brute Force Attacks.
Version: 2.0.201229
Author: Joseph P. Neathawk
Author URI: http://neathawk.us
License: GPLv3
//*/

if ( !defined('ABSPATH') )
{
	die ( 'No direct script access allowed' );
}
//update settings
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
	//var_dump($_POST);
	if(!empty($_POST['jpnp_botstop_emergency_email']))
	{
		if(is_email($_POST['jpnp_botstop_emergency_email']))
		{
			update_option('jpnp_botstop_emergency_email', sanitize_email($_POST['jpnp_botstop_emergency_email']));
		}
	}

	if(!empty($_POST['jpnp_botstop_emergency_alert_time_limit']))
	{
		if(is_numeric($_POST['jpnp_botstop_emergency_alert_time_limit']))
		{
			update_option('jpnp_botstop_emergency_alert_time_limit', intval($_POST['jpnp_botstop_emergency_alert_time_limit']));
		}
	}

	if(!empty($_POST['jpnp_botstop_emergency_alert_count_limit']))
	{
		if(is_numeric($_POST['jpnp_botstop_emergency_alert_count_limit']))
		{
			update_option('jpnp_botstop_emergency_alert_count_limit', intval($_POST['jpnp_botstop_emergency_alert_count_limit']));
		}
	}
}

//default variables
$jpnp_botstop_version = '0.6.5';
$jpnp_botstop_db_version = '3.1';

$botstop_arr = array(
	'send_brute_force_log_to_admin' => false,
	'send_successful_login_log_to_admin' => false,
	'code' => 'correcthorsebatterystaple',
	'emergency_email' => get_option('jpnp_botstop_emergency_email', get_option('admin_email')),
	'emergency_alert_time_limit' => get_option('jpnp_botstop_emergency_alert_time_limit',0),
	'emergency_alert_count_limit' => get_option('jpnp_botstop_emergency_alert_count_limit',0)
);

//put up a setting page
function JPNP_botstop_plugin_setting_page()
{
	//just in case this hasn't been done
	JPNP_botstop_plugin_create_sql();
	//
	global $wpdb;
	global $jpnp_botstop_version;
	global $botstop_arr;
	$botstop_arr['emergency_email'] = get_option('jpnp_botstop_emergency_email', get_option('admin_email'));
	$botstop_arr['emergency_alert_time_limit'] = get_option('jpnp_botstop_emergency_alert_time_limit',0);
	$botstop_arr['emergency_alert_count_limit'] = get_option('jpnp_botstop_emergency_alert_count_limit',0);

	//total attempts in the designated settings
	$timestamp_past = max((current_time('timestamp') - $botstop_arr['emergency_alert_time_limit']),get_option( 'jpnp_botstop_emergency_last_timestamp',0 ));
	//get a total
	$botstop_total_recent = $wpdb->query( "SELECT id FROM ".$wpdb->prefix."JPNP_botstop_plugin_log WHERE timestamp > $timestamp_past");

	?>
	<div class="wrap">
	<h2>JPNP Bot Stop Plugin - Version: <?php echo($jpnp_botstop_version); ?> </h2>
	</div>
	<h2>Settings</h2>
    <form method="post" ENCTYPE="multipart/form-data" style="max-width:700px">
        <div>
            This plugin will send an Emergency Alert Email to "<?php echo($botstop_arr['emergency_email']); ?>" if it encounters more than "<?php echo($botstop_arr['emergency_alert_count_limit']); ?>" hacking attempts inside of the "<?php echo($botstop_arr['emergency_alert_time_limit']); ?>" second time limit.
            You will NOT receive more than 1 (one) email per every "<?php echo($botstop_arr['emergency_alert_count_limit']); ?>" hacking attempts.
            After sending 1 email, the counter will be reset.
        </div>
        <br />
        <label>Emercency Alert Email <input type="input" name="jpnp_botstop_emergency_email" id="jpnp_botstop_emergency_email" value="<?php echo($botstop_arr['emergency_email']); ?>" class="regular-text" style="width: 180px;" /></label>
        <br />
        <label>Emercency Alert Time Limit <input type="input" name="jpnp_botstop_emergency_alert_time_limit" id="jpnp_botstop_emergency_alert_time_limit" value="<?php echo($botstop_arr['emergency_alert_time_limit']); ?>" class="regular-text" style="width: 180px;" /> Seconds</label>
        <br />
        <label>Emercency Alert Count Limit <input type="input" name="jpnp_botstop_emergency_alert_count_limit" id="jpnp_botstop_emergency_alert_count_limit" value="<?php echo($botstop_arr['emergency_alert_count_limit']); ?>" class="regular-text" style="width: 180px;" /> Attempts</label>
        <br />
        <input type="submit" name="jpnp_botstop_setting" id="jpnp_botstop_setting" value="Save Settings" class="button-primary" />
    </form>

	<h2>Live Log</h2>
	<div>Total Bot Hacking attempts Stopped in the most recent designated time period: <span style="color:#ff0000;"><?php echo($botstop_total_recent); ?></span> </div>
	<?php

	//-----------------------------------------SETTINGS----------------------------------------
	//--Posts per page
	$rowsPerPage = 10;
	// by default we show first page
	$pageNum = 1;
	// if $_GET['page_num'] defined, use it as page number
	if(isset($_GET['page_num']))
	{
		$pageNum = $_GET['page_num'];
	}
	// counting the offset
		$offset = ($pageNum - 1) * $rowsPerPage;
		$page_num=$pageNum;
	//---------------------------------------------------------------------------------

	//the number of days to keep this log
	$days = 14;
	$timestamp_past = current_time('timestamp') - (60 * 60 * 24 * $days);
	$wpdb->query( "DELETE FROM ".$wpdb->prefix."JPNP_botstop_plugin_log WHERE timestamp < $timestamp_past");
	//get a total
	$botstop_total_total = $wpdb->query( "SELECT id FROM ".$wpdb->prefix."JPNP_botstop_plugin_log_password");
	$botstop_total_ip = $wpdb->query( "SELECT id FROM ".$wpdb->prefix."JPNP_botstop_plugin_log");
	$timestamp_installation = get_option('jpnp_botstop_install_timestamp', false);
	?>
	<h2>History</h2>
	<div>Total Bot Hacking attempts Stopped in the past <?php echo($days); ?> days: <span style="color:#ff0000;"><?php echo($botstop_total_ip); ?></span></div>
	<div>Installation Date (*introduced with version 0.6.5): <span style="color:#ff0000;"><?php echo(date('Y-m-d G:i:s', $timestamp_installation)); ?></span></div>
	<div>Total Bot Hacking attempts Stopped in logs: <span style="color:#ff0000;"><?php echo($botstop_total_total); ?></span></div>
	<h2>Recent Popular Attackers (Separated by IP)</h2>
	<div style="max-height:500px; padding:0 10px; font-family:monospace; background:#ffffff; overflow:scroll;">
    <?php

	//get a distinctive list of IPs
	//order by biggest offender, then date
	$botstop_result_distinct = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."JPNP_botstop_plugin_log GROUP BY IP ORDER BY COUNT(IP) DESC, timestamp DESC LIMIT $offset, $rowsPerPage");

	foreach($botstop_result_distinct as $result_single)
	{
		$limit = 3;
		$result = $wpdb->get_results( "SELECT IP, proxy, variable, timestamp FROM ".$wpdb->prefix."JPNP_botstop_plugin_log WHERE IP = '" . $result_single->IP . "' ORDER BY timestamp DESC LIMIT $limit");

		$count = $wpdb->query( "SELECT id FROM ".$wpdb->prefix."JPNP_botstop_plugin_log WHERE IP = '" . $result_single->IP . "'");

		?>
		<div>IP: <?php echo($result[0]->IP); ?></div>
		<div>Proxy: <?php echo($result[0]->proxy); ?></div>
        <?php
		if($count > $limit)
		{
			echo("<div>Total: $count</div>");
		}
		echo('<div>Most Recent Attempt: ' . date('Y-m-d G:i:s', $result_single->timestamp) . '</div>');
		/*
		echo('<br />');
		foreach($result as $item)
		{
			echo('<div>Time: ' . date('Y-m-d G:i:s', $item->timestamp) . '</div>
				<div><pre style="margin:0 0 10px 0;">' . $item->variable . '</pre></div>');
		}
		//*/
		echo('<hr style="color:#000000; background:#000000; border-color:#000000;" />');
	}
	echo('</div>');

	//get a distinctive list of passwords/users
	//order by biggest offender, then date
	?>
	<h2>Most Popular Passwords Attempted</h2>
	<div style="font-family:monospace;">
    <?php
	$botstop_password_popular = $wpdb->get_results( "SELECT password FROM ".$wpdb->prefix."JPNP_botstop_plugin_log_password GROUP BY password ORDER BY COUNT(password) DESC LIMIT 20");
	$botstop_user_popular = $wpdb->get_results( "SELECT user FROM ".$wpdb->prefix."JPNP_botstop_plugin_log_password GROUP BY user ORDER BY COUNT(user) DESC LIMIT 20");

	//echo(JPNP_botstop_plugin_var_dump_return($botstop_password_popular));

	foreach($botstop_password_popular as $result_single)
	{
		$count = $wpdb->query( "SELECT password FROM ".$wpdb->prefix."JPNP_botstop_plugin_log_password WHERE password = '" . $result_single->password . "'");

		?>
		<div><?php echo($result_single->password . ' - ' . $count); ?></div>
        <?php
	}
	?>
    </div>
    <h2>Most Popular Usernames Attempted</h2>
	<div style="font-family:monospace;">
	<?php
	foreach($botstop_user_popular as $result_single)
	{
		$count = $wpdb->query( "SELECT user FROM ".$wpdb->prefix."JPNP_botstop_plugin_log_password WHERE user = '" . $result_single->user . "'");

		?>
		<div><?php echo($result_single->user . ' - ' . $count); ?></div>
        <?php
	}
	echo('</div>');
}
function JPNP_botstop_plugin_setting_menu()
{
	add_options_page('JPNP Bot Stop', 'JPNP Bot Stop Plugin', 'manage_options', 'JPNPbotstopplugin', 'JPNP_botstop_plugin_setting_page');
}
if(is_admin())
{
	add_action('admin_menu', 'JPNP_botstop_plugin_setting_menu');
}
//put a settings link in the plugins page
function JPNP_botstop_plugin_action_links($links, $file)
{
	//add settings link to the plugin page
	static $this_plugin;
	if (!$this_plugin)
	{
		$this_plugin = plugin_basename(__FILE__);
	}
	if ($file == $this_plugin)
	{
		// the anchor tag and href to the URL we want. For a "Settings" link, this needs to be the url of your settings page
		$settings_link = '<a href="' . get_site_url() . '/wp-admin/options-general.php?page=JPNPbotstopplugin">Settings</a>';
		// add the link to the list
		array_unshift($links, $settings_link);
	}
	return $links;
}
add_filter('plugin_action_links', 'JPNP_botstop_plugin_action_links', 10, 2);


if(!function_exists('JPNP_botstop_plugin_form_inputs')):

	function JPNP_botstop_plugin_hooks()
	{
		add_action('login_form', 'JPNP_botstop_plugin_form_inputs');
		add_filter('authenticate', 'JPNP_botstop_plugin_login_check', 100, 3);

		add_action('register_form', 'JPNP_botstop_plugin_form_inputs');
		add_action('register_post', 'JPNP_botstop_plugin_registration_check', 100, 3);

		add_action('lostpassword_form', 'JPNP_botstop_plugin_form_inputs');
		add_action('lostpassword_post', 'JPNP_botstop_plugin_reset_password_check');
	}
	JPNP_botstop_plugin_hooks();


	function JPNP_botstop_plugin_login_enqueue_scripts()
	{
		// wp_enqueue_script('jquery');
		wp_enqueue_script('JPNP_botstop_plugin_script', plugins_url('/js/jpnp_bot_stop.js', __FILE__), array('jquery'), false, false);
	}
	//if you have a login form on a regular page (run on all pages)
	add_action('wp_enqueue_scripts', 'JPNP_botstop_plugin_login_enqueue_scripts');
	//for the normal wp-login.php page (just the login page)
	add_action('login_enqueue_scripts', 'JPNP_botstop_plugin_login_enqueue_scripts');


	function JPNP_botstop_plugin_form_inputs()
	{
		global $botstop_arr;
		// unobtrusive js - users should enable login, register and reset password with disabled js
		// users without js should just copy and paste code like with captcha
		echo "\n".'<p class="botstop-form-group botstop-form-group-code">'; // hidden with js
		echo '<label>Copy this code "<span>'.$botstop_arr['code'].'</span>" and paste it into input: <br />';
		echo '<input type="text" name="botstop-code" class="input" placeholder="here" />';
		echo '</label></p>'."\n";

		// the 'empty-field' should be hidden via css because user should never see it even with disabled js
		echo "\n".'<p class="botstop-form-group botstop-form-group-empty" style="display: none;">'; // hide with css
		echo '<label>Leave this field empty: <br />';
		echo '<input type="text" name="botstop-empty" class="input" value="" />';
		echo '</label></p>'."\n";
	}


	function JPNP_botstop_plugin_login_check($user, $username, $password)
	{
		global $botstop_arr;
		$error_flag = 0;
		$error_msg = '';
		if(!empty($_POST)) {
			if($_POST['botstop-code'] !== $botstop_arr['code'])
			{
				$error_flag = 1;
				$error_msg .= ' wrong code; ';
			}
			if($_POST['botstop-empty'] !== '')
			{
				$error_flag = 1;
				$error_msg .= ' field should be empty; ';
			}
			if($error_flag)
			{
				// we have errors - so this should be brute-force bot
				$error = new WP_Error();
				$error->add('botstop-login-error', 'Security-protection plugin: Login error: '.$error_msg);

				JPNP_botstop_plugin_alert('Login error: '.$error_msg);
				JPNP_botstop_plugin_set_fake_login_cookies(); // set fake login cookies
				JPNP_botstop_plugin_fake_redirect(); // fake admin dashboard redirect
				return $error;
			}
			// user passed Bot Stop check and it is not brute-force bot
			if(!is_wp_error($user))
			{
				// user gave us valid username and password
				if($botstop_arr['send_successful_login_log_to_admin'])
				{
					JPNP_botstop_plugin_alert('Login successful: passed Security-protection check; correct username and password;', true);
				}
			}
			else
			{
				// user gave us invalid username and password
				JPNP_botstop_plugin_alert('Login error: passed Security-protection check; bad username or password;');
			}
		}
		return $user;
	}


	function JPNP_botstop_plugin_registration_check($login, $email, $errors)
	{
		global $botstop_arr;
		$error_flag = 0;
		$error_msg = '';
		if(!empty($_POST))
		{
			if($_POST['botstop-code'] !== $botstop_arr['code'])
			{
				$error_flag = 1;
				$error_msg .= ' wrong code; ';
			}
			if($_POST['botstop-empty'] !== '')
			{
				$error_flag = 1;
				$error_msg .= ' field should be empty; ';
			}
			if($error_flag)
			{
				// we have errors - so this should be brute-force bot
				JPNP_botstop_plugin_alert('Registration error: '.$error_msg);
				$errors->add('botstop-registration-error', 'Security-protection plugin: Registration error: '.$error_msg);
			}
		}
		return $errors;
	}


	function JPNP_botstop_plugin_reset_password_check()
	{
		global $botstop_arr;
		$error_flag = 0;
		$error_msg = '';
		if(!empty($_POST))
		{
			if($_POST['botstop-code'] !== $botstop_arr['code'])
			{
				$error_flag = 1;
				$error_msg .= ' wrong code; ';
			}
			if($_POST['botstop-empty'] !== '')
			{
				$error_flag = 1;
				$error_msg .= ' field should be empty; ';
			}
			if($error_flag)
			{
				// we have errors - so this should be brute-force bot
				JPNP_botstop_plugin_alert('Reset password error: '.$error_msg);
				wp_die('Security-protection plugin: Reset password error: '.$error_msg);
			}
		}
	}


	function JPNP_botstop_plugin_alert($error_message = '', $success = false)
	{
		//log
		JPNP_botstop_plugin_add_ip($error_message, $success);
		//send message
		JPNP_botstop_plugin_send_email();
	}
endif; // end of JPNP_botstop_plugin_form_inputs()


/*********************
RE-Usable functions
*********************/

function JPNP_botstop_plugin_send_email()
{
	if(JPNP_botstop_plugin_emergency_alert())
	{
		global $wpdb;
		global $botstop_arr;
		global $jpnp_botstop_version;
		//total attempts in the past 1 hour
		$timestamp_past = current_time('timestamp') - (60*60);
		$botstop_past_hour[1] = $wpdb->query( "SELECT id FROM ".$wpdb->prefix."JPNP_botstop_plugin_log WHERE timestamp > $timestamp_past");
		//total attempts in the past 24 hour
		$timestamp_past = current_time('timestamp') - (60*60*24);
		$botstop_past_hour[24] = $wpdb->query( "SELECT id FROM ".$wpdb->prefix."JPNP_botstop_plugin_log WHERE timestamp > $timestamp_past");

		$botstop_email_message = '['.home_url().']'."\r\n";
		$botstop_email_message .= 'Attempts in the past 1 hour: '. $botstop_past_hour[1] ."\r\n";
		$botstop_email_message .= 'Attempts in the past 24 hours: '. $botstop_past_hour[24] ."\r\n";
		$botstop_email_message .= "\r\n\r\n";
		$botstop_email_message .= '-----------------------------'."\r\n";
		$botstop_email_message .= 'This is an automatic email from by JPNP Bot Stop plugin'."\r\n";
		$botstop_email_message .= '['.home_url().'] may currently be under attack'."\r\n";

		$botstop_subject = 'Bot-Stop v:' . $jpnp_botstop_version . ' ['.home_url().']'; // email subject
		$botstop_headers[] = 'From: Bot_stop <noreply@' . str_replace('http://','',str_replace('https://','',home_url())) . '>';
		@wp_mail($botstop_arr['emergency_email'], $botstop_subject, $botstop_email_message, $botstop_headers); // send log info to admin email
	}
}

function JPNP_botstop_plugin_set_fake_login_cookies()
{
	// set fake login cookies
	// many brute-force attacks are waiting for redirect or WordPress login cookies
	// after fake redirect and fake login cookies many brute-forcers will stop their attacks

	$expiration = time() + 14 * DAY_IN_SECONDS;
	$expire = $expiration + (12 * HOUR_IN_SECONDS);
	$secure = '';

	$cookie_value_fake = 'user%7C1597857834%7C8b15ec47bfba38d43df64d1427e12daa';
	$auth_cookie_fake = 'wordpress_123309a793469c07c80a9cb5298c0b71';
	$logged_in_cookie_fake = 'wordpress_logged_in_123309a793469c07c80a9cb5298c0b71';

	setcookie($auth_cookie_fake, $cookie_value_fake, $expire, COOKIEPATH, COOKIE_DOMAIN, $secure, true);
	setcookie($logged_in_cookie_fake, $cookie_value_fake, $expire, COOKIEPATH, COOKIE_DOMAIN, $secure, true);

	// login cookie names are located in wp-includes/default-constants.php:
	// define('AUTH_COOKIE', 'wordpress_'.COOKIEHASH);
	// define('LOGGED_IN_COOKIE', 'wordpress_logged_in_'.COOKIEHASH);
}


function JPNP_botstop_plugin_fake_redirect()
{
	// fake admin dashboard redirect
	// redirect the brute-force bot to admin section to emulate that the password is cracked
	// and some brute-forcers stop their attacks after such redirect
	$redirect_to = admin_url();
	wp_safe_redirect($redirect_to);

	//or we can troll them.... which apparently doesn't work
	//wp_redirect( 'https://www.youtube.com/watch?v=QDySGUFAom0', 302 );
	exit();
}



if(!function_exists('JPNP_botstop_plugin_row_meta')):
	function JPNP_botstop_plugin_row_meta($links, $file)
	{ // add links to plugin meta row
		if(strpos($file, 'jpnp_bot_stop.php') !== false)
		{
			$links = array_merge($links, array('<a href="http://neathawk.us" title="Author Page">Author Page</a>'));
			//$links = array_merge($links, array('<a href="http://example.com" title="example.com">Example.com</a>'));
		}
		return $links;
	}
	//add_filter('plugin_row_meta', 'JPNP_botstop_plugin_row_meta', 10, 2);
endif; // end of JPNP_botstop_plugin_meta()


//if the site is under attack then override the email allert and send one anyway
function JPNP_botstop_plugin_emergency_alert()
{
	global $botstop_arr;
	$output = $botstop_arr['send_brute_force_log_to_admin'];
	//skip all this if the alert is already set to true.
	if(!$output)
	{
		global $wpdb;
		//just in case this hasen't been done
		JPNP_botstop_plugin_create_sql();

		//don't send constant emergency alerts, only a max of one per timeframe
		//this will get the most recent time of either the last alert or "one timeframe ago"
		$timestamp_past = max((current_time('timestamp') - $botstop_arr['emergency_alert_time_limit']),get_option( 'jpnp_botstop_emergency_last_timestamp',0 ));
		//get a total
		$botstop_emergency_alert_totalIP = $wpdb->query( "SELECT id FROM ".$wpdb->prefix."JPNP_botstop_plugin_log WHERE timestamp > $timestamp_past");
		if((int)$botstop_emergency_alert_totalIP > (int)$botstop_arr['emergency_alert_count_limit'])
		{
			$output = true;
			update_option('jpnp_botstop_emergency_last_timestamp', current_time('timestamp'));
		}
	}
	return $output;
}


function JPNP_botstop_plugin_is_up_to_date()
{
	global $jpnp_botstop_db_version;
	return (get_option( "jpnp_botstop_db_version", 0 ) == $jpnp_botstop_db_version ? true : false);
}


function JPNP_botstop_plugin_var_dump_pre($mixed = NULL, $label = NULL)
{
	if(is_string($label)){$label .= ': ';}else{$label = '';}
	echo '<pre>' . $label . "\n";
	var_dump($mixed);
	echo '</pre>';
	return NULL;
}
function JPNP_botstop_plugin_var_dump_return($mixed = NULL)
{
	ob_start();
	var_dump($mixed);
	$content = ob_get_contents();
	ob_end_clean();
	return $content;
}


/*********************
DATABASE functions
*********************/

//add table(s)
function JPNP_botstop_plugin_create_sql()
{
	if(!JPNP_botstop_plugin_is_up_to_date())
	{
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		$sql = "CREATE TABLE ".$wpdb->prefix."JPNP_botstop_plugin_log (
		id INT(60) UNSIGNED NOT NULL AUTO_INCREMENT,
		IP VARCHAR(25) NOT NULL,
		proxy VARCHAR(25) NOT NULL,
		useragent VARCHAR( 225 ) NOT NULL,
		variable TEXT NOT NULL,
		timestamp INT(30) NOT NULL,
		UNIQUE KEY id (id)
		);";
		dbDelta($sql);

		$sql = "CREATE TABLE ".$wpdb->prefix."JPNP_botstop_plugin_log_password (
		id INT(60) UNSIGNED NOT NULL AUTO_INCREMENT,
		user TEXT NOT NULL,
		password TEXT NOT NULL,
		timestamp INT(30) NOT NULL,
		UNIQUE KEY id (id)
		);";
		dbDelta($sql);
	}

	update_option('jpnp_botstop_db_version', $jpnp_botstop_db_version);
	//set these only if they don't already exist
	if(get_option('jpnp_botstop_install_timestamp', false) == false)
	{
		//set to current timestamp
		update_option('jpnp_botstop_install_timestamp', current_time('timestamp'));
		//if updated from earlier version, this will be inaccurate
		//attempt an older one from logs, not reliable
		$result = $wpdb->get_results( "SELECT timestamp FROM ".$wpdb->prefix."JPNP_botstop_plugin_log_password WHERE timestamp > 10000 ORDER BY timestamp ASC LIMIT 1");
		if(!empty($result[0]->timestamp) && is_numeric($result[0]->timestamp))
		{
			update_option('jpnp_botstop_install_timestamp', $result[0]->timestamp);
		}
	}
	if(get_option('jpnp_botstop_emergency_last_timestamp', false) == false)
	{
		update_option('jpnp_botstop_emergency_last_timestamp', current_time('timestamp'));
	}
	if(get_option('jpnp_botstop_emergency_email', false) == false)
	{
		update_option('jpnp_botstop_emergency_email', get_option('admin_email'));
	}
	if(get_option('jpnp_botstop_emergency_alert_time_limit', false) == false)
	{
		update_option('jpnp_botstop_emergency_alert_time_limit', (60*60));
	}
	if(get_option('jpnp_botstop_emergency_alert_count_limit', false) == false)
	{
		update_option('jpnp_botstop_emergency_alert_count_limit', 100);
	}
}
register_activation_hook( __FILE__, 'JPNP_botstop_plugin_create_sql' );

//insert IP list
function JPNP_botstop_plugin_add_ip($error_message = '', $success = false)
{
	//just in case this hasn't been done
	JPNP_botstop_plugin_create_sql();

	global $wpdb;
	global $botstop_arr;

	$ip = $_SERVER['REMOTE_ADDR'];
	$proxy = $_SERVER['REMOTE_ADDR'];
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$variable = $error_message."\r\n";
	$user = '';
	$password = '';

	if(!empty($_SERVER['HTTP_CLIENT_IP']))
	{
		//check ip from share internet
		$proxy = $_SERVER['HTTP_CLIENT_IP'];
	}
	else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	{
		//check if ip is passed from proxy, also could be used ['HTTP_X_REAL_IP ']
		$proxy = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}

	$variable .= 'REQUEST_URI : '.$_SERVER['REQUEST_URI']."\r\n";
	$variable .= 'HTTP_REFERER : '.$_SERVER['HTTP_REFERER']."\r\n\r\n";

	if(!empty($_POST))
	{
		$variable .= 'POST:'."\r\n"; // lets see what POST vars brute-forcers try to submit
		foreach ($_POST as $key => $value)
		{
			$value = sanitize_text_field( $value );

			$variable .= '['.$key.'] = '.$value."\r\n"; // .chr(13).chr(10)
			if($key == 'log')
			{
				$user = $value;
			}
			//don't log the password if successful
			if($key == 'pwd' && !$success)
			{
				$password = $value;
			}
		}
	}
	if(!empty($_COOKIE))
	{
		$variable .= 'COOKIE:'."\r\n"; // lets see what COOKIE vars brute-forcers try to submit
		foreach ($_COOKIE as $key => $value)
		{
			$value = sanitize_text_field( $value );

			$variable .= '['.$key. '] = '.$value."\r\n"; // .chr(13).chr(10)
		}
	}

	$table_name = $wpdb->prefix . 'JPNP_botstop_plugin_log';
	$wpdb->insert(
	$table_name,
		array(
			'IP' => $ip,
			'proxy' => $proxy,
			'useragent' => $useragent,
			'variable' => $variable,
			'timestamp' => current_time('timestamp'),
		)
	);

	$table_name = $wpdb->prefix . 'JPNP_botstop_plugin_log_password';
	$wpdb->insert(
	$table_name,
		array(
			'user' => $user,
			'password' => $password,
			'timestamp' => current_time('timestamp'),
		)
	);
}

register_deactivation_hook( __FILE__, 'JPNP_botstop_plugin_deactivate' );
//remove some data
function JPNP_botstop_plugin_deactivate()
{
	delete_option('jpnp_botstop_emergency_last_timestamp');
}

register_uninstall_hook( __FILE__, 'JPNP_botstop_plugin_uninstall' );
//remove all data
function JPNP_botstop_plugin_uninstall()
{
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
	{
	    exit();
	}
	delete_option('jpnp_botstop_db_version');
	delete_option('jpnp_botstop_install_timestamp');
	delete_option('jpnp_botstop_emergency_last_timestamp');
	delete_option('jpnp_botstop_emergency_email');
	delete_option('jpnp_botstop_emergency_alert_time_limit');
	delete_option('jpnp_botstop_emergency_alert_count_limit');

	//drop custom db table
	global $wpdb;
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}JPNP_botstop_plugin_log" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}JPNP_botstop_plugin_log_password" );
}

