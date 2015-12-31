<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Battery;
use AppBundle\Form\Type\BatteryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class BatteryController extends Controller
{
    /**
     * @Route("/add", name="add_battery")
     */
    public function addAction()
    {
        $battery = new Battery();
        $form = $this->createForm(BatteryType::class, $battery);

        return $this->render(':battery:add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}