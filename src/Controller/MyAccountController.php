<?php

namespace App\Controller;

use App\Entity\Albumes;
use App\Entity\AlbumesAdmin;
use App\Entity\User;
use App\Utility\AlertModal;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class MyAccountController extends LayoutController
{
    private $entityManager;
    private $UserPasswordHasher;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher)
    {
        // 3. Actualice el valor de la variable privada entityManager mediante inyección.
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    #[Route('/my/account', name: 'app_my_account')]
    public function index(): Response
    {
        $em = $this->entityManager;
        $this->processForm();
        if(empty($this->getUser()))
        {
            return $this->redirectToRoute('app_login');
        }
        $data = parent::index();
        $albumes = $this->getUser()->getAlbumes();
        $conn = $em->getConnection();
        $albumesAdmin =
            'SELECT a.albumes_id FROM  albumes_admin_albumes a
            LEFT JOIN albumes_admin_user b ON (a.albumes_admin_id = b.albumes_admin_id)
            WHERE b.user_id = '.$this->getUser()->getId()
        ;
        $stmt = $conn->prepare($albumesAdmin);
        $query = $stmt->executeQuery();
        $results = $query->fetchAllAssociative();
        $admins = array();

        foreach($results as $result)
        {
            $albunFinded = $em->getRepository(Albumes::class)->find($result['albumes_id']);
            $admins[] = $albunFinded;
        }

        foreach($albumes as $key => $album)
        {
            $data['albumes'][$key] = $album;
        }

        $data['admins'] = $admins;
        $data['datos'] = 'Datos de este controlador';
        return $this->render('my_account/index.html.twig', $data);
    }

    protected function processForm()
    {
        if($_POST)
        {
            $em = $this->entityManager;
            $uph = $this->userPasswordHasher;
            $user = $this->getUser();
            if(!empty($_POST['name']))
            {
                $user->setUserName($_POST['name']);
            }
            if(!empty($_POST['surname']))
            {
                $user->setUserLastname($_POST['surname']);
            }
            if(!empty($_POST['email']))
            {
                $user->setEmail
                ($_POST['email']);
            }
            if(!empty($_POST['password']))
            {
                $user->setPassword(
                    $uph->hashPassword(
                        $user,
                        $_POST['password']
                    )
                );
            }
            $user->setDateUpdate(new \DateTimeImmutable());
            $em->flush();
            AlertModal::printModal('Se han actualizado tus datos', 'success');
        }
    }
}
