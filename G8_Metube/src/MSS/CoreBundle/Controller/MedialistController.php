<?php

namespace MSS\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MSS\CoreBundle\Entity\Playlist;

/**
 * Description of Medialist
 *
 * @author yanbai
 */
class MedialistController extends Controller {

    public function playAction(Request $request) {
        $session = $request->getSession();
        $uname = $session->get('uname');

        if (!$uname) {
            return $this->render('MSSCoreBundle:User:login.html.twig');
        } else {
            $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:Playlist');
            $result = $repos->findBy(array('creator' => $uname));

            return $this->render('MSSCoreBundle:List:playlist.html.twig', array('playlists' => $result));
        }
    }

    public function createAction(Request $request) {
        if ($request->getMethod() == 'POST') {
            $session = $request->getSession();
            $uname = $session->get('uname');
            $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:User');
            $user = $repos->findOneBy(array('username' => $uname));

            $title = $request->get('title');
            $isfavorate = $request->Get('isfavorate');

            $playlist = new Playlist();
            $playlist->setTitle($title);
            $playlist->setIsfavorate($isfavorate);
            $playlist->setCreator($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($playlist);
            $em->flush();
        }

        return $this->render('MSSCoreBundle:List:createPlaylist.html.twig');
    }

    public function returnVideoPlaylist($mediaids) {
        $em = $this->getDoctrine()->getManager();
        $result = array();

        for ($i = 0; $i < count($mediaids); $i++) {
            if ($mediaids[$i] != "") {
                $query = $em->createQueryBuilder()
                        ->select('v.vedioid, v.title, v.uploadprefix, v.framepath, v.uploadpath, v.description, v.viewtimes, v.keywords')
                        ->from('MSSCoreBundle:Vediomedia', 'v')
                        ->where('v.vedioid=?1')
                        ->setParameter(1, $mediaids[$i])
                        ->getQuery()
                        ->getResult();
                array_push($result, $query[0]);
            }
        }

        return $result;
    }

    private function returnAudioPlaylist($mediaids) {
        $em = $this->getDoctrine()->getManager();
        $result = array();

        for ($i = 0; $i < count($mediaids); $i++) {
            if ($mediaids[$i] != "") {
                $query = $em->createQueryBuilder()
                        ->select('a.audioid, a.title, a.coverpath, a.uploadpath, a.uploadprefix, a.description, a.viewtimes, a.keywords')
                        ->from('MSSCoreBundle:Audiomedia', 'a')
                        ->where('a.audioid=?1')
                        ->setParameter(1, intval($mediaids[$i]))
                        ->getQuery()
                        ->getResult();
                //print_r($query);
                array_push($result, $query[0]);
            }
        }

        return $result;
    }

    public function returnVideoids($plid) {
        $em = $this->getDoctrine()->getManager();
        $ret = $em->createQueryBuilder()
                ->select('p.vediocontent')
                ->from('MSSCoreBundle:Playlist', 'p')
                ->where('p.plid = ?1')
                ->setParameter(1, $plid)
                ->getQuery()
                ->getResult();

        return $ret[0];
    }

    public function returnAudioids($plid) {
        $em = $this->getDoctrine()->getManager();
        $ret = $em->createQueryBuilder()
                ->select('p.audiocontent')
                ->from('MSSCoreBundle:Playlist', 'p')
                ->where('p.plid = ?1')
                ->setParameter(1, $plid)
                ->getQuery()
                ->getResult();

        return $ret[0];
    }

    public function detailsAction(Request $request, $plid) {

        $vids = $this->returnVideoids($plid);
        $aids = $this->returnAudioids($plid);

        if ($aids["audiocontent"] != "") {
            $audioids = explode(',', $aids["audiocontent"]);
            $audios = $this->returnAudioPlaylist($audioids);
        } else {
            $audios = array();
        }

        if ($vids["vediocontent"] != "") {
            $videoids = explode(',', $vids["vediocontent"]);
            $videos = $this->returnVideoPlaylist($videoids);
        } else {
            $videos = array();
        }

        $result = array();
        if (count($audios) > 0) {
            for ($i = 0; $i < count($audios); $i++) {
                array_push($result, $audios[$i]);
            }
        }

        if (count($videos) > 0) {
            for ($i = 0; $i < count($videos); $i++) {
                array_push($result, $videos[$i]);
            }
        }

        //print_r($result);
        return $this->render('MSSCoreBundle:List:details.html.twig', array("playlist" => $result));
    }

    public function addToPlayAction(Request $request, $type, $mediaid, $keywords, $plid) {
        $em = $this->getDoctrine()->getManager();
        $query;
        if ($type == 2) {
            $query = $em->createQueryBuilder()
                    ->select('p.audiocontent')
                    ->from('MSSCoreBundle:Playlist', 'p')
                    ->where('p.plid = ?1')
                    ->setParameter(1, $plid)
                    ->getQuery();
            
            $content = $query->getResult();
            
            if ($content[0]["audiocontent"] == "") {
                $content = array($mediaid);
            } else {
                if (in_array($mediaid, explode(',', $content[0]["audiocontent"]))) {
                    $content = $content[0]["audiocontent"];
                } else {
                    $content = $content[0]["audiocontent"] . "," . $mediaid;
                }
            }
            
            $updatepl = $em->createQueryBuilder()
                        ->update('MSSCoreBundle:Playlist', 'p')
                        ->set('p.audiocontent', '?1')
                        ->where('p.plid = ?2')
                        ->setParameter(1, $content)
                        ->setParameter(2, $plid)
                        ->getQuery()
                        ->execute();
            
        } elseif ($type == 4) {
            $query = $em->createQueryBuilder()
                    ->select('p.vediocontent')
                    ->from('MSSCoreBundle:Playlist', 'p')
                    ->where('p.plid = ?1')
                    ->setParameter(1, $plid)
                    ->getQuery();
            
            $content = $query->getResult();
            
            if ($content[0]["vediocontent"] == "") {
                $content = array($mediaid);
            } else {
                if (in_array($mediaid, explode(',', $content[0]["vediocontent"]))) {
                    $content = $content[0]["vediocontent"];
                } else {
                    $content = $content[0]["vediocontent"] . "," . $mediaid;
                }
            }
            
            $updatepl = $em->createQueryBuilder()
                    ->update('MSSCoreBundle:Playlist', 'p')
                    ->set('p.vediocontent', '?1')
                    ->where('p.plid = ?2')
                    ->setParameter(1, $content)
                    ->setParameter(2, $plid)
                    ->getQuery()
                    ->execute();
        }

        return $this->redirect($this->generateUrl('mss_core_cate_specific', array('type' => $type, 'mediaid' => $mediaid, 'keywords' => $keywords)));
    }

    public function favoriteAction(Request $request) {
        
    }

    private function add_to_array($array, $key, $value) {
        if (array_key_exists($key, $array)) {
            if (is_array($array[$key])) {
                $array[$key][] = $value;
            } else {
                $array[$key] = array($array[$key], $value);
            }
        } else {
            $array[$key] = array($value);
        }
        return $array;
    }

}
