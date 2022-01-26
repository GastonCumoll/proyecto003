<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use DateTime;


class EdicionControllerTest extends WebTestCase
{
    public function testEdicion(): void
    {
        $client = static::createClient();
        
        $userRepository = static::getContainer()->get(UserRepository::class);
        $testUser = $userRepository->findOneByEmail('gastoncumoll@gmail.com');
        
        $client->loginUser($testUser);

        //index
        $crawler = $client->request('GET', '/edicion');
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        //edit
        $crawler = $client->request('GET', '/edicion/1/edit');
        //$link = $crawler->selectLink("Edit")->link(); //Busca el primer boton edit
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrwalerNode = $crawler->selectButton('Update');
        $form =$buttonCrwalerNode->form();

        $form['edicion[cantidadImpresiones]']='24';
        $form['edicion[publicacion]']='6';//busca por id
        $form['edicion[usuarioCreador]']='505';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        
        //new
        $crawler = $client->request('GET', '/edicion/new');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrwalerNode = $crawler->selectButton('Save');
        $form =$buttonCrwalerNode->form();

        $form['edicion[cantidadImpresiones]']='48';
        $form['edicion[publicacion]']='5';//busca por id
        $form['edicion[usuarioCreador]']='20';

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $client->submit($form);

        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        //delete
        $crawler = $client->request('GET', '/edicion/2/edit');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $buttonCrwalerNode = $crawler->selectButton('Delete');
        $form =$buttonCrwalerNode->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());

    }

    
}