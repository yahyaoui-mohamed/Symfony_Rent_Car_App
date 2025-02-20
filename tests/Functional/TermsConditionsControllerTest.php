<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class TermsConditionsControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/terms-conditions');

        $h5 = $crawler->filter("h5");
        $ul = $crawler->filter("ul");
        $li = $crawler->filter("li");
        $p = $crawler->filter("p");

        $this->assertSelectorTextContains("h3", "Terms & Conditions");

        $this->assertEquals(9, count($ul));
        $this->assertEquals(37, count($li));
        $this->assertEquals(9, count($h5));
        $this->assertEquals(7, count($p));

        $this->assertResponseStatusCodeSame(200, Response::HTTP_OK);
        $this->assertResponseIsSuccessful();
    }
}
