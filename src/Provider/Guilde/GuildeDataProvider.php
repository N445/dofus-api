<?php

namespace App\Provider\Guilde;

use App\Client\DofusClient;
use App\Model\Guilde\Guilde;
use App\Populator\Guilde\MembersDataPopulator;
use App\Populator\Guilde\PrimaryDataPopulator;
use App\Utils\Guilde\PageCalculator;
use GuzzleHttp\Psr7\Uri;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\Cache\ItemInterface;

class GuildeDataProvider
{
    const GUILDE_URL  = '/fr/mmorpg/communaute/annuaires/pages-guildes/%s';
    const MEMBERS_URL = self::GUILDE_URL . '/membres';
    const NB_PAGE_MAX = 2;

    /**
     * @var string
     */
    private $id;

    /**
     * @var integer
     */
    private $nbPageMax;

    /**
     * @var DofusClient
     */
    private $dofusClient;

    /**
     * @var FilesystemAdapter
     */
    private $cache;

    /**
     * @var PrimaryDataPopulator
     */
    private $primaryDataPopulator;

    /**
     * @var MembersDataPopulator
     */
    private $membersDataPopulator;

    /**
     * PersoDataProvider constructor.
     * @param DofusClient          $dofusClient
     * @param PrimaryDataPopulator $primaryDataPopulator
     * @param MembersDataPopulator $membersDataPopulator
     */
    public function __construct(
        DofusClient $dofusClient,
        PrimaryDataPopulator $primaryDataPopulator,
        MembersDataPopulator $membersDataPopulator
    )
    {
        $this->dofusClient          = $dofusClient;
        $this->cache                = new FilesystemAdapter();
        $this->primaryDataPopulator = $primaryDataPopulator;
        $this->membersDataPopulator = $membersDataPopulator;
    }

    public function getObjectGuilde(string $id, $nbPageMax = self::NB_PAGE_MAX)
    {
        /** @var Uri $uriConf */
        $uriConf = $this->dofusClient->getConfig('base_uri');

        $this->id        = $id;
        $this->nbPageMax = $nbPageMax;
        $guildeHtml      = new Crawler($this->getGuildHtml(), sprintf('%s://%s', $uriConf->getScheme(), $uriConf->getHost()));
        $guilde          = new Guilde($id);

        $this->primaryDataPopulator->populate($guilde, $guildeHtml);

        for ($page = 1; $page < PageCalculator::getNbPage($guilde); $page++) {
            if ($this->nbPageMax <= $page) {
                break;
            }
            $membersHtml = new Crawler($this->getMembersHtml($page), sprintf('%s://%s', $uriConf->getScheme(), $uriConf->getHost()));
            $this->membersDataPopulator->populate($guilde, $membersHtml);
        }

        return $guilde;
    }

    /**
     * @return mixed
     * @throws InvalidArgumentException
     */
    private function getGuildHtml()
    {
        return $this->cache->get(sprintf('guilde_%s', $this->id), function (ItemInterface $item) {
            $item->expiresAfter(3600);

            $response = $this->dofusClient->get(sprintf(self::GUILDE_URL, $this->id));

            if (200 !== $response->getStatusCode()) {
                throw new \Exception(sprintf('%s : %s', $response->getStatusCode(), $response->getReasonPhrase()));
            }
            return $response->getBody()->getContents();
        });
    }

    /**
     * @param int $page
     * @return mixed
     * @throws InvalidArgumentException
     */
    private function getMembersHtml(int $page)
    {
        return $this->cache->get(sprintf('members_%s_page_%s', $this->id, $page), function (ItemInterface $item) use ($page) {
            $item->expiresAfter(3600);
            $response = $this->dofusClient->get(sprintf(self::MEMBERS_URL, $this->id), [
                'page' => $page,
            ]);
            if (200 !== $response->getStatusCode()) {
                throw new \Exception(sprintf('%s : %s', $response->getStatusCode(), $response->getReasonPhrase()));
            }
            return $response->getBody()->getContents();
        });
    }
}
