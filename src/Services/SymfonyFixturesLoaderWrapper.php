<?php

namespace Liip\FunctionalTestBundle\Services;

use Doctrine\Bundle\FixturesBundle\Loader\SymfonyFixturesLoader;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;

class SymfonyFixturesLoaderWrapper extends Loader
{
    private $symfonyFixturesLoader;

    private $loadedFixtures = [];

    public function __construct(SymfonyFixturesLoader $symfonyFixturesLoader)
    {
        $this->symfonyFixturesLoader = $symfonyFixturesLoader;
    }

    public function loadFixturesClass($className)
    {
        $this->addFixture($this->symfonyFixturesLoader->getFixture($className));
    }

    public function addFixture(FixtureInterface $fixture)
    {
        $class = get_class($fixture);
        if (!isset($this->loadedFixtures[$class])) {
            $this->loadedFixtures[$class] = $fixture;
        }

        parent::addFixture($fixture);
    }

    public function createFixture($class)
    {
        return $this->symfonyFixturesLoader->getFixture($class);
    }

    public function getFixtures()
    {
        return $this->loadedFixtures;
    }
}
