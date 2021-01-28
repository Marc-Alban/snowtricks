<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Video;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {

        $categorys =
            [
                [
                    'name' => 'grab',
                ],
                [
                    'name' => 'rotation',
                ],
                [
                    'name' => 'flip',
                ],
                [
                    'name' => 'slide',
                ],
                [
                    'name' => 'one foot',
                ],
                [
                    'name' => 'old school',
                ],
                [
                    'name' => 'rotation désaxée',
                ]
            ];

        //Create Category
        foreach($categorys as $i){
            $category = (new Category());
            $category->setName($i['name']);
            $manager->persist($category);
        }
        $manager->flush();


        //Create User
        $user = (new User());
        $user->setUsername('Marc-Alban')
            ->setPassword('@dmIn123')
            ->setEmail('millet.marcalban@gmail.com')
            ->setPhoto('jimmy-avatar.jpg')
            ->setActivated('1')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $manager->persist($user);
        $manager->flush();


        //Image
        $images =
            [
                [
                    'content' => '50-50.jpg',
                ],
                [
                    'content' => 'flip.jpg',
                ],
                [
                    'content' => 'backside_air.jpg',
                ],
                [
                    'content' => 'frontsite.jpg',
                ],
                [
                    'content' => 'doubleback.jpg',
                ],
                [
                    'content' => 'Front_Bluntslide.jpg',
                ],
                [
                    'content' => 'japan.jpg',
                ],
                [
                    'content' => 'methode_air.jpg',
                ],
                [
                    'content' => 'nose_grab.jpg',
                ],
                [
                    'content' => 'Tail_grab.jpg',
                ]
            ];
        foreach ($images as $img){
            $image = (new Image())
                ->setContent($img['content']);
            $manager->persist($image);
        }
        $manager->flush();

        //Video

        //Image
        $videos =
            [
                [
                    'address' => 'https://www.youtube.com/embed/_hxLS2ErMiY',
                ],
                [
                    'address' => 'https://www.youtube.com/embed/_Qq-YoXwNQY',
                ],                [
                    'address' => 'https://www.youtube.com/embed/ZlNmeM1XdM4',
                ],                [
                    'address' => 'https://www.youtube.com/embed/CzDjM7h_Fwo',
                ],                [
                    'address' => 'https://www.youtube.com/embed/9T5AWWDxYM4',
                ],                [
                    'address' => 'https://www.youtube.com/embed/SLncsNaU6es',
                ],               [
                    'address' => 'https://www.youtube.com/embed/_CN_yyEn78M',
                ],              [
                    'address' => 'https://www.youtube.com/embed/12OHPNTeoRs',
                ],              [
                    'address' => 'https://www.youtube.com/embed/kxZbQGjSg4w',
                ],              [
                    'address' => 'https://www.youtube.com/embed/O5DpwZjCsgA',
                ],              [
                    'address' => 'https://www.youtube.com/embed/id8VKl9RVQw',
                ],

            ];
        foreach ($videos as $url){
            $video = (new Video())
                ->setAddress($url['address']);
            $manager->persist($video);
        }
        $manager->flush();


        //create Tricks
        $tricks = [
            [
                'title' => 'Tail grab',
                'description' => 'Si vous voulez faire un tail grab, cela est possible en snowboard par un mouvement d’assiette de la planche obtenu par une dysmétrie dans la montée des jambes.
        Le bras qui n’attrape pas sert de contre-balancier et il se place généralement à l’opposé de celui qui attrape.',
            ],
            [
                'title' => 'nose grab',
                'description' => 'saisie de la partie avant de la planche, avec la main avant',
            ],
            [
                'title' => 'double back flip',
                'description' => 'Le backflip figure parmi les sauts les plus spectaculaires de cette discipline. Il nécessite la maîtrise des fondamentaux et d’une bonne perception du corps. En effet, avoir la tête en bas, même pendant quelques secondes seulement, est très difficile pour les non-initiés. Heureusement, il est possible de s’entrainer sur un trampoline avant de transposer les mouvements sur les pistes.',
            ],
            [
                'title' => 'flip',
                'description' => 'Cette figure – qui consiste à attraper sa planche d\'une main et le tourner perpendiculairement au sol – est un classique "old school". Il n\'empêche qu\'il est indémodable, avec de vrais ambassadeurs comme Jamie Lynn ou la star Terje Haakonsen. En 2007, ce dernier a même battu le record du monde du "air" le plus haut en s\'élevant à 9,8 mètres au-dessus du kick (sommet d\'un mur d\'une rampe ou autre structure de saut).',
            ],
            [
                'title' => 'japan air',
                'description' => 'saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside',
            ],
            [
                'title' => 'frontsite 360',
                'description' => 'Le 3.6 front ou frontside 3 est un tricks intéressant car on peut y mettre facilement beaucoup de style. C’est une rotation de 360 degrés du côté frontside ( à gauche pour les regular et à droite pour les goofy). Comme le 3.6 back, la vitesse de rotation est assez facile à gérer, mais si l’impulsion parait plus évidente en lançant les épaules de face, l’atterrissage l\'est beaucoup moins car on est de dos le dernier quart du saut. On appelle ça une reception blind side…',
            ],
            [
                'title' => 'backside air',
                'description' => 'Mais en fait, pourquoi le Backside air est-il aussi emblématique? C’est vrai quoi, il existe des tricks bien plus compliqués que ça dans le snowboard moderne, d’autres aussi avec des noms bien plus amusants… Mais rappelle-toi: le backside air est le seul trick que tu ne peux pas faire en ski – déjà ça pose. Ensuite, c’est sans doute le trick qui marque le plus ta personnalité, car il y a 10.000 manières de le faire. Enfin, pour un trick “simple”, il est tout de même assez technique. Il faut l’envoyer en avançant le buste au pop, et vraiment s’engager dans les airs pour pouvoir bien grabber comme il se doit. Voilà à notre avis trois raisons majeures à ce succès du backside air, toutes générations et tous pratiquants confondus',
            ],
            [
                'title' => 'frontsite boardslide',
                'description' => 'Un slide est dit «board slide » lorsque le rider slide littéralement sur la board. Cela est simple à comprendre lorsque l’on connait le slide 50-50. En skateboard, le 50-50 signifie 50% sur le trucks arrière et 50% sur le trucks avant. Il en est de même en snowboard malgré l’absence de trucks.
        Le board slide est alors un slide sur le milieu de la board. Cela impose d’avoir la board à 90° par rapport au module (rail ou boxe), tout comme cela serait en skateboard.',
            ],
            [
                'title' => 'Front Bluntslide 270',
                'description' => 'Un slide où il faut faire passer le pied avant au-dessus du rail en arrivant, avec la board perpendiculaire au rail, et faire 3/4 d\'un tour sur le rail.',
            ],
            [
                'title' => '50-50',
                'description' => 'Un 50-50 consiste simplement à glisser le long d\'un élement, le contact entre la board et la cible s\'effectuant -en l\'occurrence- au niveau des deux axes (en même temps).',
            ],
        ];

        //Trick -----------------------------------------------------------------------------------
        foreach ($tricks as $row){
            $trick = (new Trick())
                ->setTitle($row['title'])
                ->setDescription($row['description'])
                ->setCreated(new DateTime())
                ->setLastUpdate(new DateTime());
            $trick->setSlug($trick->getTitle())
                ->setCategory($category)
                ->setImage($image)
                ->setVideo($video);
            $manager->persist($trick);
        }
        $manager->flush();
        //End Trick ----------------------------------------------------------------------------------
   }
}
