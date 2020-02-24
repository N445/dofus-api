<?php

namespace App\Command;

use App\Model\Perso\Search;
use App\Provider\Perso\PersoDataProvider;
use App\Service\Perso\PersoSearcher;
use App\Utils\Perso\ClasseProvider;
use App\Utils\Perso\ServerProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class PersoSearchCommand extends Command
{
    protected static $defaultName = 'app:perso:search';

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var SymfonyStyle
     */
    private $io;

    /**
     * @var \Symfony\Component\Console\Helper\QuestionHelper
     */
    private $helper;

    /**
     * @var bool
     */
    private $classeId;

    /**
     * @var bool
     */
    private $serverId;

    private $persoName;

    /**
     * @var PersoSearcher
     */
    private $persoSearcher;

    /**
     * @var Search
     */
    private $search;

    private $perso;

    /**
     * @var PersoDataProvider
     */
    private $persoDataProvider;

    /**
     * PersoSearchCommand constructor.
     * @param string|null   $name
     * @param PersoSearcher $persoSearcher
     */
    public function __construct(string $name = null, PersoSearcher $persoSearcher, PersoDataProvider $persoDataProvider)
    {
        parent::__construct($name);
        $this->persoSearcher = $persoSearcher;
        $this->persoDataProvider = $persoDataProvider;
    }

    protected function configure()
    {
        $this
            ->setDescription('Recherche un perso');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->input  = $input;
        $this->output = $output;
        $this->io     = new SymfonyStyle($input, $output);
        $this->helper = $this->getHelper('question');

        $this->setClasse();
        $this->setServer();
        $this->setPersoName();
//        $this->classeId  = 8;
//        $this->serverId  = 212;
//        $this->persoName = 'Naas';
        $this->search    = (new Search())
            ->setClasse($this->classeId)
            ->setServer($this->serverId)
            ->setName($this->persoName)
        ;

        $this->setPerso();

        $this->persoDataProvider->getObjectPerso($this->perso);

        $this->io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }

    private function setClasse()
    {
        $questionClasses = new ChoiceQuestion(
            'Selectionner une classe',
            ClasseProvider::getClasses(),
            0
        );

        $classe = $this->helper->ask($this->input, $this->output, $questionClasses);

        $this->classeId = ClasseProvider::getIdFromText($classe);
    }

    private function setServer()
    {
        $questionServer = new ChoiceQuestion(
            'Selectionner un serveur',
            ServerProvider::getServers(),
            0
        );

        $server = $this->helper->ask($this->input, $this->output, $questionServer);

        $this->serverId = ServerProvider::getIdFromText($server);
    }

    private function setPersoName()
    {
        $question = new Question('Entrez un nom de joueur : ');

        $this->persoName = $this->helper->ask($this->input, $this->output, $question);
    }

    private function setPerso()
    {
        $questionClasses = new ChoiceQuestion(
            'Selectionner un perso',
            $this->persoSearcher->search($this->search),
            0
        );

        $this->perso = $this->helper->ask($this->input, $this->output, $questionClasses);
    }
}
