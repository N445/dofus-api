<?php

namespace App\Command;

use App\Client\DofusClient;
use App\Provider\Guilde\GuildeDataProvider;
use App\Provider\Perso\PersoDataProvider;
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
     * @var GuildeDataProvider
     */
    private $guildeDataProvider;

    /**
     * TestCommand constructor.
     * @param string|null        $name
     * @param PersoDataProvider  $persoDataProvider
     * @param GuildeDataProvider $guildeDataProvider
     */
    public function __construct(string $name = null, PersoDataProvider $persoDataProvider, GuildeDataProvider $guildeDataProvider)
    {
        parent::__construct($name);
        $this->persoDataProvider  = $persoDataProvider;
        $this->guildeDataProvider = $guildeDataProvider;
    }

    protected function configure()
    {
        $this->setDescription('Commande de test');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

//        $perso = $this->persoDataProvider->getObjectPerso('841461500206-ana-naas');
//        $perso = $this->persoDataProvider->getObjectPerso('164348700212-naas');
//        $perso  = $this->persoDataProvider->getObjectPerso('903526500205-ds-louis-defunes');
//        $guilde = $this->guildeDataProvider->getObjectGuilde('620800206-unreal');
        $guilde = $this->guildeDataProvider->getObjectGuilde('6690900036-royaume-serrah');
        dump($guilde);
        $io->success('Test ok !');

        return 0;
    }
}
