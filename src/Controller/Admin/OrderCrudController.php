<?php

namespace App\Controller\Admin;

use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Mime\RawMessage;

class OrderCrudController extends AbstractCrudController
{
    private $entityManager;
    private $adminUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator $adminUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation = Action::new('updatePreparation', 'Préparation en cours', 'fas fa-box-open' )->linkToCrudAction('updatePreparation');
        $updateDelivery = Action::new('updateDelivery', 'Livraison en cours', 'fas fa-truck' )->linkToCrudAction('updateDelivery');

        return $actions
            ->add('detail', $updateDelivery)
            ->add('detail', $updatePreparation)
            ->add('index', 'detail');
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']); 
    }

    public function updatePreparation(AdminContext $context) 
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(2);
        $this->entityManager->flush();



        $this->addFlash('notice', "<span style='color:green'><strong>La commande n° ".$order->getReference()." est bien <u>en cours de préparation</u></strong></span>");
        
        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

            //envoi d'un mail pour la confirmation de la préparation

            // $mail = new Mail();
            // $content = 'Bonjour'.$order->getUser()->getFirstname().'<br>Votre commande n°'.$order->getReference().'est en cours de préparation.';
            // $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande n°'.$order->getReference().'est en cours de préparation.', $content);

            return $this->redirect($url);
    }

    public function updateDelivery(AdminContext $context) 
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(3);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span style='color:orange'><strong>La commande n° ".$order->getReference()." est bien <u>en cours de livraison</u></strong></span>");
        
        $url = $this->adminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

            //envoi d'un mail pour la confirmation de la livraison en cours

            // $mail = new Mail();
            // $content = 'Bonjour'.$order->getUser()->getFirstname().'<br>Votre commande est en cours de livraison par le transporteur'.$order->getCarrierName().'.';
            // $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande n°'.$order->getReference().'est en cours de livraison.', $content);

            return $this->redirect($url);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('createdAt', 'Passée le'),
            TextField::new('user.fullName', 'Client'),
            TextEditorField::new('delivery', 'Adresse de livraison')->onlyOnDetail()->formatValue(function ($value, $entity) {
                return $value; // Désactive l'échappement HTML
            }),
            MoneyField::new('total', 'Total Produit')->setCurrency('EUR'),
            TextField::new('carrierName', 'Transporteur'),
            MoneyField::new('carrierPrice', 'Frais de port')->setCurrency('EUR'),
            ChoiceField::new('state')->setChoices([
                'Non payé' => 0,
                'Payé' => 1,
                'Préparation en cours' => 2,
                'Livraison en cours' => 3
            ]),
            ArrayField::new('orderDetails', 'Produits achetés')->hideOnIndex()
        ];
    }
    
}
