<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 29/04/2018
 * Time: 9:41 PM
 */

namespace App\Controller;


use App\Entity\Photo;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\File\File;
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
     * @Route("/nasaimages", name="nasa_images")
     */
    public function nasa()
    {
        $cmd = escapeshellcmd("python3 ./scripts/nasa.py");
        shell_exec($cmd);
        $this->start();
        $directory = "./images/nasa/";
        $images = glob($directory . "*.jpg");
        $imgs = array();
        $imgNames = array();
        foreach ($images as $image) {
            $file = new File($image);
            // end function requires a reference
            $temp = explode("/", $image);
            $name = end($temp);
            array_push($imgs, $file);
            array_push($imgNames, $name);
        }
        return $this->render('nasa.html.twig', array(
            'imgs' => $imgs,
            'navs' => $this->navs,
            'test' => sizeof($images),
            'imgNames' => $imgNames
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