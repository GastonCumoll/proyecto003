<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class RegisterControllerTest extends WebTestCase
{
    public function testRegister(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $buttonCrwalerNode = $crawler->selectButton('Register');
        $form =$buttonCrwalerNode->form();

        $form['registration_form[email]']='ADMINISTRADOR_TEST@admin.com';
        $form['registration_form[agreeTerms]']=true;
        $form['registration_form[plainPassword]']='contraseña';
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        
        
        $client->submit($form);
    }

}


