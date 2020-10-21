<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeInterface;
use App\Entity\NewsEntity\Like;
use App\Entity\NewsEntity\Post;
use App\Entity\NewsEntity\Comment;
use App\Entity\NewsEntity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder=$encoder;
        
    }
    
    public function load(ObjectManager $manager)
    {
        $faker=\Faker\Factory::create('fr_FR');
        $category= new Category();
       
            $category->setTitle('Politique');
            $manager->persist($category);
            $category->setTitle('Sports et Loisirs');
            $manager->persist($category);
            $category->setTitle('Technologie');
            $manager->persist($category);

            

             for ($i=0; $i <12 ; $i++) { 
                    $post=new Post();
                  
                    $user=new User();
                    $like=new Like();
                    $post->setTitle($faker->sentence)
                         ->setDescription($faker->paragraph)
                         ->setImageName($faker->imageUrl())
                         ->setMediaSource('aucongo.news')
                         ->setVideoName($faker->imageUrl())
                         ->setPosted($faker->boolean)
                         ->addCategory($category);
                    $manager->persist($post);

                    // 2.LES LIKES
                    $like->setPost($post)
                         ->setLikeNumber($faker->numberBetween(0,100));
                      $manager->persist($like);

                      // 3.LES USERS
                    $user->setFirstname($faker->firstName)
                         ->setLastname($faker->lastName)
                         ->setEmail($faker->email)
                         ->setRoles(['ADMIN_USER'])
                         ->setLikedPost($like);
                    $pwdNoHash='097054@kota';
                    $pwdHashed=$this->encoder->encodePassword($user,$pwdNoHash);
                    $user->setPassword($pwdHashed)
                         ->addPost($post);
                    $manager->persist($user);

                      // 3.LES COMMENTAIRES
                         for ($j=0; $j <24 ; $j++) { 
                             $comment=new Comment();
                            $comment->setUser($user)
                                    ->setMessage($faker->sentence)
                                    ->setPost($post);
                            $manager->persist($comment);
                            


                         }

             }

        $manager->flush();
    }
}
