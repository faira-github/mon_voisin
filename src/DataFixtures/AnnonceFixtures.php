<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Entity\Comment;


class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        //Creer 3 categorie
        for ($i = 1; $i <= 4; $i++) {
            $category = new Categorie();
            $category->setNomCategorie($faker->sentence())
                ->setDescriptionCategorie($faker->paragraph());

            $manager->persist($category);

            for ($j = 1; $j <= mt_rand(4, 6); $j++) {
                $annonce = new Annonce();
                $annonce->setAnnonceTitle($faker->sentence())
                        ->setAnnoncePicture($faker->imageUrl())
                        ->setAnnonceDescription($faker->paragraph())
                        ->setCreatedAt($faker->dateTimeBetween('-6 months')
                        )
                        ->setCategorie($category);

                $manager->persist($annonce);

                // on donne des commentaires à l'article
                for ($k = 1; $k <= mt_rand(4, 10); $k++) {

                    $comment = new Comment();
                    $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';
                    
                    $days = (new \DateTime())->diff($annonce->getCreaTedAt())->days;

                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            ->setCreaTedAt($faker->dateTimeBetween('-' . $days . 'days'))
                            ->setArticle($annonce);

                $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}