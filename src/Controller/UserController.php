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
    public function logIn()
    {
        return null;
    }
    /**
     * @param $id
     * @return Response
     * @Route("/user/{id}", name="user", requirements={"id"="\d+"})
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
            return new Response("You've created a new user! User ID: " . $user->getId());
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
    public function newPhoto(Request $request, $id)
    {


        //build the form
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);

        // handle the form submission
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //get current user
            $users = $this->getDoctrine()->getRepository(User::class);
            $cUser = $users->findOneBy(array('id' => intval($id)));
            $photo->setOwner($cUser);
            $photo->setImageName($form->get('imageName')->getData());
            $photo->setPrice($form->get('price')->getData());
            $photo->setImageFile($form->get('imageFile')->getData());
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();
            return new Response("You've uploaded a new photo! Photo name: " . $photo->getImageName());
        }
        $this->start();
        return $this->render("user.html.twig", array(
            'form' => $form->createView(),
            'navs' => $this->navs
        ));

    }


    public function addComment($id)
    {

    }
    /**
     * @param $id
     * @return Response
     * @Route("/user/{user_id}/delete/{id}", name="delete_one", requirements={"id"="\d+"})
     */
    public function deleteOnePhoto($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Photo::class);
        $photo = $repo->findOneBy(['id' => $id]);
        $em->remove($photo);
        $em->flush();
        return new Response("You deleted one photo. " . $photo->getPhotoName());
    }
}