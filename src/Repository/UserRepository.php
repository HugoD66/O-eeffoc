<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getUserById(int $userId): ?User
    {
        return $this->findOneBy(['id' => $userId]);
    }
    public function convertUserInterfaceToUser(UserInterface $user): ?User
    {
        return $this->getUserById($user->getId());
    }


    public function save(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->save($user, true);
    }


    public function findByQuery(string $query): array
    {
        if (empty($query)) {
            return [];
        }

        return $this->createQueryBuilder('b')
            ->andWhere('b.username LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findFollowers(int $id): array
    {
        if (empty($id)) {
            return [];
        }
        return $this->createQueryBuilder('u')
            ->innerJoin('u.followedUsers', 's', 'WITH', 's.id = :followedUsers')
            ->setParameter('followedUsers', $id)
            ->getQuery()
            ->getResult()
            ;
    }
    public function findFollowings(int $id): array
    {
        if (empty($id)) {
            return [];
        }
        return $this->createQueryBuilder('u')
            ->innerJoin('u.followingUsers', 's', 'WITH', 's.id = :followingUsers')
            ->setParameter('followingUsers', $id)
            ->getQuery()
            ->getResult()
            ;
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
