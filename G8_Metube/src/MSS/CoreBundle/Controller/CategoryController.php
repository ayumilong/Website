<?php

namespace MSS\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MSS\CoreBundle\Entity\History;

/**
 * Description of CategoryController
 *
 * @author yanbai
 */
class CategoryController extends Controller {

    public function imagesAction(Request $request, $username) {
        $em = $this->getDoctrine()->getManager();
        if($username == 'all'){
            
            $query = $em->createQueryBuilder()
                ->select('i')
                ->from('MSSCoreBundle:Imagemedia', 'i')
                ->getQuery();

            $results = $query->getResult();
        }else{
            $results = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username));
        }

        return $this->render('MSSCoreBundle:Category:images.html.twig', array('images' => $results));
    }

    public function textsAction(Request $request, $username) {
        $em = $this->getDoctrine()->getManager();
        if($username == 'all'){
            $query = $em->createQueryBuilder()
                ->select('t')
                ->from('MSSCoreBundle:Textmedia', 't')
                ->getQuery();

            $results = $query->getResult();
        }else{
            $results = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username));
        
        }

        return $this->render('MSSCoreBundle:Category:texts.html.twig', array('texts' => $results));
    }

    public function audiosAction(Request $request, $username) {
        $em = $this->getDoctrine()->getManager();
        if($username == 'all'){
            $query = $em->createQueryBuilder()
                ->select('a')
                ->from('MSSCoreBundle:Audiomedia', 'a')
                ->getQuery();

            $results = $query->getResult();
        }else{
            $results = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username));
        
        }

        return $this->render('MSSCoreBundle:Category:audios.html.twig', array('audios' => $results));
    }

    public function videosAction(Request $request, $username) {
        $em = $this->getDoctrine()->getManager();
        if($username == 'all'){
            $query = $em->createQueryBuilder()
                ->select('v')
                ->from('MSSCoreBundle:Vediomedia', 'v')
                ->getQuery();

            $results = $query->getResult();
        }else{
            $results = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username));
        
        }

        return $this->render('MSSCoreBundle:Category:videos.html.twig', array('videos' => $results));
    }

    private function returnSpecificImage($mediaid, $keywords) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
                ->select('i.downloadtimes, i.updatetime, i.uploadname, i.imageid, i.title, i.uploadpath, i.description, i.viewtimes, i.keywords')
                ->from('MSSCoreBundle:Imagemedia', 'i')
                ->where('i.imageid=?1')
                ->setParameter(1, $mediaid)
                ->getQuery();

        $orX = new \Doctrine\ORM\Query\Expr\Orx();
        $parameters = array();

        for ($i = 0; $i < count($keywords); $i++) {
            $orX->add('i.keywords LIKE ?' . $i);
            $parameters[] = '%' . $keywords[$i] . '%';
        }

        $orX = (string) $orX;
        if (!empty($orX)) {
            $orX = 'WHERE ' . $orX;
        }

        $sql = sprintf('SELECT i.downloadtimes, i.updatetime, i.uploadname, i.imageid, i.uploadpath, i.keywords FROM MSSCoreBundle:Imagemedia i %s ORDER BY i.updatetime DESC', $orX);
        $simquery = $em->createQuery($sql)->setParameters($parameters);

        return array($query, $simquery);
    }

    private function returnSpecificAudio($mediaid, $keywords) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
                ->select('a.downloadtimes, a.updatetime, a.uploadname, a.audioid, a.title, a.uploadpath, a.uploadprefix, a.description, a.viewtimes, a.keywords')
                ->from('MSSCoreBundle:Audiomedia', 'a')
                ->where('a.audioid=?1')
                ->setParameter(1, $mediaid)
                ->getQuery();

        $orX = new \Doctrine\ORM\Query\Expr\Orx();
        $parameters = array();

        for ($i = 0; $i < count($keywords); $i++) {
            $orX->add('a.keywords LIKE ?' . $i);
            $parameters[] = '%' . $keywords[$i] . '%';
        }

        $orX = (string) $orX;
        if (!empty($orX)) {
            $orX = 'WHERE ' . $orX;
        }

        $sql = sprintf('SELECT a.downloadtimes, a.updatetime, a.uploadname, a.audioid, a.title, a.uploadpath, a.keywords FROM MSSCoreBundle:Audiomedia a %s ORDER BY a.updatetime DESC', $orX);
        $simquery = $em->createQuery($sql)->setParameters($parameters);

        return array($query, $simquery);
    }

    private function returnSpecificText($mediaid, $keywords) {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
                ->select('t.uploadname, t.downloadtimes, t.updatetime, t.textid, t.title, t.uploadpath, t.description, t.viewtimes, t.keywords')
                ->from('MSSCoreBundle:Textmedia', 't')
                ->where('t.textid=?1')
                ->setParameter(1, $mediaid)
                ->getQuery();

        $orX = new \Doctrine\ORM\Query\Expr\Orx();
        $parameters = array();

        for ($i = 0; $i < count($keywords); $i++) {
            $orX->add('t.keywords LIKE ?' . $i);
            $parameters[] = '%' . $keywords[$i] . '%';
        }

        $orX = (string) $orX;
        if (!empty($orX)) {
            $orX = 'WHERE ' . $orX;
        }

        $sql = sprintf('SELECT t.downloadtimes, t.updatetime, t.uploadname, t.textid, t.title, t.uploadpath, t.keywords FROM MSSCoreBundle:Textmedia t %s ORDER BY t.updatetime DESC', $orX);
        $simquery = $em->createQuery($sql)->setParameters($parameters);

        return array($query, $simquery);
    }

    public function returnSpecificVideo($mediaid, $keywords) {
        $em = $this->getDoctrine()->getManager();
        
        $query = $em->createQueryBuilder()
                ->select('v.downloadtimes, v.updatetime, v.uploadname, v.vedioid, v.title, v.uploadprefix, v.framepath, v.uploadpath, v.description, v.viewtimes, v.keywords')
                ->from('MSSCoreBundle:Vediomedia', 'v')
                ->where('v.vedioid=?1')
                ->setParameter(1, $mediaid)
                ->getQuery();

        $orX = new \Doctrine\ORM\Query\Expr\Orx();
        $parameters = array();

        for ($i = 0; $i < count($keywords); $i++) {
            $orX->add('v.keywords LIKE ?' . $i);
            $parameters[] = '%' . $keywords[$i] . '%';
        }

        $orX = (string) $orX;
        if (!empty($orX)) {
            $orX = 'WHERE ' . $orX;
        }

        $sql = sprintf('SELECT v.downloadtimes, v.updatetime, v.uploadname, v.vedioid, v.framepath, v.uploadpath, v.keywords FROM MSSCoreBundle:Vediomedia v %s ORDER BY v.updatetime DESC', $orX);
        $simquery = $em->createQuery($sql)->setParameters($parameters);

        return array($query, $simquery);
    }

    private function updateImageViews($viewtimes, $mediaid) {
        $em = $this->getDoctrine()->getManager();

        $updatepl = $em->createQueryBuilder()
                ->update('MSSCoreBundle:Imagemedia', 'i')
                ->set('i.viewtimes', '?1')
                ->where('i.imageid = ?2')
                ->setParameter(1, $viewtimes)
                ->setParameter(2, $mediaid)
                ->getQuery()
                ->execute();

        return $updatepl;
    }

    private function updateAudioViews($viewtimes, $mediaid) {
        $em = $this->getDoctrine()->getManager();

        $updatepl = $em->createQueryBuilder()
                ->update('MSSCoreBundle:Audiomedia', 'a')
                ->set('a.viewtimes', '?1')
                ->where('a.audioid = ?2')
                ->setParameter(1, $viewtimes)
                ->setParameter(2, $mediaid)
                ->getQuery()
                ->execute();

        return $updatepl;
    }

    private function updateTextView($viewtimes, $mediaid) {
        $em = $this->getDoctrine()->getManager();

        $updatepl = $em->createQueryBuilder()
                ->update('MSSCoreBundle:Textmedia', 't')
                ->set('t.viewtimes', '?1')
                ->where('t.textid = ?2')
                ->setParameter(1, $viewtimes)
                ->setParameter(2, $mediaid)
                ->getQuery()
                ->execute();

        return $updatepl;
    }

    private function updateVideoView($viewtimes, $mediaid) {
        $em = $this->getDoctrine()->getManager();

        $updatepl = $em->createQueryBuilder()
                ->update('MSSCoreBundle:Vediomedia', 'v')
                ->set('v.viewtimes', '?1')
                ->where('v.vedioid = ?2')
                ->setParameter(1, $viewtimes)
                ->setParameter(2, $mediaid)
                ->getQuery()
                ->execute();

        return $updatepl;
    }

    private function returnPlaylistByUser($request, $name, $type, $result, $similars, $comments) {
        $em = $this->getDoctrine()->getManager();
        //get all available playlist
        $session = $request->getSession();
        $uname = $session->get('uname');
        
        if ($uname) {
            $playlist = $em->createQueryBuilder()
                            ->select('p.plid, p.title')
                            ->from('MSSCoreBundle:Playlist', 'p')
                            ->where('p.creator=?1')
                            ->setParameter(1, $uname)
                            ->getQuery()->getResult();
            return array('name' => $name, 'type' => $type, 'media' => $result, 'similars' => $similars, 'playlist' => $playlist, 'comments' => $comments);
        } else {
            return null;
        }
    }

    private function setUserRelatedComments($request, $type, $mediaid) {
        $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:Comments');
        $comments = $repos->findBy(array('mediatype' => $type, 'mediaid' => $mediaid, 'parent' => NULL));

       /* $stmt = $this->getDoctrine()->getManager()
                ->getConnection()
                ->prepare('SELECT * , u.photopath FROM comments c JOIN user u ON c.commenter = u.username');
        $stmt->execute();
        $allreplies = $stmt->fetchAll();

        if ($allreplies) {
            $session = $request->getSession();
            if ($session->has('availablereplies')) {
                $session->remove('availablereplies');
            }
            $session->set('availablereplies', $allreplies);
        }*/
        
        return $comments;
    }
    
    private function updateHistory(Request $request,$type, $mediaid, $keywords){
        $session = $request->getSession();
        $uname = $session->get('uname');
        
        $history = new History();
        if($uname){
            $history->setUsername($uname);
        } else {
            $history->setUsername("anonym");
        }
        $history->setMediaid($mediaid);
        $history->setMediatype($type);
        $history->setKeywords($keywords);
        $history->setBrowsetime(new \DateTime());
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($history);
        $em->flush();
        
    }

    public function specificAction(Request $request, $type, $mediaid, $keywords) {
        $this->updateHistory($request, $type, $mediaid, $keywords);
        $em = $this->getDoctrine()->getManager();

        if ($type == 1) { // image
            $arr = $this->returnSpecificImage($mediaid, $keywords);
        } else if ($type == 2) { //audio
            $arr = $this->returnSpecificAudio($mediaid, $keywords);
        } else if ($type == 3) { //text
            $arr = $this->returnSpecificText($mediaid, $keywords);
        } else if ($type == 4) { //video
            $arr = $this->returnSpecificVideo($mediaid, $keywords);
        }

        $result = $arr[0]->getResult();
	$name = substr($result[0]["uploadpath"], strrpos($result[0]["uploadpath"], '/') + 1);
        $similars = $arr[1]->getResult();

        //update reviewtimes
        $viewtimes = 0;
        if ($result[0]["viewtimes"]) {
            $viewtimes = $result[0]["viewtimes"] + 1;
        } else {
            $viewtimes++;
        }

        if ($type == 1) {
            $updatepl = $this->updateImageViews($viewtimes, $mediaid);
        } else if ($type == 2) {
            $updatepl = $this->updateAudioViews($viewtimes, $mediaid);
        } else if ($type == 3) {
            $updatepl = $this->updateTextView($viewtimes, $mediaid);
        } else if ($type == 4) {
            $updatepl = $this->updateVideoView($viewtimes, $mediaid);
        }

        //get related comments
        $comments = $this->setUserRelatedComments($request, $type, $mediaid);

        $playlist = $this->returnPlaylistByUser($request, $name, $type, $result, $similars, $comments);
        if ($playlist != null) {
            return $this->render('MSSCoreBundle:Category:specific.html.twig', $playlist);
        }

        return $this->render('MSSCoreBundle:Category:specific.html.twig', array('name' => $name, 'type' => $type, 'media' => $result, 'similars' => $similars));
    }

}
