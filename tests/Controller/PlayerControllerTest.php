<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerControllerTest extends WebTestCase
{
    private $content;
    private static $identifier;
    private $client;

    public function setUp(){
        $this->client = static::createClient();
    }

    /*
    * Tests redirect index
    */

    public function getRedirectIndex()
    {
        $this->client->request('GET', '/player');

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    /*
    * Test bad identifier
    */

    public function testBadIdentifier()
    {
        $this->client->request('GET', 'player/display/badIdentifier');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /*
    * Test that Response returns 404
    */

    public function assertError404($statusCode)
    {
        $this->assertEquals(404, $statusCode);
    }


    /*
    * Tests create
    */

    public function testCreate(){
        $this->client->request(
            'POST',
            '/player/create',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'), //server
            '{"firstname":"Chloé","lastname":"Mabboux","email":"chloe@mabboux.fr","mirian":"10", "password":"sdkdksdk"}');
        $this->assertJsonResponse($this->client->getResponse());

        $this->assertIdentifier();
        $this->defineIdentifier();
    }


    /*
    * Test inexisting identifier
    */

    public function testInexistingIdentifier()
    {
        $this->client->request('GET', 'player/display/6d36c7ec8ac882f6632eb4c60199bd96f2675ee5');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /*
    * Tests index
    */

    public function testIndex()
    {
        $this->client->request('GET', '/player/index');

        $this->assertJsonResponse($this->client->getResponse());
    }

    /*
    * Tests display
    */

    public function testDisplay(){
        //var_dump(self::$identifier);
        $this->client->request('GET', '/player/display/' . self::$identifier);
        $this->assertJsonResponse($this->client->getResponse());
        $this->assertIdentifier();
    }

    /*
    * Tests modify
    */

    public function testModify(){
        //Test with partial data array
        $this->client->request(
            'PUT',
            '/player/modify/' . self::$identifier,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"firstname":"Chloe","lastname":"Mabboux"}');
        $this->assertJsonResponse($this->client->getResponse());
        $this->assertIdentifier();

        //Test with whole content
        $this->client->request(
            'PUT',
            '/player/modify/' . self::$identifier,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"firstname":"Chloé","lastname":"Mabboux","email":"chloe@mabboux.fr","mirian":"10", "password":"sdkdksdk"}');
        $this->assertJsonResponse($this->client->getResponse());
        $this->assertIdentifier();
    }

    /*
    * Tests delete
    */

    public function testDelete(){

        $this->client->request('DELETE', '/player/delete/' . self::$identifier);

        $this->assertJsonResponse();
    }



    /*
    * Asserts that a response is in json
    */

    public function assertJsonResponse(){
        $response = $this->client->getResponse();
        $this->content = json_decode($response->getContent(), true, 50);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->headers->contains('Content-Type', 'application/json'), $response->headers);
    }

    /**
     * Defines identifier
     */

    public function defineIdentifier(){
        self::$identifier = $this->content['identifier'];
    }

    /**
     * Assert identifier
     */

    public function assertIdentifier(){
        $this->assertArrayHasKey('identifier', $this->content);
    }


}
