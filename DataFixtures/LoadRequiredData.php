<?php

/*
 * This file is part of the Claroline Connect package.
 *
 * (c) Claroline Consortium <consortium@claroline.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Claroline\CursusBundle\DataFixtures;

use Claroline\FlashCardBundle\Entity\NoteType;
use Claroline\FlashCardBundle\Entity\FieldLabel;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadRequiredData extends AbstractFixture implements ContainerAwareInterface
{
    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $om)
    {
        $noteType = new NoteType();
        $noteType->setName("Basic");
        $om->persist($noteType);

        $frontField = new FieldLabel();
        $frontField->setName("Front");
        $frontField->setNoteType($noteType);
        $om->persist($frontField);
        $backField = new FieldLabel();
        $backField->setName("Back");
        $backField->setNoteType($noteType);
        $om->persist($backField);

        $cardType = new CardType();
        $cardType->setName("Forward");
        $cardType->setNoteType($noteType);
        $cardType->addQuestion($frontField);
        $cardType->addAnswer($backField);
        $om->persist($cardType);

        $om->flush();
    }
}
