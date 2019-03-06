<?php

/*
|--------------------------------------------------------------------------
| News Facebook Configuration
|--------------------------------------------------------------------------
*/
//Enable getting the news from your facebook wall 0 - Disable, 1 - Enable 
$config['news_by_facebook'] = false;

//The username of your group
$config['facebook_username'] = "YourServer";

//IMPORTANT! you have to be admin on the page read facebook.txt in _TUTORIALS
$config['facebook_app_id'] = "1234567";
$config['facebook_app_secret'] = "1234567abc";

//The headline is created by the facebook post, set the length here.
$config['facebook_headline_length'] = 40;

//The id of the user on the website that posts everything regarding facebook.
$config['facebook_user_poster'] = 123;
