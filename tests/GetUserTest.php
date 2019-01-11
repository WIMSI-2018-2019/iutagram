<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

const USER_TO_TEST = 5;

class GetUserTest extends WebTestCase
{
    public function test_it_gets_existing_user()
    {
        $client = $this->createClient();

        $client->request('GET', '/api/users/' . USER_TO_TEST, [], [], ['HTTP_ACCEPT' => 'application/ld+json']);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/ld+json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('@context', $content);
        $this->assertArrayHasKey('@id', $content);
        $this->assertSame('/api/contexts/User', $content['@context']);
        $this->assertSame('/api/users/5', $content['@id']);

        $this->assertArrayHasKey('email', $content);
        $this->assertArrayHasKey('images', $content);
    }

    /**
     * @depends test_it_gets_existing_user
     */
    public function test_user_has_images()
    {
        $client = $this->createClient();

        $client->request('GET', '/api/users/' . USER_TO_TEST, [], [], ['HTTP_ACCEPT' => 'application/ld+json']);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/ld+json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('path', $content['images'][0]);
        $this->assertIsString($content['images'][0]['path']);
        $this->assertArrayHasKey('text', $content['images'][0]);
        $this->assertIsString($content['images'][0]['text']);
        $this->assertArrayHasKey('nbLikes', $content['images'][0]);
        $this->assertIsInt($content['images'][0]['nbLikes']);

    }

    public function test_user_doesnt_contains_credientials()
    {
        $client = $this->createClient();

        $client->request('GET', '/api/users/' . USER_TO_TEST, [], [], ['HTTP_ACCEPT' => 'application/ld+json']);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/ld+json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayNotHasKey('password', $content);
        $this->assertArrayNotHasKey('plainPassword', $content);
    }
}
