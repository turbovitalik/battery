<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BatteryControllerTest extends WebTestCase
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Client
     */
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->clearBatteryTable();
    }

    public function testFormSubmit()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/add');

        $buttonCrawlerNode = $crawler->selectButton('Save');

        $form = $buttonCrawlerNode->form();
        $form['battery[type]'] = 'AAA';
        $form['battery[count]'] = 10;

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect());
    }

    public function testStatisticsPage()
    {
        $this->addBattery("AAA", 10, 'User 1');
        $this->addBattery("AAA", 20, 'User 2');
        $this->addBattery("AA", 5);

        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());

        $batteryTypeAA = $crawler->filter('td[data-type="AA"]');
        $this->assertEquals(1, $batteryTypeAA->count());
        $this->assertEquals("5", $batteryTypeAA->first()->html());

        $batteryTypeAAA = $crawler->filter('td[data-type="AAA"]');
        $this->assertEquals(1, $batteryTypeAAA->count());
        $this->assertEquals("30", $batteryTypeAAA->first()->html());
    }

    private function addBattery($type, $count, $name = null)
    {
        $crawler = $this->client->request('GET', '/add');

        $buttonCrawlerNode = $crawler->selectButton('Save');

        $form = $buttonCrawlerNode->form();
        $form['battery[type]'] = $type;
        $form['battery[count]'] = $count;
        $form['battery[name]'] = $name;

        $this->client->submit($form);
    }

    private function clearBatteryTable()
    {
        $em = $this->client->getContainer()->get('doctrine')->getManager();
        $em->getRepository('AppBundle:Battery')->deleteAll();
    }
}
