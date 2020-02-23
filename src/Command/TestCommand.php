<?php

namespace App\Command;

use App\Client\DofusClient;
use App\Service\Perso\PersoDataProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TestCommand extends Command
{
    protected static $defaultName = 'app:test';

    /**
     * @var PersoDataProvider
     */
    private $persoDataProvider;

    /**
     * TestCommand constructor.
     * @param string|null       $name
     * @param PersoDataProvider $persoDataProvider
     */
    public function __construct(string $name = null, PersoDataProvider $persoDataProvider)
    {
        parent::__construct($name);
        $this->persoDataProvider = $persoDataProvider;
    }

    protected function configure()
    {
        $this->setDescription('Commande de test');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

//        $this->persoDataProvider->getObjectPerso('841461500206-ana-naas');
        $this->persoDataProvider->getObjectPerso('164348700212-naas');
//        $this->persoDataProvider->getObjectPerso('903526500205-ds-louis-defunes');

        $io->success('Test ok !');

        return 0;
    }
}
