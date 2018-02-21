<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
    }
    
    public function testInputMark()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/input_mark/2');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('KOYASSANGOU', $client->getResponse()->getContent());
        
    }
    
    
}
