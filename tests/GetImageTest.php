<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

const IMAGE_TO_TEST = 10;

class GetImageTest extends WebTestCase
{
    public function test_it_gets_existing_image()
    {
        $client = $this->createClient();

        $client->request('GET', '/api/images/' . IMAGE_TO_TEST, [], [], ['HTTP_ACCEPT' => 'application/ld+json']);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/ld+json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('@context', $content);
        $this->assertArrayHasKey('@id', $content);
        $this->assertSame('/api/contexts/Image', $content['@context']);
        $this->assertSame('/api/images/' . IMAGE_TO_TEST, $content['@id']);

        $this->assertArrayHasKey('path', $content);
        $this->assertArrayHasKey('text', $content);
        $this->assertArrayHasKey('user', $content);
        $this->assertArrayHasKey('comments', $content);
        $this->assertArrayHasKey('nbLikes', $content);
    }

    /**
     * @depends test_it_gets_existing_image
     */
    public function test_image_has_user()
    {
        $client = $this->createClient();

        $client->request('GET', '/api/images/' . IMAGE_TO_TEST, [], [], ['HTTP_ACCEPT' => 'application/ld+json']);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/ld+json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('@id', $content['user']);
        $this->assertIsString($content['user']['@id']);
        $this->assertArrayHasKey('@type', $content['user']);
        $this->assertSame('User', $content['user']['@type']);
        $this->assertArrayHasKey('email', $content['user']);
        $this->assertIsString($content['user']['email']);


        $this->assertArrayNotHasKey('password', $content['user']);
        $this->assertArrayNotHasKey('plainPassword', $content['user']);
    }

    /**
     * @depends test_it_gets_existing_image
     */
    public function test_image_has_comments()
    {
        $client = $this->createClient();

        $client->request('GET', '/api/images/' . IMAGE_TO_TEST, [], [], ['HTTP_ACCEPT' => 'application/ld+json']);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/ld+json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('@id', $content['comments'][0]);
        $this->assertIsString($content['comments'][0]['@id']);
        $this->assertArrayHasKey('@type', $content['comments'][0]);
        $this->assertSame('Comment', $content['comments'][0]['@type']);
        $this->assertArrayHasKey('author', $content['comments'][0]);
        $this->assertArrayHasKey('text', $content['comments'][0]);
        $this->assertArrayHasKey('createdAt', $content['comments'][0]);
    }
}
