<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Battery;
use AppBundle\Form\Type\BatteryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BatteryController
 * @package AppBundle\Controller
 */
class BatteryController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction()
    {
        $statistics = $this->getDoctrine()
            ->getRepository('AppBundle:Battery')->getStatistics();

        return $this->render(':battery:index.html.twig', [
            'statistics' => $statistics,
        ]);
    }

    /**
     * @param Request $request
     *
     * @Route("/add", name="add_battery")
     *
     * @return Response
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

    /**
     * @Route("/remove-all", name="remove_all")
     *
     * @return Response
     */
    public function removeAllAction()
    {
        $this->getDoctrine()->getRepository('AppBundle:Battery')->deleteAll();

        return $this->redirectToRoute('homepage');
    }
}
