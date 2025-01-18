<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class FavoriteControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/favorite');

        $p = $crawler->filter("p");

        $this->assertEquals(2, count($p));
        $this->assertSelectorTextContains("p", "Your wishlist is empty.");

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200, Response::HTTP_OK);
    }
}
