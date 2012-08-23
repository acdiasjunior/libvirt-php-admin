<?php

/*
 * Classe utilizada para conexão ao libVirt
 * @author Antonio Carlos (acdiasjunior@gmail.com)
 * @copyright GPL
 * @version 1.0 (15/08/2012)
 */

namespace LibvirtAdmin;

class Host
{
    /*
     * Classe utilizada para conexão ao libvirt
     * @author Antonio Carlos (acdiasjunior@gmail.com)
     * @copyright GPL
     * @version 1.0 (15/08/2012)
     */

    /*
     * Declaração das variáveis (propriedades) da classe
     */

    private $_lib; // Instancia da Classe de conexao Libvirt

    public function __construct()
    {
        $this->_lib = new \LibvirtAdmin\Libvirt();
    }

    public function getConnection()
    {
        return $this->_lib->getConnection();
    }

    public function getHostName()
    {
        return libvirt_connect_get_hostname($this->getConnection());
    }

    public function getDomain($domain)
    {
        return new \LibvirtAdmin\Domain($domain, $this->getConnection());
    }

    public function getDomainsActives()
    {
        $domains = array();
        foreach (libvirt_list_active_domains($this->getConnection()) as $dom) {
            $d = new \LibvirtAdmin\Domain($dom, $this->getConnection());
            $domains[] = $d;
        }
        return $domains;
    }

    public function getDomainsInactives()
    {
        $domains = array();
        foreach (libvirt_list_inactive_domains($this->getConnection()) as $dom) {
            $d = new \LibvirtAdmin\Domain($dom, $this->getConnection());
            $domains[] = $d;
        }
        return $domains;
    }

    public function getSysInfo()
    {
        $xml = libvirt_connect_get_sysinfo($this->getConnection());
        return \LibvirtAdmin\Utils::xmlToArray($xml);
    }

}
