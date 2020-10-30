<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CharacterControllerTest extends WebTestCase
{
    private $content;
    private $client;
    private static $identifier;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
    * Tests redirect index
    */

    public function getRedirectIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/character');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * Tests index
     */
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/character');

        $this->assertJsonResponse($client->getResponse());
    }

    /**
     * Tests Display
     */
    public function testDisplay()
    {
        $this->client->request('GET', '/character/display/' . self::$identifier);

        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    /**
     * Tests Create
     */
    public function testCreate()
    {
        $this->client->request('POST', '/character/create');

        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
    }

    /**
    * Asserts that a response is in json
    */

    public function assertJsonResponse(){
        $response = $this->client->getResponse();
        $this->content = json_decode($response->getContent(), true, 50);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    /**
     * Tests redirect bad identifier
     */

    public function testBadIdentifier()
    {
        $this->client->request('GET', '/character/display/badIdentifier');
        $this->asserError404($this->client->getResponse()->getStatusCode());
    }

    /**
     * Asserts that Rsponse returns 404
     */
    public function assertError404($statusCode)
    {
        $this->assertEquals(404, $statusCode);
    }

    /**
     * Tests inexisting identifier
     */
    public function testInexistingIdentifier()
    {
        $this->client->request('GET', '/character/display/');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests modify
     */
    public function testModify()
    {
        $this->client->request('PUT', '/character/modify/' . self::$identifier);

        $this->assertJsonResponse();
        $this->assertIdentifier();
    }

    /**
     * Tests delete
     */
    public function testDelete()
    {
        $this->client->request('DELETE', '/character/delete/' . self::$identifier);

        $this->assertJsonResponse();
    }

    /**
     * Asserts that 'identifier' is present in the Response
     */
    public function assertIdentifier()
    {
        $this->assertArrayHasKey('identifier', $this->content);
    }

    /**
     * Defines identifier
     */
    public function defineIdentifier(){
        self::$identifier = $this->content['identifier'];
    }
}
