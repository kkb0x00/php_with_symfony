<?php

namespace App\Command;


use App\Controller\Extractors\Gdansk;
use App\Controller\Extractors\Krakow;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class DownloadDistrictsCommand extends ContainerAwareCommand
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this->setName('app:get-districts');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'districts downloader started'
        ]);

        $extractors = [
            Gdansk::class,
            Krakow::class
        ];

        $districts = array();
        foreach ($extractors as $extractor) {
            $districts = array_merge($districts, $extractor::pobierz());
        }

        foreach ($districts as $district) {
            $this->em->persist($district);
        }

        $this->em->flush();

        $output->writeln([
            'districts downloader finished'
        ]);

    }


}