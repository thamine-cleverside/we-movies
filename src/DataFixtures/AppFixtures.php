<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Factory\GenderFactory;
use App\Factory\MovieFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $comedie = GenderFactory::createOne(['title' => 'Comedie']);
        $aventure = GenderFactory::createOne(['title' => 'Aventure']);
        $fantastique = GenderFactory::createOne(['title' => 'Fantastique']);
        $animation = GenderFactory::createOne(['title' => 'Animation']);
        $action = GenderFactory::createOne(['title' => 'Action']);

        MovieFactory::createMany(10, ['gender' => [$comedie]]);
        MovieFactory::createMany(5, ['gender' => [$aventure]]);
        MovieFactory::createMany(2, ['gender' => [$fantastique]]);
        MovieFactory::createMany(5, ['gender' => [$animation]]);
        MovieFactory::createMany(7, ['gender' => [$action]]);
        MovieFactory::createMany(8, ['gender' => [$action, $comedie]]);

        $manager->flush();
    }
}
