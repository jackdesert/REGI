<?php

/*
    AMC Event Registration System
    Copyright (C) 2010 Dirk Koechner

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, version 3 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    For a copy of the GNU General Public License, please refer to
    <http://www.gnu.org/licenses/>.
*/


function SECcreateCookie($user_name, $special ){
    $cookiePayload = 'AMCuser_name=' . $user_name;
    $hmac_key = hash_hmac('sha1',$cookiePayload, $special);
    $delimiter = '&';
    $cookie = $cookiePayload . $delimiter . $hmac_key;
    return $cookie;
}

function SECtestCookie($in_cookie, $special){
    $delimiter = '&';
    $parts = explode($delimiter, $in_cookie, 2);
    if (count($parts) != 2){
        print 'should have split into exactly two pieces';
        return false;   // should be exactly one delimiter in the in_cookie
    }elseif(strlen($parts[0]) < 14){
        print 'not long enough';
        return false;   // not long enough to contain the 'AMCuser_name' prepend
    }else{
        $cookiePayload = $parts[0];
        $proposed_user_name = substr($cookiePayload, 13);
        $in_hmac_key = $parts[1];
        $generated_hmac_key = hash_hmac('sha1',$cookiePayload, $special);
        if ($in_hmac_key == $generated_hmac_key)
            return $proposed_user_name;
        else
            print 'hmac key did not match';
            return false;
    }
}
?>

