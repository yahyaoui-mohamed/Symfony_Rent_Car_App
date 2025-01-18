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

        $ul = $crawler->filter("ul");

        $this->assertSelectorTextContains("a", "Morent");

        $this->assertEquals(5, count($ul));

        // $buttons = $crawler->filter("button");
        // $icons = $crawler->filter("i");
        // $this->assertEquals(2, count($buttons));
        // $this->assertEquals(7, count($icons));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200, Response::HTTP_OK);
    }
}
