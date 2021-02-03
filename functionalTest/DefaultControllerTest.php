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
        //Check list and creation of Section
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/section/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/section/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Field
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/field/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/field/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Level
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/level/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/level/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Program
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/program/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/program/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of AffectedProgram
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/affectedprogram/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/affectedprogram/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Coefficient
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/coefficient/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/coefficient/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Cycle
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/cycle/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/cycle/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Sequence
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/sequence/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/sequence/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Student
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/student/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/student/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Student Parent
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/studentparent/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/studentparent/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Evaluation
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/evaluation/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/evaluation/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Mark
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/mark/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/mark/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Teacher
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/teacher/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/teacher/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Main Teacher
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/mainteacher/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/mainteacher/create');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //Check list and creation of Main User
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/user/list');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $crawler = $client->request('GET', '/admin/app/user/create');
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
