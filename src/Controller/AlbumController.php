<?php

namespace App\Controller;

use App\Entity\Albumes;
use App\Entity\Photos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AlbumController extends LayoutController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/album/{id}', name: 'app_album')]
    public function index(Request $request): Response
    {
        if(empty($this->getUser()))
        {
            return $this->redirectToRoute('app_login');
        }

        if(isset($_GET['addPhotos']))
        {
            return $this->addPhotos($request);
        }
        return $this->indexPage($request);
    }

    public function indexPage(Request $request)
    {
        $em = $this->entityManager;
        $id = $request->get('id');
        $album = $em->getRepository(Albumes::class)->find($id);
        $icon = $album->getIcon();
        $title = $album->getTitle();
        $banner = $album->getAlbumBanner();
        $data = parent::index($request);
        $data['photos'] = $album->getPhotos();
        $data['icon'] = $icon;
        $data['title'] = $title;
        $data['banner'] = $banner;
        $data['album_id'] = $id;
        return $this->render('album/index.html.twig', $data);
    }

    public function addPhotos(Request $request)
    {
        $em = $this->entityManager;
        $id = $request->get('id');
        $album = $em->getRepository(Albumes::class)->find($id);
        $icon = $album->getIcon();
        $title = $album->getTitle();
        $banner = $album->getAlbumBanner();
        $data = parent::index($request);
        $data['photos'] = $album->getPhotos();
        $data['icon'] = $icon;
        $data['title'] = $title;
        $data['banner'] = $banner;
        $data['album_id'] = $id;
        return $this->render('album/addPhotos.html.twig', $data);
    }

    #[Route('/album/{id}/morePhotos', name: 'app_album_more_photos')]
    public function morePhotos(Request $request): Response
    {
        $format = array("image/pjpeg", "image/jpeg", "image/png", "image/gif", "image/webp");
        if (in_array($_FILES["file"]["type"], $format)) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], "img/user/".$_POST['name'].".jpg")) {
                $em = $this->entityManager;
                $id = $request->get('id');
                $album = $em->getRepository(Albumes::class)->find($id);
                $photo = new Photos();
                $photo->setPhotoOwner($this->getUser());
                $photo->setPhotoAlbum($album);
                $photo->setDateAdd(new \DateTimeImmutable());
                $photo->setPhotoPath($_POST['name'].".jpg");
                $em->persist($photo);
                $em->flush();
                //more code here...
                $response = new Response('ok',
                    Response::HTTP_OK,
                    array('content-type' => 'text/html')
                    );
                return $response;
            } else {
                $response = new Response('error',
                    Response::HTTP_OK,
                    array('content-type' => 'text/html')
                );
                return $response;
            }
        } else {
            $response = new Response('error',
                Response::HTTP_OK,
                array('content-type' => 'text/html')
            );
            return $response;
        }
    }
}
