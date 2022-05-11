<?php

namespace App\Repository;

use App\Entity\Plat;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;



/**
 *
 * @author etcheparebordei
 */
class PlatRepository extends EntityRepository{
    
    public function search(?string $nomPlat, ?string $nomVille, ?string $nomTypePlat, ?int $minPrice, ?int $maxPrice) {
        $dql = "SELECT plat FROM App:Plat plat "
                . "JOIN plat.leTypePlat type "
                . "JOIN plat.leResto resto "
                . "WHERE plat.platVisible=true ";
        
        if(isset($nomPlat)){
            $dql = $dql. "AND plat.nomP LIKE :nomPlat ";
        }
        if(isset($nomTypePlat)){
            $dql =  $dql. "AND type.libelleType LIKE :nomTypePlat ";
        }
        if(isset($nomVille)){
            $dql =  $dql. "AND resto.villeR LIKE :nomVille ";
        }
        
        if(isset($minPrice)){
            $dql = $dql. "AND plat.prixClientP >= :minPrice ";
        }
        
        if(isset($maxPrice)){
            $dql =  $dql. "AND plat.prixClientP <= :maxPrice ";
        }
        
        $req = $this->getEntityManager()->createQuery($dql);
        
        if(isset($nomPlat)){
            $req->setParameter(":nomPlat", "%$nomPlat%");
        }
        if(isset($nomTypePlat)){
            $req->setParameter(":nomTypePlat", "%$nomTypePlat%");
        }
        if(isset($nomVille)){
            $req->setParameter(":nomVille", "%$nomVille%");
        }
        if(isset($minPrice)){
            $req->setParameter(":minPrice", $minPrice);
        }
        if(isset($maxPrice)){
            $req->setParameter(":maxPrice", $maxPrice);
        }
        
        return $req->getResult();
    }
    
    
//    public function searchByPlat($nomPlat){
//        $dql = "SELECT plat FROM App:Plat plat WHERE plat.nomP LIKE :nomPlat";
//        $req = $this->getEntityManager()->createQuery($dql);
//        $req->setParameter(":nomPlat", "%$nomPlat%");
//        return $req->getResult();
//    }
//    
//    public function searchByVille($nomVille){
//        $dql = "SELECT plat FROM App:Plat plat JOIN plat.leResto resto WHERE resto.villeR LIKE :nomVille";
//        $req = $this->getEntityManager()->createQuery($dql);
//        $req->setParameter(":nomVille", "%$nomVille%");
//        return $req->getResult();
//    }
//    
//    public function searchByTypePlat($nomTypePlat){
//        $dql = "SELECT plat FROM App:Plat plat JOIN plat.leTypePlat type WHERE type.libelleType LIKE :nomTypePlat";
//        $req = $this->getEntityManager()->createQuery($dql);
//        $req->setParameter(":nomTypePlat", "%$nomTypePlat%");
//        return $req->getResult();
//    }
//    
//    public function searchByPlatAndVille() {
//        
//    }
//    
//    public function searchByPlatAndVilleAndType(){
//        
//    }
//   
//    public function searcByPlatAndType() {
//        
//    }
    
    
}
