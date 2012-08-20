<?php

/**
 * Class used to define a vm
 *
 * @author Junior
 */

namespace LibvirtAdmin;

class Domain
{

    private $_name;
    private $_res;
    private $_is_active;
    private $_snapshots;
    private $_conn;
    private $_max_mem;
    private $_memory;
    private $_cpu;
    private $_cpu_used;

    public function __construct($name, $conn, $is_active = false)
    {
        $this->_name = $name;
        $this->_conn = $conn;
        $this->_is_active = $is_active;
        $this->_snapshots = $this->getSnapshots();
        $this->_res = $this->getResource();
        $this->getInfo();
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

    public function countSnapshots()
    {
        return count($this->listSnapshots());
    }

    private function getSnapshots()
    {
        return libvirt_list_domain_snapshots($this->getResource($this->_name));
    }

    private function getResource()
    {
        return libvirt_domain_lookup_by_name($this->_conn, $this->_name);
    }

    private function getInfo()
    {
        $info = libvirt_domain_get_info($this->getResource());
        $this->_max_mem = $info['maxMem'];
        $this->_memory = $info['memory'];
        $this->_cpu = $info['nrVirtCpu'];
        $this->_cpu_used = $info['cpuUsed'];
    }

    public function getMaxMemory()
    {
        return $this->_max_mem;
    }

    public function getMemory()
    {
        return $this->_memory;
    }

    public function getCpu()
    {
        return $this->_cpu;
    }

    public function getCpuUsage()
    {
        return $this->_cpu_used;
    }

    private function getSnapshot($snapshot)
    {
        return libvirt_domain_snapshot_lookup_by_name($this->getResource(), $snapshot);
    }

    public function createSnapshot()
    {
        $snapshot = libvirt_domain_snapshot_create($this->getResource());
        if (is_resource($snapshot)) {
            return 'Snapshot criado com sucesso!';
        }

        throw new Exception('Falha ao criar o snapshot!');
    }

    public function deleteSnapshot($snapshot)
    {
        if (libvirt_domain_snapshot_delete($this->getSnapshot($snapshot), 0)) {
            return 'Snapshot excluído com sucesso!';
        }

        throw new Exception('Falha ao remover o snapshot!');
    }

}
