<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 16/05/2018
 * Time: 11:15 PM
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends BaseController
{

    /**
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/register", name="new_user")
     */
    public function newUser(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->start();
        // build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the password
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setAccountBalance(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return new Response("You've registered! Your email is: " . $user->getEmail());
        }

//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $user->setUsername($form->get('userName')->getData());
//            $user->setPassword($form->get('password')->getData());
//            $user->setAccountBalance(0);
//            $em->persist($user);
//            $em->flush();
//            return new Response("You've created a new user! User ID: " . $user->getUsername());
//        }
        return $this->render("user_index.html.twig", array(
            'form' => $form->createView(),
            'navs' => $this->navs
        ));
    }

    /**
     * @Route("/signin", name="signin")
     */
    public function signIn(Request $request, AuthenticationUtils $authenticationUtils)
    {
        $this->start();
        $error = $authenticationUtils->getLastAuthenticationError();

        // last user name entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
            'navs' => $this->navs
        ));
//        $user = new User();
//        $form = $this->createForm(UserType::class, $user);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $passwd = $form->get('password')->getData();
//            $username = $form->get('userName')->getData();
//            $em = $this->getDoctrine()->getManager();
//            $users = $em->getRepository(User::class);
//            $found_user = $users->findOneBy(array('user_name'=>$username,
//                'password'=>$passwd));
//            if (is_null($found_user)) {
//                return new Response("Wrong user name or password!");
//
//            } else {
////                return new Response("You found a user!");
////                $this->redirectToRoute("show_user");
////                $this->redirectToRoute('show_user', array('user_name'=>$found_user->getId()));
//                $this->redirect('www.google.com');
//            }
////            return new Response("Number of users found: ". strval(isset($found_user)));
//        }
//        return $this->render("login.html.twig", array(
//            'form' => $form->createView(),
//            'navs' => $this->navs));
    }

    /**
     * This is the route the user can use to logout.
     *
     * But, this will never be executed. Symfony will intercept this first
     * and handle the logout automatically. See logout in app/config/security.yml
     *
     * @Route("/logout", name="security_logout")
     */
    public function logout(): void
    {
        throw new \Exception('This should never be reached!');
    }
}