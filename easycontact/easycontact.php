<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=global
[END_COT_EXT]
==================== */

/**
 * easycontact
 *
 * @package easycontact
 * @version 0.3
 * @author CrazyFreeMan
 * @copyright Copyright (c) CrazyFreeMan 2016
 * @license BSD
 */	
require_once cot_langfile('easycontact', 'plug'); 
require_once cot_incfile('forms');	
	//генерація форми
function cot_easycontact_form($redirect = '/') {		
	global $cfg, $L, $usr;

	if(($cfg['plugin']['easycontact']['only_for_registred'] == '1' && $usr['id'] > 0) || 
		($cfg['plugin']['easycontact']['only_for_registred'] == '0')) {


		$input_array = array();		
	$array_config = array( 	
		"user_name" => array("name" => "use_input_name", "value" => ""),
		"user_email" => array("name" => "use_input_email", "value" => ""),
		"user_phone" => array("name" => "use_input_phone", "value" => ""),
		"mail_subj" => array("name" => "use_input_subj", "value" => "")
		
		);

	
	if (isset($_POST['ecsend']))
	{ 
			//перевірка імені відправника
		if($cfg['plugin']['easycontact']['use_input_name'] == '1'){		
			$user_name = cot_import('user_name', 'P', 'TXT');				
			if (empty($user_name) || mb_strlen($user_name) < 3)
			{
				cot_error($L["err_name"], 'user_name');
			}else{
				$rtn["user_name"] = $user_name;
			}
		}else{
			$rtn["user_name"] = false;
		}
			//перевірка пошти відправника
		if($cfg['plugin']['easycontact']['use_input_email'] == '1'){		
			$user_email = cot_import('user_email', 'P', 'TXT');
			if (empty($user_email) || !cot_check_email($user_email))
			{
				cot_error($L["err_mail"], 'user_email');
			}else{
				$rtn["user_email"] = $user_email;					
			}
		}else{
			$rtn["user_email"] = false;
		}
			//перевірка телефону відправника
		if($cfg['plugin']['easycontact']['use_input_phone'] == '1'){		
			$user_phone = cot_import('user_phone', 'P', 'TXT');
				if (empty($user_phone) || mb_strlen($user_phone) < $cfg['plugin']['easycontact']['input_phone_countnum'] ) //|| !is_numeric($user_phone) перевірка на число не актуально
				{
					cot_error($L["err_phone"], 'user_phone');
				}else{
					$rtn["user_phone"] = $user_phone;
				}

			}else{
				$rtn["user_phone"] = false;
			}
			//перевірка теми повідомлення
			if($cfg['plugin']['easycontact']['use_input_subj'] == '1'){		
				$mail_subj = cot_import('mail_subj', 'P', 'TXT');
				if (empty($mail_subj) || mb_strlen($mail_subj) < 3)
				{
					cot_error($L["err_subj"], 'mail_subj');
				}else{
					$rtn["mail_subj"] = $mail_subj;
				}
			}else{
				$rtn["mail_subj"] = false;
			}

			$array_config["user_name"]["value"] = $user_name;
			$array_config["user_email"]["value"]  = $user_email;
			$array_config["user_phone"]["value"]  = $user_phone;
			$array_config["mail_subj"]["value"]  = $mail_subj;

			if (!cot_error_found()){

				$semail = ($cfg['plugin']['easycontact']['use_system_email'] == "1") ? $cfg['adminemail']: str_replace(' ', '', $cfg['plugin']['easycontact']['email_for_send']);
				if(cot_check_email($semail)){
					$semail	= $cfg['adminemail'];
				}

				if($rtn["user_name"] == false){$rtn["user_name"] = $L["nodata"];}
				if($rtn["user_email"] == false){$rtn["user_email"] = $L["nodata"];}
				if($rtn["mail_subj"] == false){$rtn["mail_subj"] = $L["nodata"];}
				if($rtn["user_phone"] == false){$rtn["user_phone"] = $L["nodata"];}

				$headers = ("From: \"" . $rtn["user_name"] . "\" <" . $rtn["user_email"] . ">\n");

				$text = $L["user_name"]." - ".$rtn["user_name"]."\n\r";
				$text .= $L["mail_subj"]." - ".$rtn["mail_subj"]."\n\r"; 
				$text .= $L["user_phone"]." - ".$rtn["user_phone"];						
				
				cot_mail($semail, $cfg['plugin']['easycontact']['email_subj_add']." - ".$rtn['mail_subj'], $text, $headers);
				cot_log('Easycontact mail send', 'plg');
				
				$array_config["user_name"]["value"] = "";
				$array_config["user_email"]["value"]  = "";
				$array_config["user_phone"]["value"]  = "";
				$array_config["mail_subj"]["value"]  = "";
				cot_message('succ_send');			
			}

		}

		$cfg['plugin']['easycontact']['input_necessarily'] == '1' ? $necess = $L["input_necessarily"] : $necess ='';
		
		foreach ($array_config as $key => $value) {		
			if($cfg['plugin']['easycontact'][$value["name"]] == '1'){
				if (($key == "user_name" || $key ==  "user_email") && $usr['id'] > 0) {
					$custom_add = $necess."' id='".$key."' readonly='readonly'";
					$input_array[$key]= cot_inputbox('text',$key,$usr["profile"][$key],$custom_add);				
				}else{							
					$custom_add = "placeholder='".$L[$key]." ".$necess."' id='".$key."'";
					$input_array[$key]= cot_inputbox('text',$key, $value["value"],$custom_add);
				}
			}
		}
		//завантаження шаблону

		$mytpl = new XTemplate(cot_tplfile('easycontact', 'plug'));

		foreach ($input_array as $ekey => $evalue) {
			$easy_form_arr["EASYCONTACT_FORM_".strtoupper($ekey)] = $evalue;			
		}	

		cot_display_messages($mytpl);
		
		//$easy_form_arr['EASYCONTACT_FORM_SEND'] = cot_url('plug', 'e=easycontact');
		
		$easy_form_arr['EASYCONTACT_FORM_SEND'] = $redirect;		
		$mytpl->assign($easy_form_arr);		
		$mytpl->parse('MAIN.FORM');	
		$mytpl->parse('MAIN');

		return $mytpl->text('MAIN');
	}		 
}