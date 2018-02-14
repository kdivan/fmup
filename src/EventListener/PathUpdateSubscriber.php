<?php
namespace App\EventListener;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Events;

/**
 * Class PathUpdateSubscriber
 *
 * @package App\EventListener
 */
class PathUpdateSubscriber  implements EventSubscriber
{
    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
        ];
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postPersist(LifecycleEventArgs $eventArgs)
    {
        $this->createPath($eventArgs);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function postUpdate(LifecycleEventArgs $eventArgs)
    {
        $this->updatePath($eventArgs);
    }

    private function createPath(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof Category) {
            $entityManager = $args->getObjectManager();
            $entity->setPath($this->getPath($entity));
            $entityManager->persist($entity);
            $entityManager->flush();
        }
    }

    private function updatePath(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();
        if ($entity instanceof Category) {
            $entityManager = $args->getObjectManager();
            /** @var CategoryRepository $categoryRepository */
            $categoryRepository = $entityManager->getRepository('App:Category');
            $entity->setPath($this->getPath($entity));
            $entityManager->persist($entity);
            $entityManager->flush();
            //Had to use childrenHierarchy do this for memory trouble
            $this->updatePathInHierarchy($categoryRepository->childrenHierarchy($entity), $entityManager);
        }
    }

    private function getPath(Category $category, $path = [])
    {
        $path[] = $category->getName();
        if ($category->getParent()) {
            return $this->getPath($category->getParent(), $path);
        }

        return implode('\\', array_reverse($path));
    }

    private function updatePathInHierarchy(array $hierarchy, ObjectManager $entityManager)
    {
        foreach ($hierarchy as $child) {
            $categoryRepository = $entityManager->getRepository('App:Category');
            $childEntity = $categoryRepository->findOneBy(["name" => $child['name']]);
            $childEntity->setPath($this->getPath($childEntity));
            $entityManager->persist($childEntity);
            $entityManager->flush();
            if (!empty($child['__children'])) {
                return $this->updatePathInHierarchy($child['__children'], $entityManager);
            }
        }
    }
}

