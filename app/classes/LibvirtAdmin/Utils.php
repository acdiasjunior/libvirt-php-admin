<?php

/**
 * Description of Utils
 *
 * @author juniordias
 */

namespace LibvirtAdmin;

class Utils
{
    /*
     * Função converter XML do Libvirt em Array
     * @author Ramiro Varandas Jr. (https://github.com/ramirovjr)
     * @return Array Retorna array com os itens do xml
     */

    public static function xmlToArray($xml)
    {
        $_xml = simplexml_load_string($xml);
        $tags = array('bios' => 'BIOS', 'system' => 'Sistema', 'processor' => 'Processador', 'memory_device' => 'Memória');
        $array = array();

        foreach ($tags as $tag => $name) {
            $i = 0;
            foreach ($_xml->$tag as $entry) {
                foreach ($entry as $val) {
                    $attr = $val->attributes();
                    if (in_array($tag, array('processor', 'memory_device'))) {
                        $array[$name][$i][(string) ucfirst($attr['name'])] = trim((string) $val);
                    } else {
                        $array[$name][(string) ucfirst($attr['name'])] = trim((string) $val);
                    }
                }
                $i++;
            }
        }

        return $array;
    }

}
