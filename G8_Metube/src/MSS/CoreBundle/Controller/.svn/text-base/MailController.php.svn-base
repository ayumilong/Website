<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MailController
 *
 * @author jack
 */
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MailController extends WebTestCase{
    public function isSent(){
        $client = static::createClient();
        // Enable the profiler for the next request (it does nothing if the profiler is not available)
        $client->enableProfiler();
    
        $mailCollector = $client->getProfile()->getCollector('swiftmailer');
        // Check that an e-mail was sent
        $this->assertEquals(1, $mailCollector->getMessageCount());
        if($mailCollector->getMessageCount() === 1){
            return TRUE;
        }else{
            return FALSE;
        }
    }
}
