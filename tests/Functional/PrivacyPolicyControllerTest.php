<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PrivacyPolicyControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/privacy-policy');

        $this->assertSelectorTextContains("h3", "Privacy & Policy");

        $list = $crawler->filter("ul");
        $listItem = $crawler->filter("li");
        $p = $crawler->filter("p");
        $h5 = $crawler->filter("h5");

        $this->assertEquals(9, count($p));
        $this->assertEquals(8, count($h5));

        $this->assertEquals(10, count($list));
        $this->assertEquals(35, count($listItem));

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200, Response::HTTP_OK);
    }
}
