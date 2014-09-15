<?php

namespace MSS\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MSS\CoreBundle\Entity\Message;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of MessageController
 *
 * @author yanbai
 */
class MessageController extends Controller {

    public function getAllAction(Request $request) {
        $session = $request->getSession();
        $username = $session->get('uname');

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
                ->select('m')
                ->from('MSSCoreBundle:Message', 'm')
                ->where('m.receivor=?1')
                ->orderBy('m.sendtime', 'DESC')
                ->setParameter(1, $username)
                ->getQuery();

        $messages = $query->getResult();

        return $this->render("MSSCoreBundle:Message:MessageList.html.twig", array('messages' => $messages));
    }

    public function createAction(Request $request) {
        if ($this->get('request')->isXmlHttpRequest()) {
            $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:User');
            $session = $request->getSession();

            $username = $session->get('uname');
            $user = $repos->findBy(array('username' => $username));

            $receivorname = $request->get('receivor');
            $receivor = $repos->findBy(array('username' => $receivorname));

            $subject = $request->get("subject");
            $content = $request->get("content");

            if ($receivor) {
                $message = new Message();
                $message->setSender($user[0]);
                $message->setReceivor($receivor[0]);
                $message->setSubject($subject);
                $message->setContent($content);
                $message->setSendtime(new \DateTime());
                $message->setIsread(0); //0 read 1 unread

                $em = $this->getDoctrine()->getManager();
                $em->persist($message);
                $em->flush();

                $response = new Response();
                $output = array('success' => true);
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($output));

                return $response;
            } else {
                $response = new Response();
                $output = array('success' => false, 'message' => 'Receivor cannot be found!');
                $response->headers->set('Content-Type', 'application/json');
                $response->setContent(json_encode($output));

                return $response;
            }
        } else {
            $response = new Response();
            $output = array('success' => false);
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($output));

            return $response;
        }
    }

    public function readAction(Request $request) {
        if ($this->get('request')->isXmlHttpRequest()) {
            $messageid = $request->get("isreadstatue");

            $em = $this->getDoctrine()->getManager();
            $message = $em->getRepository('MSSCoreBundle:Message')->findOneBy(array('messageid' => $messageid));

            if (!$message) {
                throw $this->createNotFoundException(
                        'No message found for id ' . $messageid
                );
            }

            $message->setReceivetime(new \DateTime());
            $message->setIsread(1);
            $em->flush();
            
            $response = new Response();
            $output = array('success' => true);
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($output));
            
            return $response;
        }
    }

    public function replyAction(Request $request) {
        if ($this->get('request')->isXmlHttpRequest()) {
            $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:User');
            $session = $request->getSession();

            $username = $session->get('uname');
            $sender = $repos->findBy(array('username' => $username));

            $replyReceivorname = $request->get("replyReceivor");
            $receivor = $repos->findBy(array('username' => $replyReceivorname));

            $replySubject = $request->get("replySubject");
            $replyContent = $request->get("replyContent");

            $message = new Message();
            $message->setIsread(0);
            $message->setReceivor($receivor[0]);
            $message->setSender($sender[0]);
            $message->setSubject($replySubject);
            $message->setSendtime(new \DateTime());
            $message->setContent($replyContent);

            $em = $this->getDoctrine()->getManager();
            $em->persist($message);
            $em->flush();

            $response = new Response();
            $output = array('success' => true);
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($output));

            return $response;
        }
    }

}
