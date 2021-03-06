<?php

namespace Jasny\DB\Entity\ChangeAware;

use SebastianBergmann\Comparator\Factory as ComparatorFactory,
    SebastianBergmann\Comparator\ComparisonFailure;

/**
 * Implementation for change aware entities.
 * 
 * @author  Arnold Daniels <arnold@jasny.net>
 * @license https://raw.github.com/jasny/db-mongo/master/LICENSE MIT
 * @link    https://jasny.github.io/db-mongo
 */
trait Implementation
{
    /**
     * @var array
     */
    private $persistedData__;

    /**
     * Set the current data as persisted data
     */
    protected function markAsPersisted()
    {
        $this->persistedData__ = $this->toData();
    }
    
    
    /**
     * Check if the entity is new
     * 
     * @return boolean
     */
    public function isNew()
    {
        return !isset($this->persistedData__);
    }
    
    /**
     * Check if the entity is modified
     * 
     * @return boolean
     */
    public function isModified()
    {
        return $this->hasModified($this);
    }
    
    /**
     * Check if a property has changed
     * 
     * @param string $property
     * @return boolean
     */
    public function hasModified($property)
    {
        if ($property === $this) {
            $original = $this->persistedData__;
            $current = $this->toData();
        } else {
            $persisted = static::fromData($this->persistedData__);

            $original = isset($persisted->$property) ? $persisted->$property : null;
            $current = isset($this->$property) ? $this->$property : null;
        }
        
        if ($original === $current) return false;
        
        $factory = new ComparatorFactory();
        $comparator = $factory->getComparatorFor($original, $current);
        
        try {
            $comparator->assertEquals($original, $current);
        } catch (ComparisonFailure $failure) {
            return true;
        }
        
        return false;        
    }
}
