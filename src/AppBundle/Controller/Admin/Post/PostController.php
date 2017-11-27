<?php

namespace AppBundle\Controller\Admin\Post;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;

class PostController extends Controller
{
    /**
     * @Route("/admin", defaults={"page" = 1}, name="admin_homepage", requirements={"page": "[1-9]\d*"})
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getListAction(Request $request)
    {
        $em    = $this->getDoctrine()->getManager();
        $er    = $em->getRepository(Post::class);
        $query = $er->getPosts();

        $paginator  = $this->get('knp_paginator');
        $posts = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            $this->getParameter('app.admin.page_per_page')
        );

        return $this->render('AppBundle:admin/post:list.html.twig',
            array('posts' => $posts)
        );
    }
}
