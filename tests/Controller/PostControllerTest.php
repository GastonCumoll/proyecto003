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

        $client->request('GET', '/publicaciones');
        //$crawler = $client->request('GET', '/publicaciones');
         //$client->getResponse()->getContent();
         //dd($crawler);

        //$this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Publicaciones');

        //------------------------------------------------------------------------------------
        
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
        
        $this->assertSelectorTextContains('title', 'Login');
    }


    public function testRoleUser()
    {
        $client = static::createClient();
        $client->request('GET', '/logedIn');
        dd($client);
        $response = $this->client->getResponse();
        
        $expectedContent = ' ROLE_USER ';

        $this->assertEquals($expectedCode, $this->client->getResponse()->getStatusCode());
    }


    public function testRegister()
    {
        $client = static::createClient();



        $crawler=$client->request('GET', '/suscripcion/new');
        $form = $crawler->selectButton('save');
        //$form = $crawler->filter('fas fa-save');
        

        //dd($buttonCrawlerNode);
        

        $crawler = $client->submitForm('submit', [
            'suscripcion/new[tipoPublicacion]' =>('Libro'),
            'suscripcion/new[usuario]' =>('gaston@hotmail.com'),
        ]);


        // submit the Form object
        $crawler = $client->submit($form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSelectorTextContains('h1', 'Register');
    }
    
}