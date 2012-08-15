<?php

/*
 * Classe utilizada para conexão ao libVirt
 * @author Antonio Carlos (acdiasjunior@gmail.com)
 * @copyright GPL
 * @version 1.0 (15/08/2012)
 */

require_once 'domain.php';

class LibVirt
{
    /*
     * Classe utilizada para conexão ao libVirt
     * @author Antonio Carlos (acdiasjunior@gmail.com)
     * @copyright GPL
     * @version 1.0 (15/08/2012)
     */

    /*
     * Declaração das variáveis (propriedades) da classe
     */

    private $_uri = "qemu:///system"; // Caminhao para conexao libvirt
    private $_conn; // Resource de conexao libvirt

    public function connect()
    {
        /*
         * Função para conexão ao libvirt
         * @author Junior Dias (acdiasjunior@gmail.com)
         * @return Boolean Retorna true (conectado) ou false (nao conectado)
         */
        $this->_conn = libvirt_connect($this->_uri, false);
        if (!$this->isConnected()) {
            throw new Exception("Erro ao conectar: " . libvirt_get_last_error());
        }
    }

    public function isConnected()
    {
        return is_resource($this->_conn);
    }

    public function getHostName()
    {
        return libvirt_connect_get_hostname($this->getConnection());
    }

    public function getConnection()
    {
        if (!$this->isConnected()) {
            $this->connect();
        }

        if ($this->isConnected()) {
            return $this->_conn;
        }

        throw new Exception('Sem conexão ao libvirt');
    }

    public function getDomainsActives()
    {
        $domains = array();
        foreach (libvirt_list_active_domains($this->getConnection()) as $dom) {
            $d = new Domain($dom, $this->_conn, true);
            $domains[] = $d;
        }
        return $domains;
    }

    public function getDomainsInactives()
    {
        $domains = array();
        foreach (libvirt_list_inactive_domains($this->getConnection()) as $dom) {
            $d = new Domain($dom, $this->_conn, false);
            $domains[] = $d;
        }
        return $domains;
    }

}
