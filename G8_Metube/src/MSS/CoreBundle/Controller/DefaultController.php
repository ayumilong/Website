<?php

namespace MSS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    private function getUnreadMessages($username) {
        $messages = '';
        if ($username) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQueryBuilder()
                    ->select('m')
                    ->from('MSSCoreBundle:Message', 'm')
                    ->where('m.receivor=?1')
                    ->andWhere('m.isread=?2')
                    ->orderBy('m.sendtime', 'DESC')
                    ->setParameter(1, $username)
                    ->setParameter(2, 0)
                    ->getQuery();

            $messages = $query->getResult();
        }

        return $messages;
    }

    private function mostViewImages() {
        $em = $this->getDoctrine()->getManager();
        $iquery = $em->createQueryBuilder()
                ->select('i.imageid, i.title, i.uploadpath, i.keywords')
                ->from('MSSCoreBundle:Imagemedia', 'i')
                ->orderBy('i.viewtimes', 'DESC')
                ->setMaxResults(16)
                ->getQuery();

        $iresults = $iquery->getResult();

        return $iresults;
    }

    private function mostViewTexts() {
        $em = $this->getDoctrine()->getManager();
        $tquery = $em->createQueryBuilder()
                ->select('t.textid, t.uploadpath,t.title, t.description, t.keywords')
                ->from('MSSCoreBundle:Textmedia', 't')
                ->orderBy('t.viewtimes', 'DESC')
                ->setMaxResults(10)
                ->getQuery();

        $tresults = $tquery->getResult();

        return $tresults;
    }

    private function mostViewAudios() {
        $em = $this->getDoctrine()->getManager();
        $aquery = $em->createQueryBuilder()
                ->select('a.audioid, a.uploadname, a.updatetime, a.uploadpath, a.title, a.description, a.keywords')
                ->from('MSSCoreBundle:Audiomedia', 'a')
                ->orderBy('a.viewtimes', 'DESC')
                ->setMaxResults(10)
                ->getQuery();

        $aresults = $aquery->getResult();

        return $aresults;
    }

    private function mostViewVideos() {
        $em = $this->getDoctrine()->getManager();
        $vquery = $em->createQueryBuilder()
                ->select('v.vedioid, v.title, v.uploadpath, v.keywords, v.framepath')
                ->from('MSSCoreBundle:Vediomedia', 'v')
                ->orderBy('v.viewtimes', 'DESC')
                ->setMaxResults(13)
                ->getQuery();

        $vresults = $vquery->getResult();

        return $vresults;
    }

    private function recentlyUploadImages() {
        $em = $this->getDoctrine()->getManager();
        $riquery = $em->createQueryBuilder()
                ->select('i.imageid, i.title, i.uploadpath, i.keywords')
                ->from('MSSCoreBundle:Imagemedia', 'i')
                ->orderBy('i.updatetime', 'DESC')
                ->setMaxResults(10)
                ->getQuery();

        $rresults = $riquery->getResult();

        return $rresults;
    }

    private function recentlyUploadTexts() {
        $em = $this->getDoctrine()->getManager();
        $rtquery = $em->createQueryBuilder()
                ->select('t.textid, t.uploadpath,t.title, t.description, t.keywords')
                ->from('MSSCoreBundle:Textmedia', 't')
                ->orderBy('t.updatetime', 'DESC')
                ->setMaxResults(10)
                ->getQuery();

        $rtresults = $rtquery->getResult();

        return $rtresults;
    }

    private function recentlyUploadAudios() {
        $em = $this->getDoctrine()->getManager();
        $raquery = $em->createQueryBuilder()
                ->select('a')
                ->from('MSSCoreBundle:Audiomedia', 'a')
                ->orderBy('a.updatetime', 'DESC')
                ->setMaxResults(10)
                ->getQuery();

        $raresults = $raquery->getResult();

        return $raresults;
    }

    private function recentlyUploadVideos() {
        $em = $this->getDoctrine()->getManager();
        $rvquery = $em->createQueryBuilder()
                ->select('v.vedioid, v.title, v.uploadpath, v.keywords, v.framepath')
                ->from('MSSCoreBundle:Vediomedia', 'v')
                ->orderBy('v.updatetime', 'DESC')
                ->setMaxResults(10)
                ->getQuery();

        $rvresults = $rvquery->getResult();

        return $rvresults;
    }

    private function getWordcloud() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQueryBuilder()
                ->select('h.keywords')
                ->from('MSSCoreBundle:History', 'h')
                ->orderBy('h.browsetime', 'DESC')
                ->setMaxResults(30)
                ->getQuery();

        $wordcloud = $query->getResult();
        $word = array();
        for ($i = 0; $i < count($wordcloud); $i++) {
            $tmp = explode(",", $wordcloud[$i]["keywords"]);
            for ($j = 0; $j < count($tmp); $j++) {
                if (!empty($tmp[$j])) {
                    if (!in_array($tmp[$j], $word)) {
                        array_push($word, $tmp[$j]);
                    }
                }
            }
        }

        return $word;
    }

    private function generateKeys($keywords) {
        $orX = new \Doctrine\ORM\Query\Expr\Orx();
        $parameters = array();

        for ($i = 0; $i < count($keywords); $i++) {
            if ($keywords[$i] != "") {
                $orX->add('a.keywords LIKE ?' . $i);
                $parameters[] = '%' . $keywords[$i] . '%';
            }
        }

        $orX = (string) $orX;
        if (!empty($orX)) {
            $orX = 'WHERE ' . $orX;
        }

        return array($orX, $parameters);
    }

    private function getImages($keywords) {
        $em = $this->getDoctrine()->getManager();
        $params = $this->generateKeys($keywords);
        $sql = sprintf('SELECT a.imageid, a.title, a.uploadpath, a.keywords, a.updatetime FROM MSSCoreBundle:Imagemedia a %s ORDER BY a.updatetime DESC', $params[0]);
        $images = $em->createQuery($sql)->setParameters($params[1])->getResult();

        return $images;
    }

    private function getVideos($keywords) {
        $em = $this->getDoctrine()->getManager();
        $params = $this->generateKeys($keywords);
        $sql = sprintf('SELECT a.vedioid, a.title, a.uploadpath, a.framepath, a.keywords, a.updatetime FROM MSSCoreBundle:Vediomedia a %s ORDER BY a.updatetime DESC', $params[0]);
        $videos = $em->createQuery($sql)->setParameters($params[1])->getResult();

        return $videos;
    }

    private function getRecommandation($keywords) {
        $keys = array();
        for ($i = 0; $i < count($keywords); $i++) {
            $tmp = explode(",", $keywords[$i]['keywords']);
            for ($j = 0; $j < count($tmp); $j++) {
                if ($tmp[$j] != "") {
                    if (!in_array($tmp[$j], $keys)) {
                        array_push($keys, $tmp[$j]);
                    }
                }
            }
        }
        
        $images = $this->getImages($keys);
        $videos = $this->getVideos($keys);

        return array($images, $videos);
    }

    private function getHistory($username) {
        $keywords = '';
        if ($username) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQueryBuilder()
                    ->select('h.keywords')
                    ->from('MSSCoreBundle:History', 'h')
                    ->where('h.username=?1')
                    ->orderBy('h.browsetime', 'DESC')
                    ->setParameter(1, $username)
                    ->setMaxResults(5)
                    ->getQuery();

            $keywords = $query->getResult();
        }
        
        $history = $this->getRecommandation($keywords);
        return $history;
    }

    public function indexAction(Request $request) {
        $session = $request->getSession();
        $username = $session->get('uname');

        $messages = $this->getUnreadMessages($username);
        if($username){
            $history = $this->getHistory($username);
        }

        $iresults = $this->recentlyUploadImages();
        $tresults = $this->recentlyUploadTexts();
        $aresults = $this->recentlyUploadAudios();
        $vresults = $this->recentlyUploadVideos();

        $wordcloud = $this->getWordcloud();

        $session->set('texts', $tresults);
        $session->set('images', $iresults);
        $session->set('audios', $aresults);
        $session->set('videos', $vresults);
        $session->set('wordcloud', $wordcloud);
        if($username){
            $session->set('remd_images', $history[0]);
            $session->set('remd_videos', $history[1]);
        }

        if ($messages != '') {
            return $this->render('MSSCoreBundle:Home:index.html.twig', array('messagesno' => count($messages)));
        } else {
            return $this->render('MSSCoreBundle:Home:index.html.twig');
        }
    }

    public function index2Action(Request $request) {
        $session = $request->getSession();
        $username = $session->get('uname');

        $messages = $this->getUnreadMessages($username);
        if($username){
            $history = $this->getHistory($username);
        }

        $iresults = $this->mostViewImages();
        $tresults = $this->mostViewTexts();
        $aresults = $this->mostViewAudios();
        $vresults = $this->mostViewVideos();

        $wordcloud = $this->getWordcloud();

        $session->set('texts', $tresults);
        $session->set('images', $iresults);
        $session->set('audios', $aresults);
        $session->set('videos', $vresults);
        $session->set('wordcloud', $wordcloud);
        if($username){
            $session->set('remd_images', $history[0]);
            $session->set('remd_videos', $history[1]);
        }

        if ($messages != '') {
            return $this->render('MSSCoreBundle:Home:index.html.twig', array('messagesno' => count($messages)));
        } else {
            return $this->render('MSSCoreBundle:Home:index.html.twig');
        }
    }

}