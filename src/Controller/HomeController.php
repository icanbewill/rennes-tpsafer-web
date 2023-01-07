<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Property;
use App\Form\SearchDataForm;
use App\Repository\CategoryRepository;
use App\Repository\PropertyRepository;
use ContainerAgr3dtg\PaginatorInterface_82dac15;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class HomeController extends AbstractController
{
    private $em;
    private $propertyRepository;

    public function __construct(EntityManagerInterface $em, PropertyRepository $propertyRepository)
    {
        $this->em = $em;
        $this->propertyRepository = $propertyRepository;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(CategoryRepository $categoryRepository, Request $request): Response
    {
        $sql = 'SELECT * from property ORDER BY RAND() LIMIT 3';
        $em = $this->getDoctrine()->getManager();
        $statement = $em->getConnection()->prepare($sql);
        $result = $statement->execute()->fetchAll();

        $properties = [];

        foreach ($result as $key => $value) {
            $property = new Property();
            $property->setId($value['id']);
            $property->setImage($value['image']);
            $property->setTitle($value['title']);
            $property->setOwner($value['owner']);
            $property->setType($value['type']);
            $property->setSurface($value['surface']);
            $property->setPrice($value['price']);
            $property->setCountry($value['country']);
            $property->setPostalCode($value['postal_code']);
            $property->setDescription($value['description']);
            $property->setCategoryId($categoryRepository->findOneBy(array('id' => $value['category_id_id'])));
            $properties[] = $property;
        }

        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchDataForm::class, $data);
        $form->handleRequest($request);

        return $this->render('landing/index.html.twig', [
            'properties' => $properties,
            'categories' => $categoryRepository->findAll(),
            'form' => $form->createView()
        ]);
    }

    /**
     * retourner la liste des categories sur la landing page
     * @Route("/categories/{name}", name="app_category_items", methods={"GET"})
     */
    public function list($name, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBy(array('libelle' => $name));
        $properties = $category->getProperties();
        return $this->render('landing/properties.html.twig', [
            'view' => 'list_category',
            'category' => $category,
            'properties' => $properties
        ]);
    }

    /**
     * Gestion du formulaire multi-critere
     * @Route("/search", name="app_search")
     */
    public function search(PropertyRepository $repository, Request $request)
    {
        $data = new SearchData();
        $data->page = $request->get('page', 1);
        $form = $this->createForm(SearchDataForm::class, $data);
        $form->handleRequest($request);
        $properties = $repository->findSearch($data);
        return $this->render('landing/properties.html.twig', [
            'view' => 'filter',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }
    /**
     * Gestion du formulaire de contact
     * @Route("/contact", name="app_contact")
     */
    public function contact(Request $request, MailerInterface $mailer)
    {
        try {
            $email = (new TemplatedEmail())
                ->from($request->request->get('email'))
                ->to('safer@example.com')
                ->subject($request->request->get('subject'))
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'message' => $request->request->get('message'),
                    'phone' => $request->request->get('phone'),
                    'username' => $request->request->get('username')
                ]);
            $mailer->send($email);

            $this->addFlash(
                'success',
                'Mail envoyé avec succès !'
            );
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }


        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Suppression de la session en cours
     * @Route("/remove-session", name="app_remove_session")
     */
    public function removeSession(Request $request)
    {
        $session = $request->getSession();
        $session->clear();
        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }
}
