<?php

namespace MSS\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of SearchController
 *
 * @author yanbai
 */
class SearchController extends Controller {

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

    private function getAudios($keywords) {
        $em = $this->getDoctrine()->getManager();
        $params = $this->generateKeys($keywords);
        $sql = sprintf('SELECT a.audioid, a.title, a.keywords, a.updatetime FROM MSSCoreBundle:Audiomedia a %s ORDER BY a.updatetime DESC', $params[0]);
        $audios = $em->createQuery($sql)->setParameters($params[1])->getResult();

        return $audios;
    }

    private function getImages($keywords) {
        $em = $this->getDoctrine()->getManager();
        $params = $this->generateKeys($keywords);
        $sql = sprintf('SELECT a.imageid, a.title, a.keywords, a.updatetime FROM MSSCoreBundle:Imagemedia a %s ORDER BY a.updatetime DESC', $params[0]);
        $images = $em->createQuery($sql)->setParameters($params[1])->getResult();

        return $images;
    }

    private function getTexts($keywords) {
        $em = $this->getDoctrine()->getManager();
        $params = $this->generateKeys($keywords);
        $sql = sprintf('SELECT a.textid, a.title, a.keywords, a.updatetime FROM MSSCoreBundle:Textmedia a %s ORDER BY a.updatetime DESC', $params[0]);
        $texts = $em->createQuery($sql)->setParameters($params[1])->getResult();

        return $texts;
    }

    private function getVideos($keywords) {
        $em = $this->getDoctrine()->getManager();
        $params = $this->generateKeys($keywords);
        $sql = sprintf('SELECT a.vedioid, a.title, a.keywords, a.updatetime FROM MSSCoreBundle:Vediomedia a %s ORDER BY a.updatetime DESC', $params[0]);
        $videos = $em->createQuery($sql)->setParameters($params[1])->getResult();

        return $videos;
    }

    public function keySearchAction(Request $request, $key) {
        $searchBar = $request->get('searchBar');
        $keywords = explode(" ", $searchBar);

        $audios = $this->getAudios($keywords);
        $texts = $this->getTexts($keywords);
        $videos = $this->getVideos($keywords);
        $images = $this->GetImages($keywords);

        return $this->render("MSSCoreBundle:Search:searchList.html.twig", array('audios' => $audios, 'texts' => $texts, 'images' => $images, 'videos' => $videos));
    }
    
    public function cloudkeySearchAction(Request $request, $key) {
        $keywords = array();
        array_push($keywords, $key);
        $audios = $this->getAudios($keywords);
        $texts = $this->getTexts($keywords);
        $videos = $this->getVideos($keywords);
        $images = $this->GetImages($keywords);

        return $this->render("MSSCoreBundle:Search:searchList.html.twig", array('audios' => $audios, 'texts' => $texts, 'images' => $images, 'videos' => $videos));
    }
    
    public function featureSearchAction(Request $request) {
        if($request->getMethod() == 'POST') {
            
        }
        
        return $this->render("MSSCoreBundle:Search:fsearchList.html.twig");
    }

}
