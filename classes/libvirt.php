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
        try {
            $this->_conn = libvirt_connect($this->_uri, false);
            if ($this->_conn === false) {
                throw new Exception("Erro!");
            }
        } catch (Exception $e) {
            echo "Erro ao conectar ao libvirt: ", $e->getMessage(), "<br />\n";
            echo "Erro informado: " . libvirt_get_last_error() . "<br />\n";
        }
    }

    public function isConnected()
    {
        if ($this->_conn === false) {
            return false;
        }
        return true;
    }

    public function getHostName()
    {
        if ($this->isConnected()) {
            return libvirt_connect_get_hostname($this->_conn);
        } else {
            return "Não conectado!";
        }
    }

    public function getDomainsActives()
    {
        $domains = array();
        if ($this->isConnected()) {
            foreach (libvirt_list_active_domains($this->_conn) as $dom) {
                $d = new Domain($dom, $this->_conn, true);
                $domains[] = $d;
            }
            return $domains;
        } else {
            return array();
        }
    }

    public function getDomainsInactives()
    {
        $domains = array();
        if ($this->isConnected()) {
            foreach (libvirt_list_inactive_domains($this->_conn) as $dom) {
                $d = new Domain($dom, $this->_conn, false);
                $domains[] = $d;
            }
            return $domains;
        } else {
            return array();
        }
    }

}
