<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{ 
    public function testInputMark()
    {
        $client = static::createClient();
        //Make sure I1, I2 & I3 are displayed without error
        $crawler = $client->request('GET', '/login');
        $this->login($crawler, $client, 'super-admin', 'test');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Make sure all the three links are displayed well
        $this->assertContains('ADMINISTRATION', $client->getResponse()->getContent());
        $this->assertContains('MARK INPUT', $client->getResponse()->getContent());
        $this->assertContains('CONFIGURATION', $client->getResponse()->getContent());
        //Check the mark input page loading 
        $crawler = $client->request('GET', '/mark_input/1/1');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/dashboard');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        
    }

    /*
     * this methode have 4 parameters:
     * @crawler : the robot
     * @client: the browser
     * @userName: the username 
     * @password: the password
     */
    public function login($crawler, $client1, $userName = 'seller', $password = 'test')
    {
        //Fill the login form with the right credentials from the fixtures
        $form = $crawler->selectButton('btn_create_and_create')->form(array(
                                                            '_username'  => $userName,
                                                            '_password'  => $password,
                                                        ));
        //Submit the form in order to login
        $client1->submit($form);
        //The system redirect to the front page (/)
        $crawler = $client1->followRedirect();
    }    
}
