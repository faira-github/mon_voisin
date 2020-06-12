<?php

namespace App\DataFixtures;


use App\Entity\User;
use App\Entity\Slider;
use App\Entity\Annonce;
use App\Entity\Comment;
use App\Entity\Quartier;
use App\Entity\Ville;
use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     *   // https://symfonycasts.com/screencast/symfony-doctrine/faker-fixtures
     */
    public function load(ObjectManager $manager)
    {
        
        $faker = \Faker\Factory::create('fr_FR');
        $users = [];


        for ($u = 1; $u <= 4; $u++) {
            // Utilisateurs simples
            $user = new User();
            $user->setEmail('voisin'.$u.'@accote.com')
                ->setFirstName($faker->firstName())
                ->setRoles(['ROLE_USER'])
                ->setName($faker->lastName())
                ->setDateNaissance($faker->dateTimeBetween('-100 days', '-1 days' , $timezone = null))
                ->setAdress($faker->address())
                ->setCodePostal($faker->postcode())
                ->setVilles($faker->city())
                ->setTelephone($faker->e164PhoneNumber())
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    'engagement'
                ));   
            // tell Doctrine you want to (eventually) save the Product (no queries yet)            
            $manager->persist($user);
            $users[] = $user;
            // actually executes the queries (i.e. the INSERT query)
            $manager->flush();


             // Utilisateurs admin
            $user = new User();
            $user->setEmail('voisinadmin'.$u.'@accote.com');
            $user->setFirstName($faker->firstName());
            $user->setRoles(['ROLE_ADMIN'])
                ->setAdress($faker->address())
                ->setCodePostal($faker->postcode())
                ->setVilles($faker->city())
                ->setName($faker->lastName())
                ->setDateNaissance($faker->dateTimeThisCentury('Y-m-d'))
                ->setTelephone($faker->e164PhoneNumber())
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    'engagement'
                ));

                 // tell Doctrine you want to (eventually) save the Product (no queries yet)            
            $manager->persist($user);
            // actually executes the queries (i.e. the INSERT query)
            $manager->flush();

               // Utilisateurs super admin
            $user = new User();
            $user->setEmail('voisinsuperadmin'.$u.'@accote.com');
            $user->setFirstName($faker->firstName());
            $user->setRoles(['ROLE_SUPER_ADMIN'])
                ->setAdress($faker->address())
                ->setCodePostal($faker->postcode())
                ->setVilles($faker->city())
                ->setName($faker->lastName())
                ->setDateNaissance($faker->dateTimeThisCentury('Y-m-d'))
                ->setTelephone($faker->e164PhoneNumber())
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    'engagement'
                ));
                    // tell Doctrine you want to (eventually) save the Product (no queries yet)            
            $manager->persist($user);
            // actually executes the queries (i.e. the INSERT query)
            $manager->flush();
        }

        // $product = new Product();
        // $manager->persist($product);
        //Creer 3 categorie
        for ($i = 1; $i <= 4; $i++) {
            $category = new Categorie();
            $category->setNomCategorie($faker->sentence())
                    ->setDescriptionCategorie($faker->paragraph());


            $manager->persist($category);

            for ($j = 1; $j <= mt_rand(4, 15); $j++) {
                
                $annonce = new Annonce();
                $annonce->setAnnonceTitle($faker->sentence())
                        ->setAnnoncePicture("https://placehold.it/400x350")
                        ->setBudget($faker->mt_rand(40, 200))
                        ->setAnnonceDescription($faker->paragraph())
                        ->setAdress($faker->address())
                        ->setPostalCode($faker->postcode())
                        ->setCity($faker->city())
                        ->setCategorys($category)
                        ->setUsers($faker->randomElement($users));
                        
                $manager->persist($annonce);

                // on donne des commentaires à l'article
                for ($k = 1; $k <= mt_rand(4, 6); $k++) {

                    $comment = new Comment();
                    $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';
                    
                    $days = (new \DateTime())->diff($annonce->getCreaTedAt())->days;

                    $comment->setAuthor($faker->name)
                            ->setContent($content)
                            
                            ->setArticle($annonce);

                $manager->persist($comment);
                }

                for ($j = 1; $j <= 3; $j++) {
                    
                    $slider = new Slider();
                    $slider->setTitre($faker->sentence())
                            ->setImage("https://placehold.it/1920x500")
                            ->setUpdatedAt($faker->dateTimeBetween('-6 months'))
                            ->setDescription($faker->paragraph());
                            
                    $manager->persist($slider); 
                }
                
                for ($j = 1; $j <= 3; $j++) {
                    
                    $quartier = new Quartier();
                    $quartier->setNomQuartier($faker->streetName());
                            //->setVilles($faker->city());
                            
                    $manager->persist($quartier); 
                }

                for ($j = 1; $j <= 3; $j++) {
                    
                    $ville = new Ville();
                    $ville->setVille($faker->city());
                            
                    $manager->persist($ville); 
                }
            }
        }




    $manager->flush();
    }
}
