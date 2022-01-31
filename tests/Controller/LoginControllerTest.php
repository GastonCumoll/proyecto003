<?php

namespace App\Tests\Controller;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class LoginControllerTest extends WebTestCase
{
    public function testUserLogin(): void
        {
        
            $client = static::createClient();
        
            $userRepository = static::getContainer()->get(UserRepository::class);
            $testUser = $userRepository->findOneByEmail('ADMINISTRADOR_TEST@admin.com');
            // //dd($testUser);
        
            $client->loginUser($testUser);
            
            $client->request('GET', '/logedIn');
            //$crawler = $client->followRedirect();
            
            $this->assertSelectorTextContains('h2', 'holi');
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
            
            //varios metodos para saber si cargo bien la pagina :
            //$this->assertEquals(200, $client->getResponse()->getStatusCode());

            // $client->request('GET', '/logout');
            // $crawler = $client->followRedirect();
            // $this->assertEquals(200, $client->getResponse()->getStatusCode());
            
            
    }

}