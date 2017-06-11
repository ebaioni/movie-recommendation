<?php
use PHPUnit\Framework\TestCase;
date_default_timezone_set("Australia/Sydney");
require_once __DIR__ . '/../MovieRecommendation.php';

class MovieRecommendationTest extends TestCase
{
    public $movieRecommendation;
    /**
     * @before
     */
    public function setup()
    {
        $mockHttpClient = $this->getMockBuilder(HttpClientWrapper::class)
            ->setMethods(['get'])
            ->getMock();
        $httpReturn = new stdClass();
        $httpReturn->body = file_get_contents(__DIR__ . '/mocks/showlist.json');
        $mockHttpClient->method('get')->will($this->returnValue($httpReturn));
        $this->mockHttp = $mockHttpClient;
    }
    public function testGetRecommendation12hrFormat()
    {
        $movieRecommendation = new MovieRecommendation($this->mockHttp);
        $date = new DateTime("7:30pm");
        $genre = "Comedy";

        $results = $movieRecommendation->getRecommendation($genre, $date);
        
        $this->assertEquals($results[0]->getName(), 'Zootopia');


    }

    public function testGetRecommendation24hrFormat()
    {
        $movieRecommendation = new MovieRecommendation($this->mockHttp);
        $date = new DateTime("19:30");
        $genre = "Comedy";

        $results = $movieRecommendation->getRecommendation($genre, $date);

        $this->assertEquals($results[0]->getName(), 'Zootopia');
    }
}
