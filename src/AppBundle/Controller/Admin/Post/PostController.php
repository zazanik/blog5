<?php

namespace AppBundle\Controller\Admin\Post;

use AppBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Post;

class PostController extends Controller
{
    /**
     * @Route("/admin", defaults={"page" = 1}, name="admin_post_list", requirements={"page": "[1-9]\d*"})
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

    /**
     * @Route("/admin/post/new", name="post_new")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(PostType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();

            $em = $this->getDoctrine()->getManager();

            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'Post successfully created');

            return $this->redirectToRoute('admin_post_list');
        }

        return $this->render('AppBundle:admin/post:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/post/{id}/edit", name="post_edit", requirements={"id": "[1-9]\d*"})
     *
     * @param Request $request
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, Post $post)
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('success', 'Post updated!');
            return $this->redirectToRoute('admin_post_list');
        }

        return $this->render('AppBundle:admin/post:new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/post/{id}/delete", name="post_delete", requirements={"id":  "[1-9]\d*"})
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteAction(Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();
        
        return $this->redirectToRoute('admin_post_list');
    }
}
