<?php
/**
 * PHP 8.3
 */
namespace Alura\BuscadorDeCursos;

require "./vendor/autoload.php";
use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;
use PHPUnit\Framework\TestCase;
class Buscador extends TestCase
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $httpClient;
    /**
     * @var Crawler
     */
    private Crawler $crawler;
    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->httpClient = $httpClient;
        $this->crawler = $crawler;
    }
    public function buscar(string $url): array
    {
        $resposta = $this->httpClient->request('GET', $url);
        $html = $resposta->getBody();
        $this->crawler->addHtmlContent($html);
        $elementosCursos = $this->crawler->filter("span.card-curso__nome");
        $cursos = [];
        foreach ($elementosCursos as $curso) {
            $cursos[] = $curso->textContent;
        }
        return $cursos;
    }
}
