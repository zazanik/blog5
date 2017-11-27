<?php

namespace AppBundle\Controller\Common\Post;

use AppBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * @Route("/", defaults={"page" = 1}, name="homepage", requirements={"page": "[1-9]\d*"})
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
            $this->getParameter('app.page_per_page')
        );

        return $this->render('AppBundle:common/post:list.html.twig',
            array('posts' => $posts)
        );
    }

    /**
     * @Route("/post/{post}", name="single_post", requirements={"post": "[1-9]\d*"})
     *
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPostAction(Post $post)
    {
        return $this->render('AppBundle:common/post:item.html.twig',
            array(
                'post' => $post
            )
        );
    }
}
