<?php

namespace MSS\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;

use MSS\CoreBundle\Controller\Utils\Document;
use MSS\CoreBundle\Entity\Imagemedia;
use \MSS\CoreBundle\Entity\Textmedia;
use \MSS\CoreBundle\Entity\Audiomedia;
use \MSS\CoreBundle\Entity\Vediomedia;
use MSS\CoreBundle\Entity\Downloadaudio;
use MSS\CoreBundle\Entity\Downloadvedio;
use MSS\CoreBundle\Entity\Downloadimage;
use MSS\CoreBundle\Entity\Downloadtext;

use Symfony\Component\Process\Process;

/**
 * Description of MediaBundle
 *
 * @author yanbai
 */
class MediaController extends Controller {

    public function uploadSelAction(Request $request) {
        if ($request->getMethod() == 'POST') {
            if ($request->get("textBtn")) {
                return $this->render('MSSCoreBundle:Media:uploadText.html.twig');
            } else if ($request->get('imageBtn')) {
                return $this->render('MSSCoreBundle:Media:uploadImage.html.twig');
            } else if ($request->get('audioBtn')) {
                return $this->render('MSSCoreBundle:Media:uploadAudio.html.twig');
            } else if ($request->get('videoBtn')) {
                return $this->render('MSSCoreBundle:Media:uploadVideo.html.twig');
            }
        } else {
            return $this->render('MSSCoreBundle:Media:uploadSel.html.twig');
        }
    }

    private function returnValidFileType($fileType) {
        $valid_filetypes = array();

        if ($fileType == "image")
            $valid_filetypes = array('jpg', 'jpeg', 'bmp', 'png');
        elseif ($fileType == "text")
            $valid_filetypes = array('pdf', 'doc', 'docx', 'xml');
        elseif ($fileType == "audio")
            $valid_filetypes = array('mp3');
        elseif ($fileType == "video")
            $valid_filetypes = array('mp4', 'flv', 'mov', 'wmv', 'swf');

        return $valid_filetypes;
    }

    private function returnMediaObject($fileType) {
        $media = null;

        if ($fileType == "image")
            $media = new Imagemedia();
        elseif ($fileType == "text")
            $media = new Textmedia();
        elseif ($fileType == "audio")
            $media = new Audiomedia();
        elseif ($fileType == "video")
            $media = new Vediomedia();

        return $media;
    }

    private function returnUploadFilePath($appRoot, $uploadMedia, $fileType) {
        $document = new Document();

        $document->setFile($uploadMedia);
        $document->setUploadDirectory($appRoot . "/../web/uploads");

        if ($fileType == "image")
            $document->setSubDirectory('images');
        elseif ($fileType == "text")
            $document->setSubDirectory('texts');
        elseif ($fileType == "audio")
            $document->setSubDirectory('audios');
        elseif ($fileType == "video")
            $document->setSubDirectory('videos');

        $document->processFile();

        //$uploadedURL = $document->getUploadDirectory() . DIRECTORY_SEPARATOR . $document->getSubDirectory() . DIRECTORY_SEPARATOR . $uploadMedia->getBasename();

        $this->videoFormat($document->getUploadDirectory(), $document->getFilePersistencePath());
        
        return $document->getFilePersistencePath();
    }
    
    private function videoFormat($uploaddir, $subdir) {
        $sepname = explode("/", $subdir);
        $originalName = $sepname[1];
        $name_array = explode('.', $originalName);
        $file_type = $name_array[sizeof($name_array) - 1];
        
        $input = $uploaddir . DIRECTORY_SEPARATOR . $sepname[0] . DIRECTORY_SEPARATOR . $originalName;
        
        if($file_type != "mp4") {
            $output = $uploaddir . DIRECTORY_SEPARATOR . $sepname[0] . DIRECTORY_SEPARATOR . $name_array[0] . ".mp4";
            $command = "/home/parallels/bin/ffmpeg -i ". $input . " " . $output;
            $process = new Process($command);
            $process->start(function ($type, $buffer) {
                if ('err' === $type) {
                    //print_r('ERR > '.$buffer);
                } else {
                    //print_r('OUT > '.$buffer);
                }
            });
        }
        
        if($file_type != "webm") {
            $output = $uploaddir . DIRECTORY_SEPARATOR . $sepname[0] . DIRECTORY_SEPARATOR . $name_array[0] . ".webm";
            $command = "/home/parallels/bin/ffmpeg -i ". $input . " " . $output;
            $process = new Process($command);
            $process->start(function ($type, $buffer) {
                if ('err' === $type) {
                    //print_r('ERR > '.$buffer);
                } else {
                    //print_r('OUT > '.$buffer);
                }
            });
        }
    }
    
