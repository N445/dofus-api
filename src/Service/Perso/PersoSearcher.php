<?php

namespace App\Service\Perso;

use App\Client\DofusClient;
use App\Model\Perso\Search;
use GuzzleHttp\Psr7\Uri;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\Cache\ItemInterface;

class PersoSearcher
{
    const SEARCH_URL = '/fr/mmorpg/communaute/annuaires/pages-persos?text=%s&character_breed_id[]=%d&character_homeserv[]=%d';

    /**
     * @var DofusClient
     */
    private $dofusClient;

    /**
     * @var FilesystemAdapter
     */
    private $cache;

    /**
     * @var Search
     */
    private $search;

    /**
     * @var array
     */
    private $results = [];

    /**
     * PersoDataProvider constructor.
     * @param DofusClient $dofusClient
     */
    public function __construct(
        DofusClient $dofusClient
    )
    {
        $this->dofusClient = $dofusClient;
        $this->cache       = new FilesystemAdapter();
    }

    public function search(Search $search)
    {
        $this->search = $search;
        return $this->getResults();
    }

    private function getResults()
    {
        /** @var Uri $uriConf */
        $uriConf = $this->dofusClient->getConfig('base_uri');
        $crawler = new Crawler($this->getSearchHtml(), sprintf('%s://%s', $uriConf->getScheme(), $uriConf->getHost()));
        $result  = $crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.ak-container.ak-panel.ak-nocontentpadding div.ak-panel-content table.ak-table tbody tr');
        $result->each(function (Crawler $node, $i) {
            $node                                             = $node->filter('td')->eq(1)->filter('a');
            $this->results[basename($node->link()->getUri())] = $node->text();
        });
        return $this->results;
    }


    /**
     * @param $id
     * @return mixed
     * @throws InvalidArgumentException
     */
    private function getSearchHtml()
    {
        return $this->cache->get(sprintf('2search_%s_%d_%d', $this->search->getClasse(), $this->search->getServer(), $this->search->getName()), function (ItemInterface $item) {
            $item->expiresAfter(3600);

            $response = $this->dofusClient->get(sprintf(self::SEARCH_URL, $this->search->getName(), $this->search->getClasse(), $this->search->getServer()));

            if (200 !== $response->getStatusCode()) {
                throw new \Exception(sprintf('%s : %s', $response->getStatusCode(), $response->getReasonPhrase()));
            }
            return $response->getBody()->getContents();
        });
    }
}
