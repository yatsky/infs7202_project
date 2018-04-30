<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 29/04/2018
 * Time: 9:41 PM
 */

namespace App\Controller;


use App\Entity\Photo;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends BaseController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/home", name="index")
     */
    public function showIndex()
    {
        $this->start();
        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $this->imgs = $photoRepo->loadSomePhotos(10);
        return $this->render("home.html.twig", array("navs"=>$this->navs, "imgs"=>$this->imgs));
    }

    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectHome()
    {
        return $this->redirectToRoute("index");
    }

    /**
     * @Route("signin", name="sign_in")
     */
    public function signIn()
    {
        $this->start();
        $form = $this->createForm(UserType::class);
        return $this->render("register.html.twig", array(
            'form' => $form->createView(),
            'navs' => $this->navs
        ));
    }
}