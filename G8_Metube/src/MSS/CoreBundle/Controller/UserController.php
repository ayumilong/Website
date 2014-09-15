<?php

namespace MSS\CoreBundle\Controller;

use MSS\CoreBundle\Entity\User;
use MSS\CoreBundle\Entity\Imagemedia;
use MSS\CoreBundle\Entity\Contactlist;
use MSS\CoreBundle\Entity\Subscribechannel;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use MSS\CoreBundle\Controller\Utils\Document;
/**
 * Description of UserBundle
 *
 * @author yanbai
 */
class UserController extends Controller{

    public function loginAction(Request $request) {
        if($request->getMethod() == 'POST') {
            $session = $request->getSession();
            $repos = $this->getDoctrine()->getRepository('MSSCoreBundle:User');

            $session->clear();
            $email = $request->request->get('email');
            $pos = strrpos($email, "@");
            $username = substr($email,0,$pos);
            $password = $request->request->get('password');
            $user = $repos->findOneBy(array('username' => $username, 'passwd' => $password));
            
            
            if ($user) {
                $session->start();
                $session->set('uname', $user->getUsername());
                $user->setStatus(1);
                $this->getDoctrine()->getManager()->flush();
                $session->set('uprofile', $user->getPhotopath());
                return $this->redirect($this->generateUrl('mss_core_homepage'));
            } else {
                return $this->render('MSSCoreBundle:User:login.html.twig', array('uerror' => 'Username or password error!'));
            }
        }
        return $this->render('MSSCoreBundle:User:login.html.twig');
    }
    
