<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class TipoPublicacionControllerTest extends WebTestCase
{
    public function testTipoPublicacionNew(): void
    {
        $client = static::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('gastoncumoll@gmail.com');
        
        $client->loginUser($testUser);
        
        //index
        $crawler = $client->request('GET', '/tipo/publicacion');
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // $crawler = $client->followRedirect();

        //new 
        $crawler = $client->request('GET', '/tipo/publicacion/new');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrwalerNode = $crawler->selectButton('Save');
        $form =$buttonCrwalerNode->form();

        $form['tipo_publicacion[nombre]']='Periodico de Prueba_3';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //edit 
        $crawler = $client->request('GET', '/tipo/publicacion/5/edit');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrwalerNode = $crawler->selectButton('Update');
        $form =$buttonCrwalerNode->form();

        $form['tipo_publicacion[nombre]']='Periodico de Prueba_2_Editado';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //delete
        $crawler = $client->request('GET', '/tipo/publicacion/8/edit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrwalerNode = $crawler->selectButton('Delete');
        $form =$buttonCrwalerNode->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }
}