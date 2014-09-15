<?php

namespace MSS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use MSS\CoreBundle\Entity\User;

class DiscussionController extends Controller {

    public function listGroupAction(Request $request) {
        $session = $request->getSession();
        $username = $session->get('uname');

        $groups = '';
        if ($username) {
            $stmt = $this->getDoctrine()->getManager()
                    ->getConnection()
                    ->prepare('SELECT ug.username, ug.isadmin, ug.groupid, c.groupname, c.description, c.createtime FROM users_groups ug JOIN chatgroup c ON ug.groupid = c.groupid WHERE ug.username=:username');
            $stmt->bindValue('username', $username);
            $stmt->execute();
            $groups = $stmt->fetchAll();
        } else {
            return $this->render('MSSCoreBundle:User:login.html.twig');
        }

        if ($groups) {
            return $this->render('MSSCoreBundle:Discussion:listGroup.html.twig', array('groups' => $groups));
        } else {
            return $this->render('MSSCoreBundle:Discussion:listGroup.html.twig');
        }
    }

    public function createGroupAction(Request $request) {
        if ($request->getMethod() == 'POST') {
            $session = $request->getSession();
            $uname = $session->get('uname');

            if (!$uname) {
                return $this->render('MSSCoreBundle:User:login.html.twig');
            }

            $groupname = $request->get('groupname');
            $description = $request->get('description');
            $memberRes = $request->get('memberRes');

            $group = new \MSS\CoreBundle\Entity\Chatgroup();
            $group->setGroupname($groupname);
            $group->setDescription($description);
            $group->setCreatetime(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($group);
            $em->flush();

            $groupid = $group->getGroupid();

            $memberRes = explode(',', $memberRes);
            foreach ($memberRes as $memb) {
                if ($memb != '') {
                    $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:User');
                    $user = new User();
                    $user = $repos->findOneBy(array('email' => $memb));

                    $user_group = new \MSS\CoreBundle\Entity\UsersGroups();
                    $username = $user->getUsername();
                    $user_group->setUsername($username);
                    $user_group->setGroupid($groupid);
                    if ($username == $uname) {
                        $user_group->setIsadmin(1);
                    }

                    $em->persist($user_group);
                    $em->flush();
                }
            }
            return $this->render('MSSCoreBundle:Discussion:createGroup.html.twig');
        } else {
            $appRoot = $this->get('kernel')->getRootDir();

            $stmt = $this->getDoctrine()->getManager()
                    ->getConnection()
                    ->prepare('SELECT u.email from user u');
            $stmt->execute();
            $users = $stmt->fetchAll();

            $result = array();
            for ($i = 0; $i < count($users); $i++) {
                array_push($result, $users[$i]["email"]);
            }

            $jsonsDir = $appRoot . "/../web/jsonfiles";
            $usersFile = $jsonsDir . "/emails.json";
            $fs = new Filesystem();

            if (!is_dir($jsonsDir)) {
                if (false === @mkdir($jsonsDir, 0777, true)) {
                    throw new \RuntimeException(sprintf("Unable to create the directory (%s)\n", $jsonsDir));
                }
            } elseif (!is_writable($jsonsDir)) {
                throw new \RuntimeException(sprintf("Unable to write in the directory (%s)\n", $jsonsDir));
            }

            $content = json_encode($result);
            $fs->dumpFile($usersFile, $content);

            return $this->render('MSSCoreBundle:Discussion:createGroup.html.twig');
        }
    }

    public function listTopicAction(Request $request, $groupid) {
        $session = $request->getSession();
        $uname = $session->get('uname');

        if(!$uname) {
            return $this->render('MSSCoreBundle:User:login.html.twig');
        }
        
        $stmt = $this->getDoctrine()->getManager()
                ->getConnection()
                ->prepare('SELECT tg.groupid, tg.topicid, t.topicname, t.description, t.createtime FROM topics_groups tg JOIN topic t ON tg.topicid = t.topicid WHERE tg.groupid=:groupid');
        $stmt->bindValue('groupid', $groupid);
        $stmt->execute();
        $topics = $stmt->fetchAll();

        if ($topics) {
            return $this->render('MSSCoreBundle:Discussion:listTopic.html.twig', array('topics' => $topics, 'groupid' => $groupid));
        } else {
            return $this->render('MSSCoreBundle:Discussion:listTopic.html.twig', array('groupid' => $groupid));
        }
    }

    public function createTopicAction(Request $request, $groupid) {
        $session = $request->getSession();
        $uname = $session->get('uname');

        if(!$uname) {
            return $this->render('MSSCoreBundle:User:login.html.twig');
        }
        
        if ($request->getMethod() == 'POST') {
            $topicname = $request->get('topicname');
            $description = $request->get('description');

            $topic = new \MSS\CoreBundle\Entity\Topic();
            $topic->setTopicname($topicname);
            $topic->setDescription($description);
            $topic->setCreatetime(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            $topic_group = new \MSS\CoreBundle\Entity\TopicsGroups();
            $topic_group->setGroupid($groupid);
            $topic_group->setTopicid($topic->getTopicid());

            $em->persist($topic_group);
            $em->flush();
        }
        
        return $this->render('MSSCoreBundle:Discussion:createTopic.html.twig', array('groupid' => $groupid));
    }

    public function listPostAction(Request $request, $groupid, $topicid) {
        $session = $request->getSession();
        $uname = $session->get('uname');

        if(!$uname) {
            return $this->render('MSSCoreBundle:User:login.html.twig');
        } 
        
        $stmt = $this->getDoctrine()->getManager()
                ->getConnection()
                ->prepare('SELECT p.parent, p.replyto, p.postid, p.content, p.createtime, p.poster, p.topicid, u.username, u.photopath FROM post p JOIN user u ON p.poster=u.username WHERE p.topicid=:topicid');
        $stmt->bindValue('topicid', $topicid);
        $stmt->execute();
        $posts = $stmt->fetchAll();
        
        if($posts){
            return $this->render('MSSCoreBundle:Discussion:listPost.html.twig', array('groupid' => $groupid,'topicid'=>$topicid,'posts'=>$posts));
        } else {
            return $this->render('MSSCoreBundle:Discussion:listPost.html.twig', array('groupid' => $groupid,'topicid'=>$topicid));
        }
    }
    
    public function createPostAction(Request $request, $groupid, $topicid) {
        if($request->getMethod() == 'POST') {
            $session = $request->getSession();
            $uname = $session->get('uname');
            
            if(!$uname) {
                return $this->render('MSSCoreBundle:User:login.html.twig');
            } 
            
            $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:User');
            $user = $repos->findOneBy(array('username' => $uname));
            
            $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:Topic');
            $topic = $repos->findOneBy(array('topicid' => $topicid));
            
            $content = $request->get('content');
            $post = new \MSS\CoreBundle\Entity\Post();
            $post->setContent($content);
            $post->setTopicid($topic);
            $post->setPoster($user);
            $post->setCreatetime(new \DateTime());
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            
            return $this->redirect($this->generateUrl('mss_core_discussion_listp', array('groupid'=>$groupid,'topicid'=>$topicid)));
        }
    }
    
    public function replyPostAction(Request $request) {
        if($request->getMethod() == 'POST') {
            $groupid = $request->get('grouptag');
            $topicid = $request->get('topictag');
            $postid = $request->get('posttag');
            $replyto = $request->get('replytotag');
            
            $session = $request->getSession();
            $uname = $session->get('uname');
            
            if(!$uname) {
                return $this->render('MSSCoreBundle:User:login.html.twig');
            } 
            
            $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:User');
            $user = $repos->findOneBy(array('username' => $uname));
            
            $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:Topic');
            $topic = $repos->findOneBy(array('topicid' => $topicid));
            
            $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:Post');
            $parent = $repos->findOneBy(array('postid' => $postid));
            
            $content = $request->get('replycontent');
            $post = new \MSS\CoreBundle\Entity\Post();
            $post->setContent($content);
            $post->setTopicid($topic);
            $post->setPoster($user);
            $post->setCreatetime(new \DateTime());
            $post->setParent($parent);
            $post->setReplyto($replyto);
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            
            return $this->redirect($this->generateUrl('mss_core_discussion_listp', array('groupid'=>$groupid,'topicid'=>$topicid)));
        }
    }
}
