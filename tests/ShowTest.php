<?php
use PHPUnit\Framework\TestCase;
date_default_timezone_set('Australia/Sydney');
require_once __DIR__ . '/../Show.php';

class ShowTest extends TestCase
{
    public $show;
    /**
     * @before
     */
    public function setupShow()
    {
        $data = json_decode(file_get_contents(__DIR__ . '/mocks/singleShow.json'));
        $this->show = new Show($data);   
    }
    public function testIsGenre()
    {
        $this->assertEquals($this->show->isGenre('Animation'), true);
        $this->assertEquals($this->show->isGenre('aniMation'), true);
        $this->assertEquals($this->show->isGenre('comedy'), true);
        $this->assertEquals($this->show->isGenre('drama'), false);
    }

    public function testFirstAfter()
    {
        $dateTime = new DateTime('20:00');
        $firstShow = $this->show->firstAfter($dateTime);
        $this->assertEquals($firstShow->format('H:i'), '21:00');

        $dateTime = new DateTime('22:00');
        $noShow = $this->show->firstAfter($dateTime);
        $this->assertEquals($noShow, null);
    }
}
