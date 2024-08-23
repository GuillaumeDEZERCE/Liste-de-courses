<?php

namespace App\DataFixtures;

use App\Entity\Item;
use App\Entity\ShoppingList;
use App\Entity\User;
use App\Entity\UserShoppingList;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private $connection;

    /**
    * Constructor
    */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    private function truncate()
    {
        $this->connection->executeQuery('SET foreign_key_checks = 0');
        // Truncate
        $this->connection->executeQuery('TRUNCATE TABLE item');
        $this->connection->executeQuery('TRUNCATE TABLE shopping_list');
        $this->connection->executeQuery('TRUNCATE TABLE user');
        $this->connection->executeQuery('TRUNCATE TABLE user_shopping_list');
        
    }

    public function load(ObjectManager $manager): void
    {
        // Truncate tables
        $this->truncate();

        // Faker instance
        $faker = Factory::create();

        //User fixtures
        $users = [];
        for ($i=0; $i < 20; $i++) { 
            
            // Create my User object
            $user = new User();
            // Set its parameters
            $user->setEmail($faker->unique()->safeEmail());
            $user->setLogin($faker->unique()->name());
            $user->setPassword(password_hash($user->getLogin(),PASSWORD_DEFAULT));
            $user->setPicture("https://picsum.photos/id/".mt_rand(1,180)."/300/500");
            $user->setCreatedAt(new DateTimeImmutable($faker->date()));
            $user->setRoles(['ROLE_USER']);
            
            // Add the user to the array
            $users[] = $user;
            
            // Persist
            $manager->persist($user);
        }

        // Admin Fixture
        $admin = $users[0];
        $admin->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $manager->persist($admin);

        // Shopping list Fixtures
        $shoppingLists = [];
        for ($g=0; $g < 10; $g++) {
            // Create a new Shopping List object
            $shoppingList = new ShoppingList();
            // Assign values to properties
            $shoppingList->setName($faker->sentence(3));
            $shoppingList->setCreatedAt(new DateTimeImmutable($faker->date()));
            
            // Item Fixtures
            for ($i=0; $i < mt_rand(1, 10); $i++) {
                // Create a new Item object
                $item = new Item();
                // Assign values to properties
                $item->setName($faker->sentence(3));
                $item->setShoppingList($shoppingList);
                
                // Persist
                $manager->persist($item);
            }
            
            // Add the shopping list to the $shoppingLists array
            $shoppingLists[] = $shoppingList;

            // Persist
            $manager->persist($shoppingList);
        }

        // Associate each shopping list with an user
        $userShoppingLists = [];

        foreach ($users as $user) {
            // Create a new UserShoppingList object
            $userShoppingList = new UserShoppingList();
            // Assign values to properties
            $userShoppingList->setUser($user);
            $userShoppingList->setShoppingList($shoppingLists[mt_rand(1, count($shoppingLists) - 1)]);

            // Add the user shopping list to the $userShoppingLists array
            $userShoppingLists[] = $userShoppingList;

            // Persist
            $manager->persist($userShoppingList);
        }

        $manager->flush();
    }
}
