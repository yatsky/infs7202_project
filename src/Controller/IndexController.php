<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 29/04/2018
 * Time: 9:41 PM
 */

namespace App\Controller;


use App\Entity\Photo;
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
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/about", name="about")
     */
    public function showAbout()
    {
        $this->start();
        return $this->render("about.html.twig");
    }

    /**
     * @Route("/removeAll", name="remove_all")
     */
    public function deleteAllPhotos()
    {
        $em = $this->getDoctrine()->getManager();
        $photos = $em->getRepository(Photo::class);
        foreach ($photos as $photo) {
            $em->remove($photo);
        }
        $em->flush();
        return new Response("you deleted all photos.");
    }
}