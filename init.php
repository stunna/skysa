<?php
/**
 * This software is intended for use with Oxwall Free Community Software http://www.oxwall.org/ and is
 * licensed under The BSD license.

 * ---
 * Copyright (c) 2011, Oxwall Foundation
 * All rights reserved.

 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the
 * following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice, this list of conditions and
 *  the following disclaimer.
 *
 *  - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and
 *  the following disclaimer in the documentation and/or other materials provided with the distribution.
 *
 *  - Neither the name of the Oxwall Foundation nor the names of its contributors may be used to endorse or promote products
 *  derived from this software without specific prior written permission.

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
$skysaBarID = OW::getConfig()->getValue('skysa', 'bar_id');

if (null !== $skysaBarID){

    function skysa_add_code(){

        $skysaBarID = OW::getConfig()->getValue('skysa', 'bar_id');

        $userID = OW::getUser()->getId();
        
        
        if(0 != $userID){
          $username = OW::getUser()->getUserObject()->getUsername();
          $profileURL = BOL_UserService::getInstance()->getUserUrl($userID);
          $photoURL = BOL_AvatarService::getInstance()->getAvatarUrl($userID);
         }
        $loginURL = OW_URL_HOME.'sign-in';
       

        $skysacode = '<a href="http://www.skysa.com/page/features/live-support-chat" id="SKYSA-NoScript">Live Support</a><script type="text/javascript" src="//static2.skysa.com?i='.$skysaBarID.'" async="true"></script>';
       
        $skyadvanced = '<script type="text/javascript">
          var _SKYAUTH = {
            loginUrl:"'.$loginURL.'",
            memberNick:"'.$username.'",
            memberId:"'.$userID.'",
            profileUrl:"'.$profileURL.'",
            photoUrl:"'.$photoURL.'"
          };
        </script>';

        OW::getDocument()->appendBody($skysacode);
        
        if(0 != $userID){
          OW::getDocument()->appendBody($skyadvanced);
        }
    }
    OW::getEventManager()->bind(OW_EventManager::ON_FINALIZE, 'skysa_add_code');
}

OW::getRouter()->addRoute(new OW_Route('skysa_admin', 'admin/plugins/skysa', 'SKYSA_CTRL_Admin', 'index'));

function skysa_admin_notification(BASE_CLASS_EventCollector $event){

    $skysaBarID = OW::getConfig()->getValue('skysa', 'bar_id');

    if (empty($skysaBarID)){
        $event->add(OW::getLanguage()->text('skysa', 'admin_notification_text', array('link' => OW::getRouter()->urlForRoute('skysa_admin'))));
    }
}
OW::getEventManager()->bind('admin.add_admin_notification', 'skysa_admin_notification');