    private function returnUploadFile($request, $fileType){
        $uploadMedia = null;
        
        if ($fileType == "image")
            $uploadMedia = $request->files->get('img');
        elseif ($fileType == "text")
            $uploadMedia = $request->files->get('article');
        elseif ($fileType == "audio")
            $uploadMedia = $request->files->get('audioFile');
        elseif ($fileType == "video")
            $uploadMedia = $request->files->get('videoFile');
        
        return $uploadMedia;
    }
    
    private function generateFrameImage($appRoot, $relativePath){
        $input = $appRoot . "/../web/uploads/" . $relativePath;
        $output = $appRoot . "/../web/uploads/" . $relativePath . ".png";
        //$command = "ffmpeg -i ". $input . " -ss 00:00:14.435 -f image2 -vframes 1 ". $output . " >/dev/null 2>/dev/null &";
        $command = "/home/parallels/bin/ffmpeg -i ". $input . " -ss 00:00:14.435 -f image2 -vframes 1 ". $output;
        $process = new Process($command);
        $process->run(function ($type, $buffer) {
            if ('err' === $type) {
                //print_r('ERR > '.$buffer);
            } else {
                //print_r('OUT > '.$buffer);
            }
        });
    }

    private function saveFile(Request $request, $appRoot, $usr, $fileType) {

        $title = $request->get("title");
        $description = $request->get("description");
       
        $keyword1 = $request->get("keyword1");
        $keyword2 = $request->get("keyword2");
        $keyword3 = $request->get("keyword3");
        $keywords = $keyword1 . "," . $keyword2 . "," . $keyword3;

        $media = $this->returnMediaObject($fileType);
        $media->setUploadname($usr);
        $media->setTitle($title);
        $media->setDescription($description);
        $media->setUpdatetime(new \DateTime());
        $media->setKeywords($keywords);
        $security = $request->get("security");
        if($security == 'public'){
            $media->setSecurity(0);
        }else{
            $media->setSecurity(1);
        }
        
        $status = 'success';
        $uploadedURL = '';
        $message = '';
        $uploadMedia = $this->returnUploadFile($request, $fileType);

        if (($uploadMedia instanceof UploadedFile) && ($uploadMedia->getError() == '0')) {
            if (($uploadMedia->getSize() < 2000000000)) {
                $originalName = $uploadMedia->getClientOriginalName();
                $originalName = str_replace(" ", "", $originalName);
                $name_array = explode('.', $originalName);
                $file_type = $name_array[sizeof($name_array) - 1];
                $valid_filetypes = $this->returnValidFileType($fileType);
                
                if (in_array(strtolower($file_type), $valid_filetypes)) {
                    $relativePath = $this->returnUploadFilePath($appRoot, $uploadMedia, $fileType);
                    $media->setUploadpath($relativePath);
                    if($fileType == "video") {
                        $this->generateFrameImage($appRoot, $relativePath);
                        $media->setFramepath($relativePath . ".png");
                        $media->setUploadprefix(str_replace("." . $file_type, "", $relativePath));
                    }
                    if($fileType == "audio") {
                        $this->generateFrameImage($appRoot, $relativePath);
                        $media->setUploadprefix(str_replace("." . $file_type, "", $relativePath));
                    }
                    
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($media);
                    $em->flush();
                } else {
                    $status = 'failed';
                    $message = 'Invalid File Type';
                }
            } else {
                $status = 'failed';
                $message = 'Size exceeds limit';
            }
        } else {
            $status = 'failed';
            $message = 'File Error';
        }

        return array('status' => $status, 'message' => $message, 'uploadedURL' => $uploadedURL);
    }

