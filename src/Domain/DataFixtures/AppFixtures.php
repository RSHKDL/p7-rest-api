<?php

namespace App\Domain\DataFixtures;
use App\Domain\Entity\Manufacturer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Yaml;

/**
 * Class AppFixtures
 *
 * @author ereshkidal
 */
class AppFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $manufacturers = $this->loadDataFixtures('manufacturer');

        foreach ($manufacturers as $name => $manufacturer) {
            $manufacturerEntity = new Manufacturer(
                $manufacturer['name']
            );
            $manager->persist($manufacturerEntity);
            $this->addReference($name, $manufacturerEntity);
        }
        $manager->flush();
    }

    /**
     * @param $entityName
     * @return array
     */
    private function loadDataFixtures($entityName): array
    {
        return Yaml::parse(file_get_contents(__DIR__.'/Fixtures/'. $entityName .'.yaml', true));
    }
}
