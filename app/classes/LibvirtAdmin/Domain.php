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
    private $_snapshots;
    private $_conn;
    private $_memory_max;
    private $_memory;
    private $_cpu;
    private $_cpu_used;

    public function __construct($name, $conn)
    {
        $this->_name = $name;
        $this->_conn = $conn;
        $this->getInfo();
    }

    public function getName()
    {
        return $this->_name;
    }

    public function isActive()
    {
        return libvirt_domain_is_active($this->getResource());
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

    public function getResource()
    {
        if (!is_resource($this->_res)) {
            $this->_res = libvirt_domain_lookup_by_name($this->_conn, $this->_name);
        }

        if (is_resource($this->_res)) {
            return $this->_res;
        }

        throw new \Exception('Erro ao capturar Resource do dominio.<br />' . var_dump($this));
    }

    private function getInfo()
    {
        $this->_res = $this->getResource();
        $this->_snapshots = $this->getSnapshots();

        $info = libvirt_domain_get_info($this->getResource());

        $this->_memory_max = $info['maxMem'];
        $this->_memory = $info['memory'];
        $this->_cpu = $info['nrVirtCpu'];
        $this->_cpu_used = $info['cpuUsed'];
    }

    public function getMaxMemory()
    {
        return $this->_memory_max;
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

        throw new \Exception('Falha ao criar o snapshot!');
    }

    public function getDiskDevices()
    {
        return libvirt_domain_get_disk_devices($this->getResource());
    }

    public function getMemoryStats()
    {
        return libvirt_domain_memory_stats($this->getResource());
    }

    public function domainResume()
    {
        $cmd = sprintf('virsh start %s', $this->getName());
        exec($cmd, $saida, $ret);

        if ((int) $ret !== 0) {
            throw new \Exception('Erro ao startar o dominio:<br />' . print_r($saida, true) . '<br />' . $cmd);
        }
    }

//    libvirt_domain_new($conn, $name, $arch, $memMB, $maxmemMB, $vcpus, $iso_image, $disks, $networks, $flags)
//libvirt_domain_new_get_vnc($one)
//libvirt_domain_get_xml_desc($res, $xpath)
//libvirt_domain_get_disk_devices($res)
//libvirt_domain_get_interface_devices($res)
//libvirt_domain_change_vcpus($res, $numCpus)
//libvirt_domain_change_memory($res, $allocMem, $allocMax)
//libvirt_domain_change_boot_devices($res, $first, $second)
//libvirt_domain_disk_add($res, $img, $dev, $typ, $driver, $flags)
//libvirt_domain_disk_remove($res, $dev, $flags)
//libvirt_domain_nic_add($res, $mac, $network, $model, $flags)
//libvirt_domain_nic_remove($res, $dev, $flags)
//libvirt_domain_get_info($res)
//libvirt_domain_create($res)
//libvirt_domain_destroy($res)
//libvirt_domain_resume($res)
//libvirt_domain_core_dump($res)
//libvirt_domain_shutdown($res)
//ibvirt_domain_managedsave($res)
//libvirt_domain_suspend($res)
//libvirt_domain_undefine($res)
//libvirt_domain_reboot($res)
//libvirt_domain_define_xml($conn, $xml)
//libvirt_domain_create_xml($conn, $xml)
//libvirt_domain_memory_peek($res)
//libvirt_domain_memory_stats($res)
//libvirt_domain_update_device($res, $xml, $flags)
//libvirt_domain_block_stats($res, $path)
//libvirt_domain_get_network_info($res, $mac)
//libvirt_domain_get_block_info($res, $dev)
//libvirt_domain_xml_xpath($res, $xpath)
//libvirt_domain_interface_stats($res, $path)
//libvirt_domain_get_connect($res)
//libvirt_domain_migrate_to_uri($res, $dest_uri, $flags, $dname, $bandwidth)
//libvirt_domain_migrate($res, $dest_conn, $flags, $dname, $bandwidth)
//libvirt_domain_get_job_info($res)
//libvirt_domain_has_current_snapshot($res)
//libvirt_domain_snapshot_lookup_by_name($res, $name)
//libvirt_domain_snapshot_create($res)
//libvirt_domain_snapshot_get_xml($res)
//libvirt_domain_snapshot_revert($res)
//libvirt_domain_snapshot_delete($res, $flags)
}
