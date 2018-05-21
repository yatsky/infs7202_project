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
     * @Route("/home", name="homepage")
     */
    public function showIndex()
    {
        $this->start();
        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $this->imgs = $photoRepo->findAll();
        return $this->render("home.html.twig", array(
            "navs" => $this->navs,
            "imgs" => $this->imgs,
//            "test" => sizeof($this->imgs)
        ));
    }

    /**
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectHome()
    {
        return $this->redirectToRoute("homepage");
    }
}