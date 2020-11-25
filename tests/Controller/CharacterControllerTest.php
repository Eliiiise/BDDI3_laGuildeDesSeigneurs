<?php

namespace App\Tests\Controller;

use App\Entity\Character;
use http\Env\Request;
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
        $this->client->request('GET', '/character/index');

        $this->assertJsonResponse($this->client->getResponse());
    }

    /**
     * Tests Create
     */
    public function testCreate()
    {
        $this->client->request('POST',
            '/character/create',
            array(),//parameters
            array(),//file
            array('CONTENT_TYPE' => 'application/json'),//server
            '{"kind":"Dame","name":"Eldalótë","surname":"Fleur elfique","caste":"Elfe","knowledge":"Arts","intelligence":120,"life":12,"image":"/images/eldalote.jpg"}'
        );

        $this->assertJsonResponse();
        $this->defineIdentifier();
        $this->assertIdentifier();
    }

    /**
     * Tests Display
     */
    public function testDisplay()
    {
        $this->client->request('GET', '/character/display/' . self::$identifier);

        $this->assertJsonResponse($this->client->getResponse());
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
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /**
     * Asserts that Response returns 404
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
        $this->client->request('GET', '/character/display/d885b804acfa71be57662febef658fc435fc727y');
        $this->assertError404($this->client->getResponse()->getStatusCode());
    }

    /**
     * Tests modify
     */
    public function testModify(){
        //Test with partial data array
        $this->client->request(
            'PUT',
            '/character/modify/' . self::$identifier,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"kind":"Dame","name":"Eldalóta"}'
        );
        $this->assertJsonResponse($this->client->getResponse());
        $this->assertIdentifier();

        //Test with whole content
        $this->client->request(
            'PUT',
            '/character/modify/' . self::$identifier,
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            '{"kind":"Seigneur","name":"Gorthol","surname":"Heaume de terreur","caste":"Chevalier","knowledge":"Diplomatie","intelligence":200,"life":9,"image":"/images/test.jpg"}'
        );
        $this->assertJsonResponse($this->client->getResponse());
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
