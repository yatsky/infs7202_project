<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 29/04/2018
 * Time: 9:41 PM
 */

namespace App\Controller;


use App\Entity\Photo;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends BaseController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="index")
     */
    public function showIndex()
    {
        $this->start();
        $photoRepo = $this->getDoctrine()->getRepository(Photo::class);
        $this->imgs = $photoRepo->loadSomePhotos(10);
        return $this->render("home.html.twig", array("navs"=>$this->navs, "imgs"=>$this->imgs));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/about", name="about")
     */
    public function showAbout()
    {
        $this->start();
        return $this->render("about.html.twig");
    }

}