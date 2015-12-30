<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class BatteryController extends Controller
{
    /**
     * @Route("/add", name="add_battery")
     */
    public function addAction()
    {
        return $this->render(':battery:add.html.twig');
    }
}