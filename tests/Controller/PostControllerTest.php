<?php

namespace App\Tests\Controller;

use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PostControllerTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $client->request('GET', '/register ');
        $crawler = $client->request('GET', '/register');
        //$client->getResponse()->getContent();
        //dd($crawler);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Register');


    //     $form = $crawler->selectButton('Register')->form();
    //     dd($client->getResponse()->getContent());
    //  // set some values
    //     $form['email'] = 'gas3006@hotmail.com';
    //     $form['agreeTerms'] = true;
    //     $form['plainPassword'] = 'contraseña';
        
    //      // submit the form
    //     $crawler = $client->submit($form);

        

    }
    //prueba para ver si existe el user
    public function testVisitingWhileLoggedIn()
    {
        $client = static::createClient();
        $userRepository = static::$container->get(UserRepository::class);

        // retrieve the test user
        $testUser = $userRepository->findOneByEmail('gastoncumoll@hotmail.com');

        // simulate $testUser being logged in
        $client->loginUser($testUser);

        // test e.g. the profile page
        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('title', 'Login');
    }

    public function testRegister()
    {
        $client = static::createClient();

        $client->request('GET', '/register ');
        $crawler = $client->request('GET', '/register');
        //$client->getResponse()->getContent();
        //dd($crawler);
        $buttonCrawlerNode = $crawler->selectButton('Register')->form();

// retrieve the Form object for the form belonging to this button
        $form = $buttonCrawlerNode->form();

// set values on a form object
        $form['[email]'] = 'Gastoncumoll123@gmail.com';
        $form['[agreeTerms]'] = true;
        $form['[plainPassword]'] = 'contraseña';


        // submit the Form object
        $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Register');
    }
}