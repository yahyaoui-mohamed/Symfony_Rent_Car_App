<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CarsTest extends WebTestCase
{
    public function testCarController(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/cars');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200, Response::HTTP_OK);
    }
}
