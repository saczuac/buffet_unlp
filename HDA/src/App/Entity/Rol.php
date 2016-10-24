<?php 
namespace App\Entity;

use App\Entity;
use Doctrine\ORM\Mapping;

/**
 *
 * @Entity
 * @Table(name="rol")
 */
class Rol
{
	/**
     * @var integer
     *
     * @Id
     * @Column(name="id_rol", type="integer")
     * @GeneratedValue(strategy="AUTO")
     * @OneToMany(targetEntity="User", mappedBy="rol")
     */
	protected $id_rol;

	/**
     * @var string
     * @Column(type="string", length=25)
     */
	protected $nombre;
}

?>