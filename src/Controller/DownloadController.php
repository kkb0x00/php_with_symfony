<?php

namespace App\Controller;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use FOS\RestBundle\Controller\Annotations as FOSRest;

/**
 * Download controller.
 *
 * @Route("/download")
 */
class DownloadController extends Controller
{

    /**
     * Download all Districts.
     * @FOSRest\Get
     *
     *
     * @param KernelInterface $kernel
     * @return Response
     * @throws \Exception
     */
    public function download(KernelInterface $kernel)
    {
        $application = new Application($kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(array('command' => 'app:get-districts'));
        $output = new BufferedOutput();

        $application->run($input, $output);

        $content = $output->fetch();

        return new Response($content);
    }



}