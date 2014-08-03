/**
 * Cotonti Plugin EasyContact
 * 
 *
 * @package EasyContact
 * @author CrazyFreeMan
 * @copyright CrazyFreeMan 2014 https://github.com/CrazyFreeMan
 */

$(function() {

    function SetBorderColor(obj, param){
        if(param == 'valid'){
             $(obj).css({'border' : '1px solid #569b44'});             
        }else{
            $(obj).css({'border' : '1px solid #ff0000'}); 
        }
    }
    $('#user_name').blur(function() {
            if($(this).val() != '') {
            var patternph = /[A-Za-zА-Яа-я0-9_]{3,}/i;
                if(patternph.test($(this).val())){
                    SetBorderColor(this,'valid');                        
                } else {
                    SetBorderColor(this);                    
                }
            } else {
                SetBorderColor(this);                 
            }  
        
        });

    $('#user_mail').blur(function() {
         if($(this).val() != '') {
                    var pattern = /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i;
                    if(pattern.test($(this).val())){                        
                        SetBorderColor(this,'valid');                        
                    } else {
                        SetBorderColor(this);                      
                    }
                } else {
                    SetBorderColor(this);                 
                }          
        });

   $('#user_phone').mask("+38 (099) 99 99 999"); //Использовать если подключено phoneinput.js в tpl
    /*$('#user_phone').blur(function() {
            if($(this).val() != '') {
            var patternph = /^[\d]{12}$/i;
                if(patternph.test($(this).val())){
                    SetBorderColor(this,'valid');                        
                } else {
                    SetBorderColor(this);                    
                }
            } else {
                SetBorderColor(this);                 
            }    
        });*/

    $('#mail_subj').blur(function() {
            if($(this).val() != '') {
            var patternph = /[A-Za-zА-Яа-я0-9_]{3,}/i;
                if(patternph.test($(this).val())){
                    SetBorderColor(this,'valid');                        
                } else {
                    SetBorderColor(this);                    
                }
            } else {
                SetBorderColor(this);                 
            }            
        });

});