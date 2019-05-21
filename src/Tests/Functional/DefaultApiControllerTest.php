<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DefaultApiControllerTest
 * @package App\Tests\Functional
 */
class DefaultApiControllerTest extends WebTestCase
{
    public function testGetUsersByIdNoContent()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/users/9999999');
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    public function testCGetUsers()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v1/users');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testCPutUsersWrongData()
    {
        $client = static::createClient();

        $client->request(
            'PUT',
            '/api/v1/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"test":"test"}'
        );
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    public function testCPutUsersCorrectData()
    {
        $client = static::createClient();

        $client->request(
            'PUT',
            '/api/v1/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"filter_params": {}, "data" :{"creation_date": "2008-05-20T03:58:21+00:00"}}'
        );
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }

    public function testPostUsersWrongData()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"test":"test"}'
        );
        $this->assertEquals(500, $client->getResponse()->getStatusCode());
    }

    public function testPostUsersCorrectData()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/v1/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{ 
                "email": "test1@mailtest.com", 
	            "last_name": "Last", 
	            "first_name": "First", 
	            "state": true, 
	            "creation_date": "2019-01-01T03:58:21+00:00", 
	            "groups": [] 
	        }'
        );
        $this->assertEquals(201, $client->getResponse()->getStatusCode());
    }
}
