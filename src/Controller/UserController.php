<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 29/04/2018
 * Time: 9:56 PM
 */

namespace App\Controller;

use App\Entity\Photo;
use App\Entity\User;
use App\Form\PhotoType;
use App\Form\UserType;
use Doctrine\ORM\Query\Expr\Base;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends BaseController
{


    /**
     * @Route("/user/{id}", name="user", requirements={"id"="\d+"})
     * @param $id
     */
    public function showUserIndex($id)
    {
        parent::start();
        return $this->render("home.html.twig", array(
            'navs' => $this->navs, 'imgs' => $this->imgs
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("user/new", name="new_user")
     */
    public function newUser(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setName($form->get('name')->getData());
            $user->setAcctBalance($form->get('acctBalance')->getData());
            $user->setRegisterDate($form->get('registerDate')->getData());
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("index");
        }
        return $this->render("user.html.twig", array(
            'form' => $form->createView()
        ));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/user/{id}/new-photo", name="new_photo")
     */
    public function newPhoto(Request $request)
    {
        //get current user

        //build the form
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);

        // handle the form submission
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();
            return $this->redirectToRoute("index");
        }

        return $this->render("user.html.twig", array(
            'form' => $form->createView()
        ));

    }


    /**
     * Add one photo the the database.
     * @param Photo $photo
     * @return Response
     */
    public function addPhoto(Photo $photo)
    {
        $em = $this->getDoctrine()->getManager();
        $em->persist($photo);
        $em->flush();

        return new Response("New photo (" . $photo->getPhotoName() . ") added!");
    }
}