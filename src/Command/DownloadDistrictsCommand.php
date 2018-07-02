<?php

namespace App\Command;


use App\Controller\DistrictController;
use App\Controller\Extractors\Gdansk;
use App\Controller\Extractors\Krakow;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;


class DownloadDistrictsCommand extends ContainerAwareCommand
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('app:get-districts');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'districts downloader',
            '============',
            '',
        ]);

        $extractors = [
            new Gdansk(),
            new Krakow()
        ];

        $districts = [];
        foreach ($extractors as $extractor) {
            array_merge($districts, $extractor->pobierz());
        }

        $em = $this->getContainer()->get('doctrine')->getManager();

        foreach ($districts as $district) {
            $em->persist($district);
        }
        $em->flush();




    }


}