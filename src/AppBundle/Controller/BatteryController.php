<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Battery;
use AppBundle\Form\Type\BatteryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BatteryController extends Controller
{
    /**
     * @Route("/add", name="add_battery")
     */
    public function addAction(Request $request)
    {
        $battery = new Battery();
        $form = $this->createForm(BatteryType::class, $battery);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render(':battery:add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}