    public function signupAction(Request $request) {
        if($request->getMethod() == 'POST') {
            $email = $request->request->get('email');
            $pos = strrpos($email, "@");
            $username = substr($email,0,$pos);
            $password = $request->request->get('password');
            
            $oldUser = $this->getDoctrine()->getRepository('MSSCoreBundle:User')->findOneBy(array('username' => $username));
            if($oldUser){//User exist
                return $this->render('MSSCoreBundle:User:signup.html.twig', array('uexist' => "Email exist, input again!"));
            }else{
      
                $user = new User();
                $user->setUsername($username);
                $user->setEmail($email);
                $user->setPasswd($password);
                
                $params = $this->get('router')->generate('mss_core_user_active', array('username'=> $username), true);
                $message = \Swift_Message::newInstance()->setSubject("Test email")
                    ->setFrom("ayumilong41@gmail.com")
                    ->setTo(array($email))
                    ->setBody(
                    $this->renderView("MSSCoreBundle:User:email.html.twig", array("activelink" => $params)));
                $result = $this->get("mailer")->send($message);
            
                if(!($result > 0)){
                    return $this->render('MSSCoreBundle:User:signup.html.twig', array('uexist' => "Email address is invalid!"));
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();
                $session = $request->getSession();
                $session->clear();
                $session->start();
                $session->set('uname', $username);
                return $this->render('MSSCoreBundle:User:inactive.html.twig');
            }
        }
            return $this->render('MSSCoreBundle:User:signup.html.twig');
    }
    
    public function activeAction(Request $request, $username){
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('MSSCoreBundle:User')->find($username);
        if($user){ //The user will be activated
            $user->setActive("Y");
            $user->setStatus(1);
            $em->flush();
        }
        $session->start();
        $session->set('uname', $username); //The user has login
        return $this->render('MSSCoreBundle:User:active.html.twig', array('username' => $username));
    }
    
    public function uploadAction(Request $request){
        
        $usr = $request->getSession()->get('uname');
        if($usr){
        $appRoot = $this->get('kernel')->getRootDir();
        
        if ($request->getMethod() == 'POST') {
            $title = $request->get("title");
            $description = $request->get("description");
            $keyword1 = $request->get("keyword1");
            $keyword2 = $request->get("keyword2");
            $keyword3 = $request->get("keyword3");
            $keywords = $keyword1 . "," . $keyword2 . "," . $keyword3;
            
            $em = $this->getDoctrine()->getManager();
            

            $imagemedia = new Imagemedia();
            $imagemedia->setUploadname($usr);
            $imagemedia->setTitle($title);
            $imagemedia->setDescription($description);
            $imagemedia->setUpdatetime(new \DateTime());
            $imagemedia->setKeywords($keywords);

            $image = $request->files->get('img');
            $status = 'success';
            $uploadedURL = '';
            $message = 'No error';

            if (($image instanceof UploadedFile) && ($image->getError() == '0')) {
                if (($image->getSize() < 2000000000)) {
                    $originalName = $image->getClientOriginalName();
                    $name_array = explode('.', $originalName);
                    $file_type = $name_array[sizeof($name_array) - 1];
                    $valid_filetypes = array('jpg', 'jpeg', 'bmp', 'png');

                    if (in_array(strtolower($file_type), $valid_filetypes)) {
                        //Start Uploading File
                        $document = new Document();
                        $document->setFile($image);
                        $document->setUploadDirectory($appRoot . "/../web/uploads");
                        $document->setSubDirectory('profiles');
                        $document->processFile();

                        $uploadedURL = $document->getUploadDirectory() . DIRECTORY_SEPARATOR . $document->getSubDirectory() . DIRECTORY_SEPARATOR . $image->getBasename();
                        $imagemedia->setUploadpath($document->getFilePersistencePath());

                        
                        $em->persist($imagemedia);
                        $user = $em->getRepository('MSSCoreBundle:User')->find($request->getSession()->get('uname'));
                        $user->setPhotopath($document->getFilePersistencePath());
                        $user->setActive('Y');
                        $em->persist($user);
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
            return $this->redirect($this->generateUrl("mss_core_user_profile"));
        } else {
            return $this->render('MSSCoreBundle:User:active.html.twig');
        }
        }else{
            return $this->render('MSSCoreBundle:Home:index.html.twig');
        }
    }

    public function profileAction(Request $request){
        $session = $request->getSession();
        if($session->get('uname')){
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('MSSCoreBundle:User')->find($session->get('uname'));
            if($user){
                $username = $session->get('uname');
                $address = $user->getAddress();
                $email = $user->getEmail();
                $photopath = $user->getPhotopath();
                $sex = $user->getSex();
                $texts = $user->getTexts();
                $images = $user->getImages();
                $audios = $user->getAudios();
                $vedios = $user->getVedios();
                $medias = $texts + $images + $audios + $vedios;
                $active = $user->getActive();
            
                $subscribechannel = $em->getRepository("MSSCoreBundle:Subscribechannel")->findBy(array('observer'=>$session->get('uname')));
                $subchannels = 0;
                foreach($subscribechannel as $channel){
                    if($channel->getObserver() === $session->get("uname")){
                        ++$subchannels;
                    }
                }
                
                $contact = $em->getRepository("MSSCoreBundle:Contactlist")->findby(array('fromname'=>$session->get('uname')));
                $friends = 0;
                $foes = 0;
                foreach($contact as $con){//0 for no relationship, 1 for friend, 2 for foe
                    if($con->getIsfriend() == 1){
                        ++$friends;
                    }else if($con->getIsfriend() == 2){
                        ++$foes;
                    }
                }
            }
            return $this->render('MSSCoreBundle:User:account.html.twig', array('username' => $username, 'email' => $email, 
                'address' => $address, 'photopath' => $photopath, 'sex' => $sex, 'medias' => $medias,
                'subchannels' => $subchannels, 'friends' => $friends,
                'foes' => $foes, 'active' => $active));
        }else{
            return $this->render('MSSCoreBundle:Home:index.html.twig');
        }
    }
    
    public function updateprofileAction(Request $request, $type){
        $em = $this->getDoctrine()->getManager();
	$session = $request->getSession();
	$username = $session->get('uname');
	if($username){
        	$user = $em->getRepository('MSSCoreBundle:User')->find($username);
		$photopath = $user->getPhotopath();
        	return $this->render('MSSCoreBundle:User:updateprofile.html.twig', array('username' => $request->getSession()->get('uname'), 'type'=>$type, 'photopath'=>$photopath));
	}else{
            return $this->render('MSSCoreBundle:Home:index.html.twig');
	}
    }
    
    public function changepassAction(Request $request){
        $session = $request->getSession();
        $username = $session->get('uname');
        if($username){
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('MSSCoreBundle:User')->find($username);
            if($user->getPasswd() == $request->request->get('oldpassword')){
                if($request->request->get('oldpassword') == $request->request->get('password')){
                    $perror = 'No change!';
                    return $this->render("MSSCoreBundle:User:updateprofile.html.twig", array('type' => 'password', 'perror' => $perror));
                }else{
                    $user->setPasswd($request->request->get('password'));
                    $em->flush();
                }
            }else{
                $perror = 'Error old password!';
                return $this->render("MSSCoreBundle:User:updateprofile.html.twig", array('type' => 'password', 'perror' => $perror));
            }
            return $this->redirect($this->generateUrl("mss_core_user_profile"));
        }else{
            return $this->render('MSSCoreBundle:Home:index.html.twig');
        }
        
    }
    
    public function changeinfoAction(Request $request){
        $session = $request->getSession();
        $username = $session->get('uname');
        if($username){
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('MSSCoreBundle:User')->find($username);
            $email = $request->request->get('email');
            $address = $request->request->get('address');
            $sex = $request->request->get('sex');
            if($user->getEmail() != $email || $user->getAddress() != $address || $user->getSex() != $sex){
                if($user->getEmail() != $email){
                    $user->setEmail($email);
                }
                if($user->getAddress() != $address){
                    $user->setAddress($address);
                }
                if($user->getSex() != $sex){
                    $user->setSex($sex);
                }
                $em->flush();
            }else{
                $error = 'No change!';
                return $this->render("MSSCoreBundle:User:updateprofile.html.twig", array('type' => 'general', 'error' => $error));
            }
            return $this->redirect($this->generateUrl("mss_core_user_profile"));
        }else{
            return $this->render('MSSCoreBundle:Home:index.html.twig');
        }
    }
    
    public function channelsAction(Request $request, $username, $type){
        $session = $request->getSession();
        $usr = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
        $isblock = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname' => $username, 'toname' => $usr));
        if($isblock && $isblock->getBlock() == 1){ //Blocked
            $isfriend = $isblock->getIsfriend();
            $blocktype = $isblock->getBlocktype();
            switch ($blocktype){
                case 0:
                case 1: //Block all
                    $allimages = array();
                    $alltexts = array();
                    $allaudios = array();
                    $allvideos = array();
                    break;
                case 2:
                case 3: //Block text
                    if($isfriend === 1){//Friend can view public or private medias
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username));
                        $alltexts = array();
                        $allaudios = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username));
                        $allvideos = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username));
                    }else{//None friend can only view public medias
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        $alltexts = array();
                        $allaudios = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        $allvideos = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                    
                    }
                    break;
                case 4:
                case 5:
                    if($isfriend === 1){
                        $allimages = array();
                        $alltexts = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username));
                        $allaudios = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username));
                        $allvideos = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = array();
                        $alltexts = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        $allaudios = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        $allvideos = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                    
                    }
                        
                    break;
                case 6:
                case 7:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username));
                        $alltexts = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username));
                        $allaudios = array();
                        $allvideos = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        $alltexts = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        $allaudios = array();
                        $allvideos = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                    
                    }
                        
                    break;
                case 8:
                case 9:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username));
                        $alltexts = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username));
                        $allaudios = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username));
                        $allvideos = array();
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        $alltexts = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        $allaudios = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        $allvideos = array();
                    
                    }
                    break;
                case 10:
                case 11:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username));
                        $alltexts = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username));
                        $allaudios = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username));
                        $allvideos = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        $alltexts = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        $allaudios = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        $allvideos = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                    
                    }
                    break;
                default:
                    break;
                    
            }
        }else{
            if($usr === $username || ($isblock && $isblock->getIsfriend() === 1)){
                $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username));
                $alltexts = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username));
                $allaudios = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username));
                $allvideos = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username));
            }else{

                $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username, 'security' => 0));
                $alltexts = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username, 'security' => 0));
                $allaudios = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                $allvideos = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username, 'security' => 0));
        
            }
                if($isblock){
                    $isfriend = $isblock->getIsfriend();
                    
                }else{
                    $isfriend = 0; 
                    
                }
            
        }
        $f = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname' => $usr, 'toname' => $username));
        if($f){
            $friend = $f->getIsfriend();
            $blocked = $f->getBlock();
        }else{
            $friend = -1;
            $blocked = 0;
        }
        $c = $em->getRepository('MSSCoreBundle:Subscribechannel')->findBy(array('observer' => $usr, 'publisher' => $username));
        
        foreach($c as $channel){
            switch($channel->getChanneltype()){
                case 0:
                    $alltype = 1;
                    break;
                case 1:
                    $texttype = 1;
                    break;
                case 2:
                    $imagetype = 1;
                    break;
                case 3:
                    $audiotype = 1;
                    break;
                case 4:
                    $vediotype = 1;
                    break;
                default:
                    break;
            }
        }
        if(!isset($alltype)){
            $alltype = 0;
        }
        if(!isset($texttype)){
            if($alltype == 1){
                $texttype = 1;
            }else{
                $texttype = 0;
            }
        }
        if(!isset($imagetype)){
            if($alltype == 1){
                $imagetype = 1;
            }else{
                $imagetype = 0;
            }
        }
        if(!isset($audiotype)){
            if($alltype == 1){
                $audiotype = 1;
            }else{
                $audiotype = 0;
            }
        }
        if(!isset($vediotype)){
            if($alltype == 1){
                $vediotype = 1;
            }else{
                $vediotype = 0;
            }
        }
        return $this->render('MSSCoreBundle:User:channels.html.twig', array('isblock' => $blocked, 'alltype' => $alltype, 
            'texttype' => $texttype, 'imagetype' => $imagetype, 'audiotype' => $audiotype, 'vediotype' => $vediotype, 
            'foe' => $isfriend, 'isfriend' => $friend, 'self' => $username == $usr, 'username' => $username, 'type' => $type,
                'allimages' => $allimages, 'alltexts' => $alltexts,
            'allaudios' => $allaudios, 'allvideos' => $allvideos));
    }
    
    private function getImagechannel(Request $request, $username){
        $session = $request->getSession();
        $usr = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
        $isblock = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname' => $username, 'toname' => $usr));
        if($isblock && $isblock->getBlock() == 1){ //Blocked
            $isfriend = $isblock->getIsfriend();
            $blocktype = $isblock->getBlocktype();
            switch ($blocktype){
                case 0:
                case 1: //Block all
                    $allimages = array();
                    break;
                case 2:
                case 3: //Block text
                    if($isfriend === 1){//Friend can view public or private medias
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username));
                    }else{//None friend can only view public medias
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        
                    }
                    break;
                case 4:
                case 5:
                    if($isfriend === 1){
                        $allimages = array();
                    }else{
                        $allimages = array();
                         
                    }
                        
                    break;
                case 6:
                case 7:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        
                    }
                        
                    break;
                case 8:
                case 9:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        
                    }
                    break;
                case 10:
                case 11:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username, 'security' => 0));
                       
                    }
                    break;
                default:
                    break;
                    
            }
        }else{
            if($usr === $username || ($isblock && $isblock->getIsfriend() === 1)){
                $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username));
            }else{

                $allimages = $em->getRepository('MSSCoreBundle:Imagemedia')->findBy(array('uploadname' => $username, 'security' => 0));
           }    
        }
        return $allimages;
    }
    
    private function getTextchannel(Request $request, $username){
        $session = $request->getSession();
        $usr = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
        $isblock = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname' => $username, 'toname' => $usr));
        if($isblock && $isblock->getBlock() == 1){ //Blocked
            $isfriend = $isblock->getIsfriend();
            $blocktype = $isblock->getBlocktype();
            switch ($blocktype){
                case 0:
                case 1: //Block all
                    $allimages = array();
                    break;
                case 2:
                case 3: //Block text
                    if($isfriend === 1){//Friend can view public or private medias
                        $allimages = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username));
                    }else{//None friend can only view public medias
                        $allimages = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        
                    }
                    break;
                case 4:
                case 5:
                    if($isfriend === 1){
                        $allimages = array();
                    }else{
                        $allimages = array();
                         
                    }
                        
                    break;
                case 6:
                case 7:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        
                    }
                        
                    break;
                case 8:
                case 9:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        
                    }
                    break;
                case 10:
                case 11:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username, 'security' => 0));
                       
                    }
                    break;
                default:
                    break;
                    
            }
        }else{
            if($usr === $username || ($isblock && $isblock->getIsfriend() === 1)){
                $allimages = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username));
            }else{

                $allimages = $em->getRepository('MSSCoreBundle:Textmedia')->findBy(array('uploadname' => $username, 'security' => 0));
           }    
        }
        return $allimages;
    }
    
    private function getAudiochannel(Request $request, $username){
        $session = $request->getSession();
        $usr = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
        $isblock = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname' => $username, 'toname' => $usr));
        if($isblock && $isblock->getBlock() == 1){ //Blocked
            $isfriend = $isblock->getIsfriend();
            $blocktype = $isblock->getBlocktype();
            switch ($blocktype){
                case 0:
                case 1: //Block all
                    $allimages = array();
                    break;
                case 2:
                case 3: //Block text
                    if($isfriend === 1){//Friend can view public or private medias
                        $allimages = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username));
                    }else{//None friend can only view public medias
                        $allimages = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        
                    }
                    break;
                case 4:
                case 5:
                    if($isfriend === 1){
                        $allimages = array();
                    }else{
                        $allimages = array();
                         
                    }
                        
                    break;
                case 6:
                case 7:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        
                    }
                        
                    break;
                case 8:
                case 9:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        
                    }
                    break;
                case 10:
                case 11:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                       
                    }
                    break;
                default:
                    break;
                    
            }
        }else{
            if($usr === $username || ($isblock && $isblock->getIsfriend() === 1)){
                $allimages = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username));
            }else{

                $allimages = $em->getRepository('MSSCoreBundle:Audiomedia')->findBy(array('uploadname' => $username, 'security' => 0));
           }    
        }
        return $allimages;
    }
    
        
    private function getVediochannel(Request $request, $username){
        $session = $request->getSession();
        $usr = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
        $isblock = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname' => $username, 'toname' => $usr));
        if($isblock && $isblock->getBlock() == 1){ //Blocked
            $isfriend = $isblock->getIsfriend();
            $blocktype = $isblock->getBlocktype();
            switch ($blocktype){
                case 0:
                case 1: //Block all
                    $allimages = array();
                    break;
                case 2:
                case 3: //Block text
                    if($isfriend === 1){//Friend can view public or private medias
                        $allimages = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username));
                    }else{//None friend can only view public medias
                        $allimages = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        
                    }
                    break;
                case 4:
                case 5:
                    if($isfriend === 1){
                        $allimages = array();
                    }else{
                        $allimages = array();
                         
                    }
                        
                    break;
                case 6:
                case 7:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        
                    }
                        
                    break;
                case 8:
                case 9:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                        
                    }
                    break;
                case 10:
                case 11:
                    if($isfriend === 1){
                        $allimages = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username));
                    }else{
                        $allimages = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username, 'security' => 0));
                       
                    }
                    break;
                default:
                    break;
                    
            }
        }else{
            if($usr === $username || ($isblock && $isblock->getIsfriend() === 1)){
                $allimages = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username));
            }else{

                $allimages = $em->getRepository('MSSCoreBundle:Vediomedia')->findBy(array('uploadname' => $username, 'security' => 0));
           }    
        }
        return $allimages;
    }
    
    
    public function subchannelsAction(Request $request, $username, $type, $publisher){
        if($username === $request->getSession()->get('uname')){
            $self = 1;
        }else{
            $self = 0;
        }
	if($publisher === "all"){
        	$observer = $username;
        	$em = $this->getDoctrine()->getManager();
        	$allchannels = $em->getRepository('MSSCoreBundle:Subscribechannel')->findBy(array('observer' => $observer));
        	$imagechannel = array();
        	$imageowner = array();
        	$textchannel = array();
        	$textowner = array();
        	$audiochannel = array();
        	$audioowner = array();
        	$vediochannel = array();
        	$vedioowner = array();
        	foreach($allchannels as $channel){
        	    switch($channel->getChanneltype()){
        	        case 0: //All channel
        	            $textowner[] = $channel->getPublisher();
        	            $textchannel[] = $this->getTextchannel($request, $channel->getPublisher());
        	            
        	            $imagechannel[] = $this->getImagechannel($request, $channel->getPublisher());
        	            $imageowner[] = $channel->getPublisher();
        	            $audiochannel[] = $this->getAudiochannel($request, $channel->getPublisher());
        	            $audioowner[] = $channel->getPublisher();
        	            $vediochannel[] = $this->getVediochannel($request, $channel->getPublisher());
        	            $vedioowner[] = $channel->getPublisher();
        	            break;
        	        case 1: //Text channel
        	            $textchannel[] = $this->getTextchannel($request, $channel->getPublisher());
        	            $textowner[] = $channel->getPublisher();
        	            break;
        	        case 2: //Image channel
        	            $imagechannel[] = $this->getImagechannel($request, $channel->getPublisher());
        	            $imageowner[] = $channel->getPublisher();
        	            break;
        	        case 3: //Audio channel
        	            $audiochannel[] = $this->getAudiochannel($request, $channel->getPublisher());
        	            $audioowner[] = $channel->getPublisher();
        	            break;
        	        case 4: //Vedio channel
        	            $vediochannel[] = $this->getVediochannel($request, $channel->getPublisher());
        	            $vedioowner[] = $channel->getPublisher();
        	            break;
        	        default:
        	            break;
        	    }
        	}
	}else{
        	$observer = $username;
        	$em = $this->getDoctrine()->getManager();
        	$allchannels = $em->getRepository('MSSCoreBundle:Subscribechannel')->findBy(array('observer' => $observer, 'publisher' => $publisher));
        	$imagechannel = array();
        	$imageowner = array();
        	$textchannel = array();
        	$textowner = array();
        	$audiochannel = array();
        	$audioowner = array();
        	$vediochannel = array();
        	$vedioowner = array();
        	foreach($allchannels as $channel){
        	    switch($channel->getChanneltype()){
        	        case 0: //All channel
        	            $textowner[] = $channel->getPublisher();
        	            $textchannel[] = $this->getTextchannel($request, $channel->getPublisher());
        	            
        	            $imagechannel[] = $this->getImagechannel($request, $channel->getPublisher());
        	            $imageowner[] = $channel->getPublisher();
        	            $audiochannel[] = $this->getAudiochannel($request, $channel->getPublisher());
        	            $audioowner[] = $channel->getPublisher();
        	            $vediochannel[] = $this->getVediochannel($request, $channel->getPublisher());
        	            $vedioowner[] = $channel->getPublisher();
        	            break;
        	        case 1: //Text channel
        	            $textchannel[] = $this->getTextchannel($request, $channel->getPublisher());
        	            $textowner[] = $channel->getPublisher();
        	            break;
        	        case 2: //Image channel
        	            $imagechannel[] = $this->getImagechannel($request, $channel->getPublisher());
        	            $imageowner[] = $channel->getPublisher();
        	            break;
        	        case 3: //Audio channel
        	            $audiochannel[] = $this->getAudiochannel($request, $channel->getPublisher());
        	            $audioowner[] = $channel->getPublisher();
        	            break;
        	        case 4: //Vedio channel
        	            $vediochannel[] = $this->getVediochannel($request, $channel->getPublisher());
        	            $vedioowner[] = $channel->getPublisher();
        	            break;
        	        default:
        	            break;
        	    }
        	}
	}
        return $this->render('MSSCoreBundle:User:subchannels.html.twig', array('type' => $type, 'self' => $self, 'username' => $observer, 
            'textchannel' => $textchannel, 'imagechannel' => $imagechannel, 
            'audiochannel' => $audiochannel, 'vediochannel' => $vediochannel,
            'textowner' => $textowner, 'imageowner' => $imageowner,
            'audioowner' => $audioowner, 'vedioowner' => $vedioowner));
    }

    public function subscribechannelAction(Request $request, $publisher, $type){
        $session = $request->getSession();
        $observer = $session->get('uname'); //The current user is the observer
        $em = $this->getDoctrine()->getManager();
        $subscribe = new Subscribechannel();
        $subscribe->setObserver($observer);
        $subscribe->setPublisher($publisher);
        if($type === 'all'){
            $subscribe->setChanneltype(0);
            $c = $em->getRepository('MSSCoreBundle:Subscribechannel')->findBy(array('observer' => $observer, 'publisher' => $publisher));
        
            foreach($c as $channel){
                $em->remove($channel);
            }
        }else if($type === 'text'){
            $subscribe->setChanneltype(1);
        }else if($type === 'image'){
            $subscribe->setChanneltype(2);
        }else if($type === 'audio'){
            $subscribe->setChanneltype(3);
        }else if($type === 'vedio'){
            $subscribe->setChanneltype(4);
        }
        $em->persist($subscribe);
        $em->flush();
        return $this->redirect($this->generateUrl("mss_core_user_subchannels", array('username' => $observer)));
    }
    
    public function unsubscribechannelAction(Request $request, $publisher, $type){
        $session = $request->getSession();
        $observer = $session->get('uname'); //The current user is the observer
        $em = $this->getDoctrine()->getManager();
        if($type === 'all'){
            $channeltype = 0;
        }else if($type === 'text'){
            $channeltype = 1;
        }else if($type === 'image'){
            $channeltype = 2;
        }else if($type === 'audio'){
            $channeltype = 3;
        }else if($type === 'vedio'){
            $channeltype = 4;
        }
        $c = $em->getRepository('MSSCoreBundle:Subscribechannel')->findOneBy(array('observer' => $observer, 'publisher' => $publisher, 'channeltype' => $channeltype));
        if($c){
            $em->remove($c);
        }else{
            $all = $em->getRepository('MSSCoreBundle:Subscribechannel')->findOneBy(array('observer' => $observer, 'publisher' => $publisher, 'channeltype' => 0));
            $em -> remove($all);
            $i = 1;
            for($i; $i < 5; ++$i){
                if($i != $channeltype){
                    $subscribe = new Subscribechannel();
                    $subscribe->setObserver($observer);
                    $subscribe->setPublisher($publisher);
                    $subscribe->setChanneltype($i);
                    $em->persist($subscribe);
                }
            }
        }
        $em->flush();
        return $this->redirect($this->generateUrl("mss_core_user_subchannels", array('username' => $observer)));
    }
    
    public function blockAction(Request $request, $toname){
        return $this->render('MSSCoreBundle:User:block.html.twig', array('username' => $request->getSession()->get('uname'), 'toname' => $toname));
    }
    
    
    public function blocktypeAction(Request $request, $toname, $type){
        $session = $request->getSession();
        $fromname = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
        
        $fromuser = $em->getRepository('MSSCoreBundle:User')->find($fromname);
        $touser = $em->getRepository("MSSCoreBundle:User")->find($toname);
        
        $con = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname'=>$fromname, 'toname'=>$toname));
        if($con){//The two user already has some relationship
            $con->setBlock(1); //Set to block
            if($type == 'allviewing'){
                $con->setBlocktype(0);
            }else if($type == 'alldownloading'){
                $con->setBlocktype(1);
            }else if($type == 'textviewing'){
                $con->setBlocktype(2);
            }else if($type == 'textdownloading'){
                $con->setBlocktype(3);
            }else if($type == 'imageviewing'){
                $con->setBlocktype(4);
            }else if($type == 'imagedownloading'){
                $con->setBlocktype(5);
            }else if($type == 'audioviewing'){
                $con->setBlocktype(6);
            }else if($type == 'audiodownloading'){
                $con->setBlocktype(7);
            }else if($type == 'vedioviewing'){
                $con->setBlocktype(8);
            }else if($type == 'vediodownloading'){
                $con->setBlocktype(9);
            }else if($type == 'someviewing'){
                $con->setBlocktype(10);
                $to->setBlockcontent("");
            }else if($type == 'somedownloading'){
                $con->setBlocktype(11);
                $to->setBlockcontent("");
            }
        }else{//No relationship before, need insert a record
            $to = new Contactlist();
            $to->setFromname($fromuser);
            $to->setToname($touser);
            $to->setIsfriend(0); //The friendship need to confirm by touser
            $to->setBlock(1);
            
            if($type == 'allviewing'){
                $to->setBlocktype(0);
            }else if($type == 'alldownloading'){
                $to->setBlocktype(1);
            }else if($type == 'textviewing'){
                $to->setBlocktype(2);
            }else if($type == 'textdownloading'){
                $to->setBlocktype(3);
            }else if($type == 'imageviewing'){
                $to->setBlocktype(4);
            }else if($type == 'imagedownloading'){
                $to->setBlocktype(5);
            }else if($type == 'audioviewing'){
                $to->setBlocktype(6);
            }else if($type == 'audiodownloading'){
                $to->setBlocktype(7);
            }else if($type == 'vedioviewing'){
                $to->setBlocktype(8);
            }else if($type == 'vediodownloading'){
                $to->setBlocktype(9);
            }else if($type == 'someviewing'){
                $to->setBlocktype(10);
                $to->setBlockcontent("");
            }else if($type == 'somedownloading'){
                $to->setBlocktype(11);
                $to->setBlockcontent("");
            }
            $em->persist($to);
        }
        $em->flush();
        return $this->redirect($this->generateUrl("mss_core_user_friends"));
    }
    
    public function unblockAction(Request $request, $toname){
        $session = $request->getSession();
        $fromname = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
         
        $con = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname'=>$fromname, 'toname'=>$toname));
        if($con->getIsfriend() == 1 || $con->getIsfriend() == 2){//A friend or foe
            $con->setBlock(0); //Set to no block
        }else{
            $em->remove($con);
        }
        
        $em->flush();
        return $this->redirect($this->generateUrl("mss_core_user_friends"));
    }

    public function friendsAction(Request $request){
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository("MSSCoreBundle:Contactlist")->findBy(array('fromname' => $session->get('uname')));
        $friends = array();
        $requests = array();
        $confirms = array();
        $blocks = array();
        foreach($contact as $con){
            if($con->getIsfriend() == 1){
                $friends[] = $con->getToname();
            }else if($con->getIsfriend() == 0){
                $confirms[] = $con->getToname();
            }
            if($con->getBlock() == 1){
                $blocks[] = $con->getToname();
            }
        }
        $newfriend = $em->getRepository('MSSCoreBundle:Contactlist')->findBy(array('toname' => $session->get('uname')));
        foreach($newfriend as $newf){
            if($newf->getIsfriend() == 0){
                $requests[] = $newf->getFromname();
            }
        }
        return $this->render("MSSCoreBundle:User:friends.html.twig", array('username' => $session->get('uname'), 'friends' => $friends, 'requests' => $requests, 'confirms' => $confirms, 'blocks' => $blocks));
    }
    
    public function makefriendAction(Request $request, $toname){
        $session = $request->getSession();
        $fromname = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
        
        $fromuser = $em->getRepository('MSSCoreBundle:User')->find($fromname);
        $touser = $em->getRepository("MSSCoreBundle:User")->find($toname);
        
        $foe = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname'=>$fromname, 'toname'=>$toname));
        if($foe){//This user is a foe before or you have send a friend request
            $foe->setIsfriend(0); //The friendship need to confirm by touser
        }else{
            $to = new Contactlist();
            $to->setFromname($fromuser);
            $to->setToname($touser);
            $to->setIsfriend(0); //The friendship need to confirm by touser
            $to->setBlock(0);
            $to->setBlocktype(0);
            $to->setBlockcontent("");
            $em->persist($to);
        }
        $em->flush();
        
        return $this->redirect($this->generateUrl("mss_core_user_friends"));
    }
    
    public function confirmfriendAction(Request $request, $toname){
        $session = $request->getSession();
        $fromname = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
        $fromuser = $em->getRepository('MSSCoreBundle:User')->find($fromname);
        $touser = $em->getRepository("MSSCoreBundle:User")->find($toname);
        $friend = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname'=>$toname, 'toname'=>$fromname));
        if($friend){
            $friend->setIsfriend(1);
        }
        $to = new Contactlist();
        $to->setFromname($fromuser);
        $to->setToname($touser);
        $to->setIsfriend(1);
        $to->setBlock(0);
        $to->setBlocktype(0);
        $to->setBlockcontent("");
        $em->persist($to);
        $em->flush();
        return $this->redirect($this->generateUrl("mss_core_user_friends"));
    }
    
    public function refusefriendAction(Request $request, $toname){
        
    }
    
    public function canclefriendAction(Request $request, $toname){
        $session = $request->getSession();
        $fromname = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
        $to = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname'=>$fromname, 'toname'=>$toname));
        if($to){
            $em->remove($to);
        }
        $em->flush();
        return $this->redirect($this->generateUrl("mss_core_user_friends"));
    }
    
    public function unfriendAction(Request $request, $toname){
        $session = $request->getSession();
        $fromname = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
        $to = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname'=>$fromname, 'toname'=>$toname));
        if($to){
            $em->remove($to);
        }
        $from = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname'=>$toname, 'toname'=>$fromname));
        if($from){
            $em->remove($from);
        }
        $em->flush();
        return $this->redirect($this->generateUrl("mss_core_user_friends"));
    }
    
    public function foesAction(Request $request){
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository("MSSCoreBundle:Contactlist")->findBy(array('fromname'=>$session->get('uname')));
        $foes = array();
        foreach($contact as $con){
            if($con->getIsfriend() == 2){
                $foes[] = $con->getToname();
            }
        }
        return $this->render("MSSCoreBundle:User:foes.html.twig", array('username' => $request->getSession()->get('uname'), 'foes' => $foes));
    }
    
    public function makefoeAction(Request $request, $toname){
        $session = $request->getSession();
        $fromname = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
        
        $fromuser = $em->getRepository('MSSCoreBundle:User')->find($fromname);
        $touser = $em->getRepository("MSSCoreBundle:User")->find($toname);
        
        $friend = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname'=>$toname, 'toname'=>$fromname));
        if($friend){//This user is a friend before or want to be a friend
            $em->remove($friend);
            if($friend->getIsfriend() == 0){//Want to be a friend
                $to = new Contactlist();
                $to->setFromname($fromuser);
                $to->setToname($touser);
                $to->setIsfriend(2); //Make foe
                $to->setBlock(1); //Block
                $to->setBlocktype(0);
                $to->setBlockcontent("");
                $em->persist($to);
            }else{//A friend before
                $f = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname'=>$fromname, 'toname'=>$toname));
                $f->setIsfriend(2);     
                $f->setBlock(1);
                $f->setBlocktype(0);
            }
        }else{
            $f = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname'=>$fromname, 'toname'=>$toname));
            if($f){
                $f->setIsfriend(2);
            }else{
                $to = new Contactlist();
                $to->setFromname($fromuser);
                $to->setToname($touser);
                $to->setIsfriend(2); //The friendship need to confirm by touser
                $to->setBlock(1);
                $to->setBlocktype(0);
                $to->setBlockcontent("");
                $em->persist($to);
            }
        }
        $em->flush();
        
        return $this->redirect($this->generateUrl("mss_core_user_foes"));
    }
    
    public function unfoeAction(Request $request, $toname){
        $session = $request->getSession();
        $fromname = $session->get('uname');
        $em = $this->getDoctrine()->getManager();
        $to = $em->getRepository('MSSCoreBundle:Contactlist')->findOneBy(array('fromname'=>$fromname, 'toname'=>$toname));
        if($to){
            $em->remove($to);
        }
        $em->flush();
        return $this->redirect($this->generateUrl("mss_core_user_foes"));
    }
    
    public function logoutAction(Request $request) {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $username = $session->get('uname');
        if($username){
            $user = $em->getRepository('MSSCoreBundle:User')->find($session->get('uname'));
            if($user){
                $user->setStatus(0);
                $em->flush();
            }
        }
        $session->clear();
        return $this->redirect($this->generateUrl('mss_core_homepage'));
    }
    

}

