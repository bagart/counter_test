<?php

class ControllerCounterGetTest extends TestCase
{
    public function testGet()
    {
        $this->get('/counter');
        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertEquals('application/json', $this->response->headers->get('content-type'));
    }

    public function testGetJson()
    {
        $this->get('/counter?format=json');

        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertEquals('application/json', $this->response->headers->get('content-type'));
        $this->assertNotEmpty($this->response->getContent());
        $this->assertStringStartsWith('[{', $this->response->getContent());
        $this->assertStringEndsWith('}]', $this->response->getContent());
        $json = json_decode($this->response->getContent(), true);
        $this->assertNotEmpty($json);
        $this->assertArrayHasKey('country', $json[0]);
        $this->assertArrayHasKey('event', $json[0]);
        $this->assertArrayHasKey('counter', $json[0]);

    }

    public function testGetCsv()
    {
        $this->get('/counter?format=csv');
        $this->assertEquals(200, $this->response->getStatusCode());
        $this->assertEquals('text/csv', $this->response->headers->get('content-type'));
        ob_start();
        $this->response->sendContent();
        $result = ob_get_clean();

        $this->assertGreaterThan(0, mb_strlen($result));
    }
}