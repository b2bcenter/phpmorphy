<?php
/*
* This file is part of phpMorphy project
*
* Copyright (c) 2007-2012 Kamaev Vladimir <heromantor@users.sourceforge.net>
*
*     This library is free software; you can redistribute it and/or
* modify it under the terms of the GNU Lesser General Public
* License as published by the Free Software Foundation; either
* version 2 of the License, or (at your option) any later version.
*
*     This library is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
* Lesser General Public License for more details.
*
*     You should have received a copy of the GNU Lesser General Public
* License along with this library; if not, write to the
* Free Software Foundation, Inc., 59 Temple Place - Suite 330,
* Boston, MA 02111-1307, USA.
*/

class phpMorphy_Aot_Mwz_File {
    protected
        $mwz_path,
        $values = array();

    public function __construct($filePath) {
        $this->mwz_path = $filePath;
        $this->parseFile($filePath);
    }

    public function export() {
        return $this->values;
    }

    public function keyExists($key) {
        return array_key_exists($key, $this->values);
    }

    public function getValue($key) {
        if(!$this->keyExists($key)) {
            throw new phpMorphy_Aot_Mrd_Exception("Key $key not exists in mwz file '$this->mwz_path'");
        }

        return $this->values[$key];
    }

    public function getMrdPath() {
        return dirname($this->mwz_path) . DIRECTORY_SEPARATOR . $this->getValue('MRD_FILE');
    }

    public function getEncoding() {
        $lang = $this->getLanguage();

        if(false === ($default = $this->getEncodingForLang($lang))) {
            throw new phpMorphy_Aot_Mrd_Exception("Can`t determine encoding for '$lang' language");
        }

        return $default;
    }

    public function getLanguage() {
        return strtolower($this->getValue('LANG'));
    }

    public static function getEncodingForLang($lang) {
        switch(strtolower($lang)) {
            case 'russian':
                return 'windows-1251';
            case 'english':
                return 'windows-1250';
            case 'german':
                return 'windows-1252';
            default:
                return false;
        }
    }

    protected function parseFile($path) {
        try {
            $lines = iterator_to_array($this->openFile($path));
        } catch (Exception $e) {
            throw new phpMorphy_Aot_Mrd_Exception("Can`t open $path mwz file '$path': " . $e->getMessage());
        }

        foreach(array_map('trim', $lines) as $line) {
            $pos = strcspn($line, " \t");

            if($pos !== strlen($line)) {
                $key = trim(substr($line, 0, $pos));
                $value = trim(substr($line, $pos + 1));

                if(strlen($key)) {
                    $this->values[$key] = $value;
                }
            } elseif(strlen($line)) {
                $this->values[$line] = null;
            }
        }
    }

    protected function openFile($file) {
        return new SplFileObject($file);
    }
}