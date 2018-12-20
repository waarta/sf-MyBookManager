<?php

namespace App\Controller;

use App\Entity\MarquePage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MarquePageController extends Controller
{

    /**
     * @Route("/marquesPages/", name="show_marquesPages")
     * @IsGranted("ROLE_USER")
     */
    public function index(Request $rq)
    {
        $mp = new MarquePage();
        $em = $this->getDoctrine()->getManager();
        $mpReposit = $this->getDoctrine()->getRepository(MarquePage::class);
        $user = $this->getUser();
        //$mps = $mpReposit->findAll();
        $query = $mpReposit->createQueryBuilder('mp')
            ->where('mp.user = :user')
            ->setParameter('user', $user)
            ->orderBy('mp.titre', 'ASC')
            ->getQuery();
        $mps = $query->getResult();

        return $this->render('marquePage.html.twig',
            ['marquesPages' => $mps]);
    }

    /**
     * @Route("/delete/{id}", name="delete_marquePage")
     * @IsGranted("ROLE_USER")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $mpReposit = $this->getDoctrine()->getRepository(MarquePage::class);
        $mp = $mpReposit->find($id);
        $em->remove($mp);
        $em->flush();
        return $this->redirectToRoute('show_marquesPages');
    }

    /**
     * @Route("/edit/{id}", name="edit_marquePage")
     * @IsGranted("ROLE_USER")
     */
    public function modify(Request $rq, $id)
    {

    }
}
