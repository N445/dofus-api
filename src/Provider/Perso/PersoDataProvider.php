<?php

namespace App\Provider\Perso;

use App\Client\DofusClient;
use App\Model\Perso\Perso;
use App\Populator\Perso\GuildeDataPopulator;
use App\Populator\Perso\MetierDataPopulator;
use App\Populator\Perso\PrimaryDataPopulator;
use GuzzleHttp\Psr7\Uri;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\Cache\ItemInterface;

class PersoDataProvider
{
    const PERSO_URL = '/fr/mmorpg/communaute/annuaires/pages-persos/%s';

    /**
     * @var string
     */
    private $id;

    /**
     * @var DofusClient
     */
    private $dofusClient;

    /**
     * @var PrimaryDataPopulator
     */
    private $primaryDataPopulator;

    /**
     * @var FilesystemAdapter
     */
    private $cache;

    /**
     * @var MetierDataPopulator
     */
    private $metierDataPopulator;

    /**
     * @var GuildeDataPopulator
     */
    private $guildeDataPopulator;

    /**
     * PersoDataProvider constructor.
     * @param DofusClient          $dofusClient
     * @param PrimaryDataPopulator $primaryDataPopulator
     * @param MetierDataPopulator  $metierDataPopulator
     * @param GuildeDataPopulator  $guildeDataPopulator
     */
    public function __construct(
        DofusClient $dofusClient,
        PrimaryDataPopulator $primaryDataPopulator,
        MetierDataPopulator $metierDataPopulator,
        GuildeDataPopulator $guildeDataPopulator
    )
    {
        $this->dofusClient          = $dofusClient;
        $this->primaryDataPopulator = $primaryDataPopulator;
        $this->cache                = new FilesystemAdapter();
        $this->metierDataPopulator  = $metierDataPopulator;
        $this->guildeDataPopulator  = $guildeDataPopulator;
    }

    public function getObjectPerso(string $id)
    {
        /** @var Uri $uriConf */
        $uriConf = $this->dofusClient->getConfig('base_uri');

        $this->id  = $id;
        $persoHtml = new Crawler($this->getPersoHtml(), sprintf('%s://%s',$uriConf->getScheme(),$uriConf->getHost()));
        $perso     = new Perso($id);

        $this->primaryDataPopulator->populate($perso, $persoHtml);
        $this->metierDataPopulator->populate($perso, $persoHtml);
        $this->guildeDataPopulator->populate($perso, $persoHtml);

        dump($perso);
        return $perso;
    }

    /**
     * @param $id
     * @return mixed
     * @throws InvalidArgumentException
     */
    private function getPersoHtml()
    {
        return $this->cache->get(sprintf('perso_%s', $this->id), function (ItemInterface $item) {
            $item->expiresAfter(3600);

            $response = $this->dofusClient->get(sprintf(self::PERSO_URL, $this->id));

            if (200 !== $response->getStatusCode()) {
                throw new \Exception(sprintf('%s : %s', $response->getStatusCode(), $response->getReasonPhrase()));
            }
            return $response->getBody()->getContents();
        });
    }
}
