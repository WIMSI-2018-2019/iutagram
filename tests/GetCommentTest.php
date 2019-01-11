<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

const COMMENT_TO_TEST = 100;

class GetCommentTest extends WebTestCase
{
    public function test_it_gets_existing_comment()
    {
        $client = $this->createClient();

        $client->request('GET', '/api/comments/' . COMMENT_TO_TEST, [], [], ['HTTP_ACCEPT' => 'application/ld+json']);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/ld+json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('@context', $content);
        $this->assertArrayHasKey('@id', $content);
        $this->assertSame('/api/contexts/Comment', $content['@context']);
        $this->assertSame('/api/comments/' . COMMENT_TO_TEST, $content['@id']);

        $this->assertArrayHasKey('text', $content);
        $this->assertArrayHasKey('author', $content);
        $this->assertArrayHasKey('subject', $content);
    }

    /**
     * @depends test_it_gets_existing_comment
     */
    public function test_comment_has_user()
    {
        $client = $this->createClient();

        $client->request('GET', '/api/comments/' . COMMENT_TO_TEST, [], [], ['HTTP_ACCEPT' => 'application/ld+json']);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/ld+json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('@id', $content['author']);
        $this->assertIsString($content['author']['@id']);
        $this->assertArrayHasKey('@type', $content['author']);
        $this->assertSame('User', $content['author']['@type']);
        $this->assertArrayHasKey('email', $content['author']);
        $this->assertIsString($content['author']['email']);


        $this->assertArrayNotHasKey('password', $content['author']);
        $this->assertArrayNotHasKey('plainPassword', $content['author']);
    }

    /**
     * @depends test_it_gets_existing_comment
     */
    public function test_comment_has_image()
    {
        $client = $this->createClient();

        $client->request('GET', '/api/comments/' . COMMENT_TO_TEST, [], [], ['HTTP_ACCEPT' => 'application/ld+json']);

        $this->assertSame(200, $client->getResponse()->getStatusCode());
        $this->assertSame('application/ld+json; charset=utf-8', $client->getResponse()->headers->get('Content-Type'));

        $content = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('@id', $content['subject']);
        $this->assertIsString($content['subject']['@id']);
        $this->assertArrayHasKey('@type', $content['subject']);
        $this->assertSame('Image', $content['subject']['@type']);
        $this->assertArrayHasKey('path', $content['subject']);
        $this->assertIsString($content['subject']['path']);
    }
}