    public function uploadImageAction(Request $request) {
        $appRoot = $this->get('kernel')->getRootDir();
        $usr = $this->getRequest()->getSession()->get('uname');

        $param = "";
        if ($request->getMethod() == 'POST') {
            $param = $this->saveFile($request, $appRoot, $usr, "image");
        }

        if ($param['status'] == "success") {
            return $this->redirect($this->generateUrl('mss_core_user_channels', array('username' => $usr, 'type' => 'image')));
            
        } else {
            return $this->render('MSSCoreBundle:Media:uploadImage.html.twig');
        }
    }

    public function uploadTextAction(Request $request) {
        $appRoot = $this->get('kernel')->getRootDir();
        $usr = $this->getRequest()->getSession()->get('uname');

        $param = "";
        if ($request->getMethod() == 'POST') {
            $param = $this->saveFile($request, $appRoot, $usr, "text");
        }

        if ($param['status'] == "success") {
            return $this->redirect($this->generateUrl('mss_core_user_channels', array('username' => $usr, 'type' => 'text')));
        } else {
            return $this->render('MSSCoreBundle:Media:uploadText.html.twig', array('param' => $param));
        }
    }
        

    public function uploadAudioAction(Request $request) {
        $appRoot = $this->get('kernel')->getRootDir();
        $usr = $this->getRequest()->getSession()->get('uname');

        $param = "";
        if ($request->getMethod() == 'POST') {
            $param = $this->saveFile($request, $appRoot, $usr, "audio");
        }

        if ($param['status'] == "success") {
            return $this->redirect($this->generateUrl('mss_core_user_channels', array('username' => $usr, 'type' => 'audio')));
            
        } else {
            return $this->render('MSSCoreBundle:Media:uploadAudio.html.twig', array('param' => $param));
        }
    }

    public function uploadVideoAction(Request $request) {
        $appRoot = $this->get('kernel')->getRootDir();
        $usr = $this->getRequest()->getSession()->get('uname');

        $param = "";
        if ($request->getMethod() == 'POST') {
            $param = $this->saveFile($request, $appRoot, $usr, "video");
        }

        if ($param['status'] == "success") {
           return $this->redirect($this->generateUrl('mss_core_user_channels', array('username' => $usr, 'type' => 'video'))); 
        } else {
            return $this->render('MSSCoreBundle:Media:uploadVideo.html.twig');
        }
    }
    
    public function downloadAction(Request $request, $uploadname, $dir, $name){
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        if($dir == 'texts'){
            $media = $em->getRepository('MSSCoreBundle:Textmedia')->findOneBy(array('uploadname' => $uploadname, 'uploadpath' => $dir.'/'.$name));
            $download = new Downloadtext();
            $download->setDownloadtextid($media->getTextid());
        }else if($dir == 'images'){
            $media = $em->getRepository('MSSCoreBundle:Imagemedia')->findOneBy(array('uploadname' => $uploadname, 'uploadpath' => $dir.'/'.$name));
            if(!$media){
                $media = $em->getRepository('MSSCoreBundle:Imagemedia')->findOneBy(array('uploadname' => $uploadname, 'uploadpath' => 'profiles/'.$name));
            
            }
            $download = new Downloadimage();
            $download->setDownloadimageid($media->getImageid());
        }else if($dir == 'audios'){
            $media = $em->getRepository('MSSCoreBundle:Audiomedia')->findOneBy(array('uploadname' => $uploadname, 'uploadpath' => $dir.'/'.$name));
            $download = new Downloadaudio();
            $download->setDownloadaudioid($media->getAudioid());
        }else if($dir == 'videos'){
            $media = $em->getRepository('MSSCoreBundle:Vediomedia')->findOneBy(array('uploadname' => $uploadname, 'uploadpath' => $dir.'/'.$name));
            $download = new Downloadvedio();
            $download->setDownloadvedioid($media->getVedioid());
        }
        $path = $this->get('kernel')->getRootDir(). "/../web/uploads/" . $media->getUploadpath();
        $content = file_get_contents($path);

        $response = new Response();

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$name);

        $response->setContent($content);
        
        $media->setDownloadtimes($media->getDownloadtimes() + 1);
        
        $download->setDownloadname($session->get('uname'));
        $download->setDownloadtime(new \DateTime());
        $em->persist($download);
        $em->flush();
        return $response;
    }

}
