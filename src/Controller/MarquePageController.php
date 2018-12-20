<?php

namespace App\Controller;

use App\Entity\MarquePage;
use App\Form\MarquePageType;
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
        $search = $rq->query->get('search');
        if ($search != "") {
            return $this->search($search);
        } else {
            $query = $mpReposit->createQueryBuilder('mp')
                ->where('mp.user = :user')
                ->setParameter('user', $user)
                ->orderBy('mp.dateCreate', 'DESC')
                ->getQuery();
            $mps = $query->getResult();
            return $this->render('marquePage.html.twig',
                ['marquesPages' => $mps]);
        }

    }

    public function search($search)
    {
        $mpReposit = $this->getDoctrine()->getRepository(MarquePage::class);
        $query = $mpReposit->createQueryBuilder('mp')
            ->where('mp.titre like :search')
            ->orWhere('mp.URL like :search')
            ->orWhere('mp.commentaire like :search')
            ->setParameter('search', '%' . $search . '%')
            ->orderBy('mp.dateCreate', 'ASC')
            ->getQuery();
        $mps = $query->getResult();
        return $this->render('marquePage.html.twig',
            ['marquesPages' => $mps]);
    }

    /**
     * @Route("/new/", name="new_marquePage")
     * @IsGranted("ROLE_USER")
     */
    function new (Request $request) {
        $mp = new MarquePage();
        $form = $this->createForm(MarquePageType::class, $mp);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
            $mp = $form->getData();
            $mp->setUser($this->getUser());
            $mp->setDateCreate(new \DateTime());
            $em->persist($mp);
            $em->flush();
            return $this->redirectToRoute('show_marquesPages');
        }
        return $this->render('newMarquePage.html.twig',
            ['form' => $form->createView()]);
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
