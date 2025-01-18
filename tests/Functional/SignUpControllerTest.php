<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class SignUpControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/register');

        $input = $crawler->filter("input");
        $button = $crawler->filter("button");

        $this->assertEquals(4, count($input));
        $this->assertEquals(1, count($button));

        $this->assertSelectorTextContains("h1", "Sign up");

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200, Response::HTTP_OK);
    }
}
