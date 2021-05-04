<?php

namespace App\Repository;

use App\Model\Partner;
use App\Repository\Repository;

final class PartnerRepository extends Repository
{
    protected $table = 'partner';
    protected $class = Partner::class;

    public function findAll() : array 
    {
        return $this->queryAndFetchAll("SELECT * FROM {$this->table} ORDER BY name ASC");
    }

    public function insertPartner(Partner $partner) : void
    {
        $id = $this->insert([
            'name' => $partner->getName(),
            'slug' => $partner->getSlug(),
            'webSite' => $partner->getWebSite(),
            'street' => $partner->getStreet(),
            'city' => $partner->getCity(),
            'postalCode' => $partner->getPostalCode(),
            'image' => $partner->getImage(),
            'description' => $partner->getDescription(),
            'mapGoogle' => $partner->getMapGoogle()
        ]);
        $partner->setId($id);
    }

    public function updatePartner(Partner $partner) : void
    {
        $this->update([
            'name' => $partner->getName(),
            'slug' => $partner->getSlug(),
            'webSite' => $partner->getWebSite(),
            'street' => $partner->getStreet(),
            'city' => $partner->getCity(),
            'postalCode' => $partner->getPostalCode(),
            'image' => $partner->getImage(),
            'description' => $partner->getDescription(),
            'mapGoogle' => $partner->getMapGoogle()
        ], $partner->getID());
    }
}

?>