<?php

namespace uploads\__CG__\Model\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Producto extends \Model\Entity\Producto implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', 'id', 'nombre', 'marca', 'stock', 'stock_minimo', 'proovedor', 'precio_venta_unitario', 'categoria_id', 'descripcion', 'fecha_alta', 'detalles', 'menus', 'detalles_prod'];
        }

        return ['__isInitialized__', 'id', 'nombre', 'marca', 'stock', 'stock_minimo', 'proovedor', 'precio_venta_unitario', 'categoria_id', 'descripcion', 'fecha_alta', 'detalles', 'menus', 'detalles_prod'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Producto $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getNombre()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNombre', []);

        return parent::getNombre();
    }

    /**
     * {@inheritDoc}
     */
    public function setNombre($nombre)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNombre', [$nombre]);

        return parent::setNombre($nombre);
    }

    /**
     * {@inheritDoc}
     */
    public function getMarca()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMarca', []);

        return parent::getMarca();
    }

    /**
     * {@inheritDoc}
     */
    public function setMarca($marca)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMarca', [$marca]);

        return parent::setMarca($marca);
    }

    /**
     * {@inheritDoc}
     */
    public function getStock()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStock', []);

        return parent::getStock();
    }

    /**
     * {@inheritDoc}
     */
    public function setStock($stock)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStock', [$stock]);

        return parent::setStock($stock);
    }

    /**
     * {@inheritDoc}
     */
    public function getStock_Minimo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getStock_Minimo', []);

        return parent::getStock_Minimo();
    }

    /**
     * {@inheritDoc}
     */
    public function setStock_Minimo($stock_minimo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setStock_Minimo', [$stock_minimo]);

        return parent::setStock_Minimo($stock_minimo);
    }

    /**
     * {@inheritDoc}
     */
    public function getProovedor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getProovedor', []);

        return parent::getProovedor();
    }

    /**
     * {@inheritDoc}
     */
    public function setProovedor($proovedor)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setProovedor', [$proovedor]);

        return parent::setProovedor($proovedor);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrecio_Venta_Unitario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPrecio_Venta_Unitario', []);

        return parent::getPrecio_Venta_Unitario();
    }

    /**
     * {@inheritDoc}
     */
    public function setPrecio_Venta_Unitario($precio_venta_unitario)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPrecio_Venta_Unitario', [$precio_venta_unitario]);

        return parent::setPrecio_Venta_Unitario($precio_venta_unitario);
    }

    /**
     * {@inheritDoc}
     */
    public function getCategoria_Id()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCategoria_Id', []);

        return parent::getCategoria_Id();
    }

    /**
     * {@inheritDoc}
     */
    public function setCategoria_Id($categoria_id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCategoria_Id', [$categoria_id]);

        return parent::setCategoria_Id($categoria_id);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescripcion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescripcion', []);

        return parent::getDescripcion();
    }

    /**
     * {@inheritDoc}
     */
    public function setDescripcion($descripcion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescripcion', [$descripcion]);

        return parent::setDescripcion($descripcion);
    }

    /**
     * {@inheritDoc}
     */
    public function getFecha_Alta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFecha_Alta', []);

        return parent::getFecha_Alta();
    }

    /**
     * {@inheritDoc}
     */
    public function setFecha_Alta($fecha_alta)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFecha_Alta', [$fecha_alta]);

        return parent::setFecha_Alta($fecha_alta);
    }

    /**
     * {@inheritDoc}
     */
    public function setFecha()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFecha', []);

        return parent::setFecha();
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'jsonSerialize', []);

        return parent::jsonSerialize();
    }

    /**
     * {@inheritDoc}
     */
    public function ingresa($cantidad)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'ingresa', [$cantidad]);

        return parent::ingresa($cantidad);
    }

    /**
     * {@inheritDoc}
     */
    public function saca($cantidad)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'saca', [$cantidad]);

        return parent::saca($cantidad);
    }

}
