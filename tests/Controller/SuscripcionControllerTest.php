<?php


namespace App\tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\AbstractType;

class SuscripcionControllerTest extends WebTestCase
{

public function testIndex(){
    $client = static::createClient();
    $crawler = $client->request('GET','/suscripcion');

    $table=$crawler->filter('.table-enclosures');
    $this->assertCount(1,$table->filter('tbody tr'));

}
}