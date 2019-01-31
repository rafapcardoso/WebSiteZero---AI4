<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     modifier.authorize.php
 * Type:     modifier
 * Name:     authorize
 * Purpose:  Verifica se o usuario possui a autorizacao precisa ou seja um SuperUser
 * -------------------------------------------------------------
 */
function smarty_modifier_authorize($needed, $authos)
{
    $retorno = false;
    if(in_array("SuperUser", $authos)){
        $retorno = true;
    }else{
        if(in_array($needed, $authos)){
            $retorno = true;
        }
    }
    return $retorno;
}
?>