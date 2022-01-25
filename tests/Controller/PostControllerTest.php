<?php

namespace App\Tests\Controller;

use App\Form\RegistrationType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PostControllerTest extends WebTestCase
{
    // public function testShowPost()
    // {
    //     $client = static::createClient();

    //     $client->request('GET', '/publicaciones');
    //     //$crawler = $client->request('GET', '/publicaciones');
    //      //$client->getResponse()->getContent();
    //      //dd($crawler);

    //     //$this->assertEquals(200, $client->getResponse()->getStatusCode());
    //     $this->assertSelectorTextContains('h1', 'Publicaciones');

    //     //------------------------------------------------------------------------------------
        
    // //     $form = $crawler->selectButton('Register')->form();
    // //     dd($client->getResponse()->getContent());
    // //  // set some values
    // //     $form['email'] = 'gas3006@hotmail.com';
    // //     $form['agreeTerms'] = true;
    // //     $form['plainPassword'] = 'contraseña';
        
    // //      // submit the form
    // //     $crawler = $client->submit($form);

        

    // }
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


    // public function testRoleUser()
    // {
    //     $client = static::createClient();
    //     $client->request('GET', '/logedIn');
    //     dd($client);
    //     $response = $this->client->getResponse();
        
    //     $expectedContent = ' ROLE_USER ';

    //     $this->assertEquals($expectedCode, $this->client->getResponse()->getStatusCode());
    // }


    public function testSuscripcion()
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(userRepository::class);

        $testUser = $userRepository->findOneByEmail('gastoncumoll@hotmail.com');

        $client->loginUser($testUser);
        

        $crawler = $client->request('GET', 'login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        // $buttonCrwalerNode = $crawler->selectButton('Save');
        // $form =$buttonCrwalerNode->form();

        // $form['suscripcion[tipoPublicacion]']='Libro';
        // $form['suscripcion[usuario]']='gastoncumoll@gmail.com';

        
        // $client->submit($form);


        // $client->submit($form,[
        //     'suscripcion[tipoPublicacion]'=>'Libro',
        //     'suscripcion[usuario]'=>'gastoncumoll@gmail.com',
        // ]);
        //$form = $crawler->filter('fas fa-save');
        

        //dd($buttonCrawlerNode);
        

        // $crawler = $client->submitForm(, [
        //     'suscripcion[tipoPublicacion]' =>('Libro'),
        //     'suscripcion[usuario]' =>('gastoncumoll@hotmail.com'),
        // ]);


        // submit the Form object
        //$crawler = $client->submit($form);

        
        
    }
    
}