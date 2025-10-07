<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Niveau;
use App\Entity\Player;
use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // --- 1. Catégories ---
        $categories = [];
        $categoryNames = ['Football', 'Basketball', 'Handball'];
        foreach ($categoryNames as $name) {
            $category = new Category();
            $category->setNom($name);
            $manager->persist($category);
            $categories[] = $category;
        }

        // --- 2. Niveaux ---
        $levels = [];
        $levelNames = ['Débutant', 'Intermédiaire', 'Confirmé', 'Professionnel'];
        foreach ($levelNames as $name) {
            $level = new Niveau();
            $level->setNom($name);
            $manager->persist($level);
            $levels[] = $level;
        }

        // --- 3. Utilisateurs ---
        $admin = new User();
        $admin->setEmail('admin@chartres.fr');
        $admin->setPrenom('Jean');
        $admin->setNom('Admin');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'Admin123!'));
        $manager->persist($admin);

        $user = new User();
        $user->setEmail('user@chartres.fr');
        $user->setPrenom('Pierre');
        $user->setNom('Utilisateur');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword($this->passwordHasher->hashPassword($user, 'User123!'));
        $manager->persist($user);

        // --- 4. Joueurs ---
        $players = [];
        for ($i = 0; $i < 4; $i++) {
            $player = new Player();
            $player->setPrenom($faker->firstName);
            $player->setNom($faker->lastName);
            $player->setBirthDate($faker->dateTimeBetween('-30 years', '-18 years'));
            $player->setMaCategorie($faker->randomElement($categories));
            $player->setUnNiveau($faker->randomElement($levels));
            // no photo property on Player entity; skip setting photo
            $manager->persist($player);
            $players[] = $player;
        }

        // --- 5. Avis ---
        for ($i = 0; $i < 2; $i++) {
            $review = new Review();
            $review->setRating($faker->numberBetween(1, 5));
            $review->setComment($faker->sentence(10));
            $review->setCreatedAt(new \DateTime());
            $review->setUnUtilisateur($faker->randomElement([$user, $admin]));
            $review->setUnJoueur($faker->randomElement($players));
            $manager->persist($review);
        }

        // --- 6. Enregistrer en base ---
        $manager->flush();
    }
}
