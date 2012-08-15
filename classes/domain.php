<?php

/**
 * Description of domain
 *
 * @author Junior
 */
class Domain
{

    private $_name;
    private $_res;
    private $_is_active;
    private $_snapshots;
    private $_conn;

    public function __construct($name, $conn, $is_active = false)
    {
        $this->_name = $name;
        $this->_conn = $conn;
        $this->_is_active = $is_active;
        $this->_snapshots = $this->getSnapshots();
        $this->_res = $this->getResource();
    }

    public function getName()
    {
        return $this->_name;
    }

    public function isActive()
    {
        return $this->_is_active;
    }

    public function listSnapshots()
    {
        return $this->_snapshots;
    }

    private function getSnapshots()
    {
        return libvirt_list_domain_snapshots($this->getResource($this->_name));
    }

    private function getResource()
    {
        return libvirt_domain_lookup_by_name($this->_conn, $this->_name);
    }

    public function createSnapshot()
    {
        return libvirt_domain_snapshot_create($this->_res);
    }

}