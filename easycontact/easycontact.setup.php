<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Code=Easy contact
Name=easycontact
Description=Простая форма обращения пользователя к администрации
Version=0.3
Date=2016-07-23
Author=CrazyFreeMan
Copyright=&copy; CrazyFreeMan (www.simple-website.in.ua) 2016
Notes=BSD
Auth_guests=R
Lock_guests=2345A
Auth_members=RW
Lock_members=2345
Requires_modules=
Requires_plugins=
Recommends_modules=
Recommends_plugins=
[END_COT_EXT]

[BEGIN_COT_EXT_CONFIG]
only_for_registred=01:radio::1
use_system_email=02:radio::1
email_for_send=03:string:::
use_input_name=04:radio::1
use_input_email=05:radio::1
use_input_phone=06:radio::1
input_phone_countnum=07:range:1,20:12
use_input_subj=08:radio::1
input_necessarily=09:radio::1
email_subj_add=10:string::EasyContact
[END_COT_EXT_CONFIG]
==================== */