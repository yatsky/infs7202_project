<?php
/**
 * Created by PhpStorm.
 * User: thoma
 * Date: 21/05/2018
 * Time: 1:17 PM
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Photo;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends BaseController
{

    /**
     * @Route("/user/add-comment", name="add_comment")
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function addComment(Request $request)
    {

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            if (!is_null($this->getUser())) {
                $em = $this->getDoctrine()->getManager();
                $photoRepo = $em->getRepository(Photo::class);
                $photo = $photoRepo->findOneBy(array('id' => $request->get('id')));

                $comment = new Comment();

                $comment->setPhoto($photo);
                $comment->setUser($this->getUser());
                $comment->setContent($request->get('comment'));
                $em->persist($comment);
                $em->flush();
                $arrData = ["comment" => "added successfully!"];
                return new JsonResponse($arrData);
            } else {
                return $this->redirectToRoute("signin");
            }

        }
        return $this->redirectToRoute('homepage');
    }


    /**
     * @Route("/comments", name="view_comments")
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function viewComments(Request $request)
    {
        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $id = $request->get('id');
            $em = $this->getDoctrine()->getManager();
            $commentsRepo = $em->getRepository(Comment::class);
            $photo = $em->getRepository(Photo::class)->findOneBy(array('id' => $id));
            $comments = $commentsRepo->findBy(array('photo' => $photo));
            $commentsContent = array();
            foreach ($comments as $comment) {
                array_push($commentsContent, $comment->getContent());
            }
            $arrData = [
                'id' => $id,
                'comments' => $commentsContent
            ];
            return new JsonResponse($arrData);
        }
        return $this->redirectToRoute('homepage');
    }
}