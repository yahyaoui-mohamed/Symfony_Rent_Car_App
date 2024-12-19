<?php

namespace App\Tests\App\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class IndexControllerTest extends WebTestCase
{
    public function testIndexController(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $buttons = $crawler->selectButton("Rental Car");
        $filterButtons = $crawler->filter("button");
        $images = $crawler->filter("img");
        $icons = $crawler->filter("i");

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200, Response::HTTP_OK);
        $this->assertSelectorTextContains('h5', 'The best platform');
        $this->assertSelectorTextContains('a', 'Morent');
        $this->assertEquals(2, count($buttons));
        $this->assertEquals(2, count($images));
        $this->assertEquals(3, count($filterButtons));
        $this->assertEquals(6, count($icons));
    }
}
