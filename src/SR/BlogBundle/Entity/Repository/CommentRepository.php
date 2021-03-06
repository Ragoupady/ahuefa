<?php

namespace SR\BlogBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{

	public function getPostNewsComments($id)  // methode utilisée pour récupérer les commentaires d'une News
	{
		$qb = $this->createQueryBuilder('c')
				  ->orderBy('c.postDate', 'DESC')
				  ->where('c.news=:id')
				  ->setParameter('id', $id);

		$result = $qb->getQuery()->getResult();

		return $result;



	}

	public function getPostEventComments($id)  // methode utilisée pour récupérer les commentaires d'une Event
	{
		$qb = $this->createQueryBuilder('c')
				  ->orderBy('c.postDate', 'DESC')
				  ->where('c.event=:id')
				  ->setParameter('id', $id);

		$result = $qb->getQuery()->getResult();

		

		return $result;



	}


}
