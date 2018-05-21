<?php

namespace AppBundle\Controller;

use AppBundle\Entity\blogusers\Post;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/home", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array());
    }

    /**
     * @Route("/postlist", name="postlist")
     */
    public function showPostList(Request $request)
    {
        $postList = $this->getDoctrine()
            ->getRepository('AppBundle:blogusers\Post')
            ->findAll();
        return $this->render('posts/postlist.html.twig', array('postList' => $postList));
    }

    /**
     * @Route("/userpostlist", name="userpostlist")
     */
    public function showUserPostList(Request $request)
    {
        $postList = $this->getDoctrine()
            ->getRepository('AppBundle:blogusers\Post')
            ->findByAuthor($this->getUser());
        return $this->render('posts/postlistforuser.html.twig', array('postList' => $postList));
    }



    /**
     * @Route("/addnewpost", name="addnewpost")
     */
    public function addNewPost(Request $request)
    {
        $post = new Post();
        $form = $this->createFormBuilder($post)
            ->add('title',  TextType::class)
            ->add('description', TextType::class)
            ->add('photopath',TextType::class)
            ->add('summary', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create'))
            ->getForm();
        $form->handleRequest($request);
        $time = new \DateTime();
        $time->format('H:i:s \O\n Y-m-d');
        if ($form->isSubmitted() && $form->isValid())
        {
            $title = $form['title']->getData();
            $author = $this->getUser();
            $addedAt = $time;
            $description = $form['description']->getData();
            $photopath = $form['photopath']->getData();
            $summary = $form['summary']->getData();
            $post->setTitle($title);
            $post->setAuthor($author);
            $post->setAddedAt($addedAt);
            $post->setDescription($description);
            $post->setPhotoPath($photopath);
            $post->setSummary($summary);

                $em = $this->getDoctrine()->getManager();
                $em->persist($post);
                $em->flush();
                $request->getSession()
                    ->getFlashBag()
                    ->add('sucess', 'Project created!');
        }
        return $this->render('posts/addnewpost.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/{title}/details", name="details")
     */
    public function detailsAction($title)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:blogusers\Post')
            ->findOneByTitle($title);
        if (!$post) {
            throw $this->createNotFoundException('No post found for ' . $title);
        }
        return $this->render('posts/details.html.twig', array('post' => $post));
    }

    /**
     * @Route("/{title}/edit", name="edit")
     */
    public function editAction($title, Request $request)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:blogusers\Post')
            ->findOneByTitle($title);

            $post->setTitle($post->getTitle());
            $post->setAddedAt($post->getAddedAt());
            $post->setDescription($post->getDescription());
            $post->setPhotoPath($post->getPhotoPath());
            $post->setSummary($post->getSummary());

        $form = $this->createFormBuilder($post)
            ->add('title',  TextType::class)
            ->add('author', TextType::class)
            ->add('description', TextType::class)
            ->add('photopath',TextType::class)
            ->add('summary', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Change'))
            ->getForm();
        $form->handleRequest($request);
        $time = new \DateTime();
        $time->format('H:i:s \O\n Y-m-d');
        if ($form->isSubmitted() && $form->isValid()) {
            $title = $form['title']->getData();
            $author = $form['author']->getData();
            $description = $form['description']->getData();
            $photopath = $form['photopath']->getData();
            $summary = $form['summary']->getData();
            $em = $this->getDoctrine()->getManager();
            $post = $em->getRepository('AppBundle:blogusers\Post');
            $em->flush();
            $request->getSession()
                ->getFlashBag()
                ->add('success', 'the project has been edited!');
            return $this->redirect($this->generateUrl('postlist'));
        }
        return $this->render('posts/edit.html.twig', array('post' => $post, 'form' => $form->createView()));
    }


}
