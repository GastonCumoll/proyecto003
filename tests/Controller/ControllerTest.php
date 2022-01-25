<?php

namespace App\Tests\Controller;

use DateTime;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerTest extends WebTestCase
{
    public function Register(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        //$this->assertResponseIsSuccessful();
        //$this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrwalerNode = $crawler->selectButton('Register');
        $form =$buttonCrwalerNode->form();

        $form['registration_form[email]']='gastonCAdmin@gmail.com';
        $form['registration_form[agreeTerms]']=true;
        $form['registration_form[plainPassword]']='contraseña';
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        $client->submit($form);
    }

    public function UserLogin(): void
    {
        
        $client = static::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('gastoncumoll@gmail.com');
        
        $client->loginUser($testUser);
        
        $client->request('GET', '/login');
        //$crawler = $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    public function PublicacionNew(): void
    {
        $client = static::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('gastoncumoll@gmail.com');
        
        
        $client->loginUser($testUser);
        
        $crawler = $client->request('GET', '/publicacion/new');
        //$crawler = $client->followRedirect();


        $buttonCrwalerNode = $crawler->selectButton('Save');
        $form =$buttonCrwalerNode->form();

        $form['publicacion[titulo]']='Publicacion 3';
        $form['publicacion[tipoPublicacion]']='1';//busca por id
        $form['publicacion[usuarioCreador]']='500';
        $form['publicacion[cantidadImpresiones]']='20';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    
    public function SuscripcionNew(): void
    {
        $client = static::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('gastoncumoll@gmail.com');
        
        
        $client->loginUser($testUser);
        
        $crawler = $client->request('GET', '/suscripcion/new');
        //$crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrwalerNode = $crawler->selectButton('Save');
        $form =$buttonCrwalerNode->form();

        $form['suscripcion[usuario]']='500';
        $form['suscripcion[tipoPublicacion]']='2';//busca por id
        

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testEdicionNew(): void
    {
        $client = static::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('gastoncumoll@gmail.com');
        
        
        $client->loginUser($testUser);
        
        $crawler = $client->request('GET', '/edicion/new');
        //$crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrwalerNode = $crawler->selectButton('Save');
        $form =$buttonCrwalerNode->form();

        $form['edicion[cantidadImpresiones]']='50';
        $form['edicion[publicacion]']='3';//busca por id
        $form['edicion[usuarioCreador]']='500';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

}


