<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{ 
    public function testInputMark()
    {
        $client = static::createClient();
        //Make sure I1, I2 & I3 are displayed without error
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Make sure all the three links are displayed well
        $this->assertContains('ADMINISTRATION', $client->getResponse()->getContent());
        $this->assertContains('MARK INPUT', $client->getResponse()->getContent());
        $this->assertContains('CONFIGURATION', $client->getResponse()->getContent());
        $crawler = $client->request('GET', '/mark_input_parameters');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/dashboard');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', 'http://localhost/Academ/web/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    
}
