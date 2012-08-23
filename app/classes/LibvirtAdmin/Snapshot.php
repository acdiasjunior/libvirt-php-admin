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
    private $_domain;
    private $_res;

    public function __construct($name, $domain)
    {
        $this->_name = $name;
        $this->_domain = $domain;
        $this->_res = $this->getResource();
    }

    private function getResource()
    {
        if (!is_resource($this->_res)) {
            $this->_res = libvirt_domain_snapshot_lookup_by_name($this->_domain->getResource(), $this->_name);
        }

        if (is_resource($this->_res)) {
            return $this->_res;
        }

        throw new \Exception('Erro ao capturar Resource do snapshot.');
    }

    public function getName()
    {
        return $this->_name;
    }

    public function delete()
    {
        if (libvirt_domain_snapshot_delete($this->getResource(), 0)) {
            return 'Snapshot excluído com sucesso!';
        }

        throw new \Exception('Falha ao remover o snapshot!');
    }

    public function getXML()
    {
        return libvirt_domain_snapshot_get_xml($this->getResource());
    }

}