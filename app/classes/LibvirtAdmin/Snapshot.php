<?php

/**
 * Snapshot Class used for creating, getting information and dropping snapshots of a vm
 *
 * @author Junior
 */

namespace LibvirtAdmin;

class Snapshot
{

    private $_name;

    public function __construct()
    {
        // todo code
    }

    public function getName()
    {
        return $this->_name;
    }

}