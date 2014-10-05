<?php

namespace Jasny\DB;

/**
 * Data Mapper interface when entities that can be restored after deletion.
 * 
 * @author  Arnold Daniels <arnold@jasny.net>
 * @license https://raw.github.com/jasny/db/master/LICENSE MIT
 * @link    https://jasny.github.com/db
 */
interface DataMapperSoftDeletion extends DataMapper, SoftDeletion
{
    /**
     * Checks if entity has been deleted
     * 
     * @return boolean
     */
    public static function isDeleted($entity);
    
    /**
     * Restore deleted entity.
     * Does nothing is entity isn't deleted.
     * 
     * @param 
     */
    public static function undelete($entity);
}
