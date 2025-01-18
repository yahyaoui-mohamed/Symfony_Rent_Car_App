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
        $icons = $crawler->filter("i");

        $images = $crawler->filter("img");

        $this->assertSelectorTextContains('h5', 'The best platform');
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200, Response::HTTP_OK);

        $this->assertSelectorTextContains('a', 'Morent');

        $this->assertEquals(18, count($images));
        // $this->assertEquals(2, count($buttons));
        // $this->assertEquals(16, count($filterButtons));
        // $this->assertEquals(55, count($icons));
    }
}
