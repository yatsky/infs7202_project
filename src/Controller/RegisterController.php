<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 30/04/2018
 * Time: 8:44 PM
 */

namespace App\Controller;


use App\Form\UserType;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends BaseController
{
    /**
     * @Route("/register", name="register")
     */
    public function register()
    {
        $this->start();
        $form = $this->createForm(UserType::class);
        return $this->render("register.html.twig", array(
            'form' => $form->createView(),
            'navs' => $this->navs
        ));
    }
}