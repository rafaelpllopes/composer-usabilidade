<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    public function __construct(private ClientInterface $httpClient, private Crawler $crawler)
    {
    }

    public function buscar(string $url): array
    {
        $cursos = [];
        $resposta = $this->httpClient->request('GET', $url);

        $html = $resposta->getBody();
        $this->crawler->addHtmlContent($html);
        $elementosCursos = $this->crawler->filter('span.card-curso__nome');
        foreach ($elementosCursos as $elementoCurso) {
            $cursos[] = $elementoCurso->textContent;
        }
        return $cursos;
    }
}
