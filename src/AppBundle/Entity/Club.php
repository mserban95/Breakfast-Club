<?php
// src/AppBundle/Entity/Club.php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="club")
 */
class Club
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique = true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $sdate;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $fdate;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $username
     */
    public function setUsernames($username)
    {
        $this->username = $username;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getUsernames()
    {
        return $this->username;
    }



    /**
     * @param mixed $sdate
     */
    public function setSdates($sdate)
    {
        $this->sdate = $sdate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSdates()
    {
        return $this->sdate;
    }

    /**
     * @param mixed $fdate
     */
    public function setFdates($fdate)
    {
        $this->fdate = $fdate;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFdates()
    {
        return $this->fdate;
    }

    /**
     * @return mixed
     */
    public function getStatuss()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatuss($status)
    {
        $this->status = $status;

        return $this;
    }




}
