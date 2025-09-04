<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class VideoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Video::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            MoneyField::new('price')->setCurrency('EUR'),
            TextField::new('url'),
            ImageField::new('image')
                    ->setUploadDir('public/uploads/packs') // dossier pour stocker les fichiers
                    ->setBasePath('uploads/packs')         // chemin accessible depuis le web
                    ->setRequired(false),
             AssociationField::new('categorie'),
        ];
    }
    
}
