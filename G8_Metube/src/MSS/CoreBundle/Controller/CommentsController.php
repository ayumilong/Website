<?php

namespace MSS\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MSS\CoreBundle\Entity\Comments;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of CommentsController
 *
 * @author yanbai
 */
class CommentsController extends Controller {

    public function createAction(Request $request, $type, $mediaid) {
        $appRoot = $this->get('kernel')->getRootDir();

        if ($this->get('request')->isXmlHttpRequest()) {
            $session = $request->getSession();
            $uname = $session->get('uname');

            if ($uname) {
                $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:User');
                $user = $repos->findOneBy(array('username' => $uname));

                $content = trim($request->get("comtcontent"));

                $comment = new Comments();
                $comment->setContent($content);
                $comment->setMediatype($type);
                $comment->setMediaid($mediaid);
                $comment->setPosttime(new \DateTime());
                $comment->setCommenter($user);

                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:Comments');
                $returnComment = $repos->findOneBy(array('mediatype' => $type, 'mediaid' => $mediaid, 'content' => $content, 'commenter' => $user));
                $returnCommentID = $returnComment->getCommentid();

                $response = new Response();
                $output = array('success' => true, 'content' => $content, 'commentid' => $returnCommentID);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($output));

                return $response;
            } else {

                $response = new Response();
                $output = array('success' => false);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($output));

                return $response;
            }
        }
    }

    public function replyAction(Request $request, $type, $mediaid, $commentid) {

        if ($this->get('request')->isXmlHttpRequest()) {
            $session = $request->getSession();
            $uname = $session->get('uname');

            if ($uname) {
                $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:User');
                $user = $repos->findOneBy(array('username' => $uname));

                $content = trim($request->get("potentialreplycontent"));
		$commentid = ($request->get("commentid"));
                $comment = new Comments();
                $comment->setContent($content);
                $comment->setMediatype($type);
                $comment->setMediaid($mediaid);
                $comment->setPosttime(new \DateTime());
                $comment->setCommenter($user);
                $comment->setParent($commentid);

                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();

                $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:Comments');
                $returnComment = $repos->findOneBy(array('mediatype' => $type, 'mediaid' => $mediaid, 'content' => $content, 'commenter' => $user));
                $returnCommentID = $returnComment->getCommentid();
                
                //return response
                $response = new Response();
                $output = array('success' => true, 'content' => $content, 'commentid' => $returnCommentID);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($output));

                return $response;
            } else {

                $response = new Response();
                $output = array('success' => false);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($output));

                return $response;
            }
        }
    }

    public function getRepliesAction(Request $request) {

        if ($this->get('request')->isXmlHttpRequest()) {
            $session = $request->getSession();
            $commentid = $request->get("commentidToReplies");

            $stmt = $this->getDoctrine()->getManager()
                    ->getConnection()
                    ->prepare('SELECT * , u.photopath FROM comments c JOIN user u ON c.commenter = u.username WHERE c.parent =:parent');
            $stmt->bindValue('parent', $commentid);
            $stmt->execute();
            $allreplies = $stmt->fetchAll();

            if ($allreplies) {
                $response = new Response();
                $output = array('success' => true,'parentid'=> $commentid , 'data'=>$allreplies);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($output));
            } else {
                $response = new Response();
                $output = array('success' => false, 'data'=>$allreplies);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($output));
            }

            return $response;
        }
    }

}
