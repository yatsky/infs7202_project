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
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends BaseController
{
    /**
     * @return Response
     * @Route("/myhome", name="show_user")
     */
    public function showUser()
    {
        $this->start();
        $user = $this->getUser();
        $user_name = $user->getUserName();
        $imgs = $user->getPhotos();
        return $this->render('user/user_index.html.twig', array('username' => $user_name,
            'navs' => $this->navs, 'imgs' => $imgs));
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/new-photo", name="new_photo")
     */
    public function newPhoto(Request $request)
    {

        //build the form
        $photo = new Photo();
        $form = $this->createForm(PhotoType::class, $photo);

        // handle the form submission
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //get current user
            $cUser = $this->getUser();
            $photo->setImageFile($form->get('imageFile')->getData());
            $photo->setPhotoName($form->get('photoName')->getData());
            // no need to set VICH related fields
//            $photo->setImageName($form->get('imageName')->getData());
            $photo->setPrice($form->get('price')->getData());
//            $photo->setImageSize($photo->getImageFile()->getSize());
            $photo->setOwner($cUser);
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();
            return $this->redirectToRoute('show_user');
//            return new Response("You've uploaded a new photo! Photo name: " . $photo->getImageName());
        }
        $this->start();
        return $this->render("user/user_upload.html.twig", array(
            'form' => $form->createView(),
            'navs' => $this->navs,
            'username' => $this->getUser()->getUsername()
        ));

    }

    /**
     * @Route("/myhome/listphotos", name="list_photos")
     */

    public function listPhotos(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $photos = $this->getUser()->getPhotos();
            $photoNames = array();
            $photoPrices = array();
            foreach ($photos as $photo) {
                array_push($photoNames, $photo->getPhotoName());
                array_push($photoPrices, $photo->getPrice());
            }
            $arrData = [
                'photoNames' => $photoNames,
                'photoPrices' => $photoPrices
            ];
            return new JsonResponse($arrData);
        }
        return $this->render('home.html.twig');
    }

    /**
     * @param $id
     * @return Response
     * @Route("/myhome/delete/{id}", name="delete_one", requirements={"id"="\d+"})
     */
    public function deleteOnePhoto($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $this->getDoctrine()->getRepository(Photo::class);
        $photo = $repo->findOneBy(['id' => $id]);
        $em->remove($photo);
        $em->flush();
        return $this->redirectToRoute('show_user');
    }


}