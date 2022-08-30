<?php

namespace App\Data;

use App\Entity\Campus;


/*
 * DTO
 * Création d'un datamodel qui va permettre de représenter les données associées au formulaire de recherche
 */
class SearchData
{
    /**
     * @var string
     */
    public $q ='';

    /**
     * @var Campus
     */
    public $campus;

    /**
     * @var null|integer
     */
    public $nombreMaxInscriptions;

    /**
     * @var null|integer
     */
    public $nombreMinInscriptions;

    /**
     * @var boolean
     */
    public $isInscrit=false;

}