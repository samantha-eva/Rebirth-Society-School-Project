<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\User;
use App\Entity\Order;
use App\Entity\Payment;
use App\Entity\Pack;
use App\Entity\Video;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // ---------------------------
        // 1️⃣ Catégories
        // ---------------------------
        $categorie1 = new Categorie();
        $categorie1->setName('Catégorie A');
        $manager->persist($categorie1);

        $categorie2 = new Categorie();
        $categorie2->setName('Catégorie B');
        $manager->persist($categorie2);

        // ---------------------------
        // 2️⃣ Packs
        // ---------------------------
        $pack1 = new Pack();
        $pack1->setName('Starter Pack');
        $pack1->setPrice(29.99);
        $manager->persist($pack1);

        $pack2 = new Pack();
        $pack2->setName('Pro Pack');
        $pack2->setPrice(79.99);
        $manager->persist($pack2);

        $pack3 = new Pack();
        $pack3->setName('Ultimate Pack');
        $pack3->setPrice(149.99);
        $manager->persist($pack3);

        // ---------------------------
        // 3️⃣ Vidéos
        // ---------------------------
        $video1 = new Video();
        $video1->setName('Introduction Symfony');
        $video1->setPrice(9.99);
        $video1->setUrl('https://example.com/video1.mp4');
        $video1->setCategorie($categorie1);
        $manager->persist($video1);

        $video2 = new Video();
        $video2->setName('Doctrine ORM avancé');
        $video2->setPrice(14.99);
        $video2->setUrl('https://example.com/video2.mp4');
        $video2->setCategorie($categorie1);
        $manager->persist($video2);

        $video3 = new Video();
        $video3->setName('API Platform');
        $video3->setPrice(19.99);
        $video3->setUrl('https://example.com/video3.mp4');
        $video3->setCategorie($categorie2);
        $manager->persist($video3);

        // Packs ↔ Vidéos
        $pack1->addVideo($video1);
        $pack2->addVideo($video2);
        $pack3->addVideo($video3);
        $pack3->addVideo($video1);

        // ---------------------------
        // 4️⃣ Users
        // ---------------------------
        $user1 = new User();
        $user1->setEmail('alice@example.com');
        $user1->setPassword(password_hash('password123', PASSWORD_BCRYPT));
        $user1->setRoles(['ROLE_USER']);
        $user1->setFirstName('Alice');
        $user1->setLastName('Durand');
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail('bob@example.com');
        $user2->setPassword(password_hash('password123', PASSWORD_BCRYPT));
        $user2->setRoles(['ROLE_USER']);
        $user2->setFirstName('Bob');
        $user2->setLastName('Martin');
        $manager->persist($user2);

        // ---------------------------
        // 5️⃣ Orders
        // ---------------------------
        $order1 = new Order();
        $order1->setAmount(109.98);
        $order1->setCreatedAt(new \DateTimeImmutable());
        $order1->setDateOrder(new \DateTime());
        $order1->setUser($user1);
        $manager->persist($order1);

        $order1->addPack($pack1);
        $order1->addPack($pack2);

        // Ajout de vidéos individuelles
         $order1->addVideosIndividuale($video3);

        $order2 = new Order();
        $order2->setAmount(149.99);
        $order2->setCreatedAt(new \DateTimeImmutable());
        $order2->setDateOrder(new \DateTime());
        $order2->setUser($user2);
        $manager->persist($order2);

        $order2->addPack($pack3);

        // Ajout de vidéos individuelles
        $order2->addVideosIndividuale($video1);
        $order2->addVideosIndividuale($video2);

        // ---------------------------
        // 6️⃣ Payments
        // ---------------------------
        $payment1 = new Payment();
        $payment1->setCommande($order1);
        $payment1->setAmount(49.99);
        $payment1->setDatePayment(new \DateTime('2025-09-03'));
        $payment1->setCreatedAt(new \DateTimeImmutable());
        $manager->persist($payment1);

        $payment2 = new Payment();
        $payment2->setCommande($order2);
        $payment2->setAmount(99.90);
        $payment2->setDatePayment(new \DateTime('2025-09-01'));
        $payment2->setCreatedAt(new \DateTimeImmutable('-1 day'));
        $manager->persist($payment2);

        // ---------------------------
        // Sauvegarde
        // ---------------------------
        $manager->flush();
    }
}
