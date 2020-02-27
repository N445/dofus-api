<?php

namespace App\Service\Perso;

use App\Client\DofusClient;
use App\Model\Perso\Search;
use App\Utils\Perso\SearchQueryBuilder;
use GuzzleHttp\Psr7\Uri;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\Cache\ItemInterface;

class PersoSearcher
{
    const SEARCH_URL = '/fr/mmorpg/communaute/annuaires/pages-persos';

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
     * @var SearchQueryBuilder
     */
    private $searchQueryBuilder;

    /**
     * @var array
     */
    private $query;

    /**
     * PersoDataProvider constructor.
     * @param DofusClient        $dofusClient
     * @param SearchQueryBuilder $searchQueryBuilder
     */
    public function __construct(
        DofusClient $dofusClient,
        SearchQueryBuilder $searchQueryBuilder
    )
    {
        $this->dofusClient        = $dofusClient;
        $this->cache              = new FilesystemAdapter();
        $this->searchQueryBuilder = $searchQueryBuilder;
    }

    public function search(Search $search)
    {
        $this->search = $search;
        $this->query  = $this->searchQueryBuilder->getQuery($this->search);
        return $this->getResults();
    }

    private function getResults()
    {
        /** @var Uri $uriConf */
        $uriConf = $this->dofusClient->getConfig('base_uri');
        $crawler = new Crawler($this->getSearchHtml(), sprintf('%s://%s', $uriConf->getScheme(), $uriConf->getHost()));
        $result  = $crawler->filter('html body.fr.ak-background-type-internal div.container.ak-main-container div.ak-main-content div.ak-main-page div.ak-container.ak-main-center div.ak-container.ak-panel.ak-nocontentpadding div.ak-panel-content table.ak-table tbody tr');
        $result->each(function (Crawler $node, $i) {
//            $this->setResult($node);
            $data   = [];
            $link   = $node->filter('td')->eq(1)->filter('a');
            $id     = basename($link->link()->getUri());
            $data[] = $link->text();
            $data[] = $node->filter('td')->eq(2)->filter('a')->text();
            $data[]             = $node->filter('td')->eq(3)->filter('span')->count() ?
                $node->filter('td')->eq(3)->filter('span')->text()
                :$node->filter('td')->eq(3)->text();
            $data[]             = $node->filter('td')->eq(4)->text();
            $data[]             = $node->filter('td')->eq(5)->text();
            $data[]             = $node->filter('td')->eq(6)->filter('a')->text();
            $this->results[$id] = implode(' ', array_filter($data));
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
        return $this->cache->get(sprintf('3search_%s', substr(str_shuffle(sha1(md5(serialize($this->search)))), 0, 20)), function (ItemInterface $item) {
            $item->expiresAfter(3600);

            $response = $this->dofusClient->get(self::SEARCH_URL, [
                'query' => $this->query,
            ]);
//            $response = $this->dofusClient->get(sprintf(self::SEARCH_URL, $this->search->getName(), $this->search->getClasse(), $this->search->getServer()));

            if (200 !== $response->getStatusCode()) {
                throw new \Exception(sprintf('%s : %s', $response->getStatusCode(), $response->getReasonPhrase()));
            }
            return $response->getBody()->getContents();
        });
    }

    private function setResult(Crawler $node)
    {
        $data   = [];
        $link   = $node->filter('td')->eq(1)->filter('a');
        $id     = basename($link->link()->getUri());
        $data[] = $link->text();
        $data[] = $node->filter('td')->eq(2)->filter('a')->text();
        $data[] = $node->filter('td')->eq(3)->filter('span')->text();
        $data[] = $node->filter('td')->eq(4)->text();
        $data[] = $node->filter('td')->eq(5)->text();
        $data[] = $node->filter('td')->eq(6)->filter('a')->text();
//        dd(array_filter($data));
        $this->results[$id] = implode(' ', array_filter($data));
    }
}
