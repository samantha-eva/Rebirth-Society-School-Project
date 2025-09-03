<?php

namespace App\Controller\Admin;

use App\Entity\Pack;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class PackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Pack::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
                TextField::new('name'),
                MoneyField::new('price')->setCurrency('EUR'),
                ImageField::new('image')
                    ->setUploadDir('public/uploads/packs') // dossier pour stocker les fichiers
                    ->setBasePath('uploads/packs')         // chemin accessible depuis le web
                    ->setRequired(false),
            ];
    }
    
}
