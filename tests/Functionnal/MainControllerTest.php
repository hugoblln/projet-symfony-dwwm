<?php

namespace App\Tests\Functionnal;

use App\DataFixtures\AppFixtures;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

class MainControllerTest extends WebTestCase
{

    private $client;

    private $databaseTool;

    protected function setUp(): void
    {
         /* On crée un client que l'on stocke dans la propriété client pour le réutiliser 
rapidement */
        $this->client = self::createClient();

         /* On instancie la classe DatabaseToolCollection et on charge nos fixtures */
         $this->databaseTool = self::getContainer()->get(DatabaseToolCollection::class)->get();

         $this->databaseTool->loadFixtures([AppFixtures::class]);
    }

    public function testTerrainsPage()
    {
        /* On simule une requête HTTP de type GET sur la route /terrains avec le client */
        $this->client->request('GET', '/terrains');

         /* On s'attend à avoir un code de réponse 200 */
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testH1terrainsPage()
    {
        /* On simule une requête HTTP de type GET sur la route /terrains avec le client */
        $this->client->request('GET', '/terrains');

         /* On s'attend à avoir un code de réponse 200 */
        $this->assertSelectorTextContains('h1', 'Terrains Disponibles');
    }

    public function testContentTerrainsPage()
        {
           
         /* On stock le DOM (document HTML dans la variable $crawler) */
         $crawler = $this->client->request('GET', '/terrains'); 

        /* On s'attend à avoir 3 terrains donc on filtre la classe recherché dans le $crawler */
         $this->assertCount(3, $crawler->filter('.card-terrain'));

        }
}
