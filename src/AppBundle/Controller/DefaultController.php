<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $statistics = $this->getDoctrine()
            ->getRepository('AppBundle:Battery')->getStatistics();

        return $this->render(':default:index.html.twig', [
           'statistics' => $statistics,
        ]);
    }
}
