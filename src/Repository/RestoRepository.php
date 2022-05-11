<?php

namespace App\Repository;

use App\Entity\Plat;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;


class RestoRepository extends EntityRepository {
    
    public function getRestosByUserID($userID){
        $dql = "SELECT resto FROM App:Resto resto JOIN resto.unRestaurateur restaurateur WHERE restaurateur.id LIKE :userID";
        $req = $this->getEntityManager()->createQuery($dql);
        $req->setParameter(":userID", $userID);
        return $req->getResult();
    }

}
