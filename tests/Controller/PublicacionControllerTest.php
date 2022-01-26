<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class PublicacionControllerTest extends WebTestCase
{
    public function testPublicacion(): void
    {
        $client = static::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('gastoncumoll@gmail.com');
        
        $client->loginUser($testUser);
        

        
        //index
        $crawler = $client->request('GET', '/publicacion');
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        

        //edit
        $crawler = $client->request('GET', '/publicacion/7/edit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrwalerNode = $crawler->selectButton('Update');
        $form =$buttonCrwalerNode->form();

        $form['publicacion[titulo]']='Publicacion de prueba_2.9999';
        $form['publicacion[tipoPublicacion]']='5';//busca por id
        $form['publicacion[usuarioCreador]']='505';
        $form['publicacion[cantidadImpresiones]']='77';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        //new
        $crawler = $client->request('GET', '/publicacion/new');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrwalerNode = $crawler->selectButton('Save');
        $form =$buttonCrwalerNode->form();

        $form['publicacion[titulo]']='Publicacion de Prueba_7';
        $form['publicacion[tipoPublicacion]']='5';//busca por id
        $form['publicacion[usuarioCreador]']='505';
        $form['publicacion[cantidadImpresiones]']='777';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        //delete
        //hay que tener cuidado con las FK
        /*
            $crawler = $client->request('GET', '/publicacion/13/edit');
            $this->assertEquals(200, $client->getResponse()->getStatusCode());

            $buttonCrwalerNode = $crawler->selectButton('Delete');
            $form =$buttonCrwalerNode->form();
        
            $client->submit($form);
            $crawler = $client->followRedirect();
            $this->assertEquals(200, $client->getResponse()->getStatusCode());
        */

    }
}