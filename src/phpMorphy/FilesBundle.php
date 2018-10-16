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

class phpMorphy_FilesBundle {
    protected
        /** @var string */
        $dir,
        /** @var string */
        $lang;

    /**
     * @param string $dirName
     * @param string $lang
     */
    public function __construct($dirName, $lang) {
        $this->dir = rtrim($dirName, "\\/" . DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $this->setLang($lang);
    }

    /**
     * @return string
     */
    public function getDirectory() {
        return $this->dir;
    }

    /**
     * @return string
     */
    public function getLang() {
        return $this->lang;
    }

    /**
     * @param string $lang
     * @return void
     */
    public function setLang($lang) {
        //$this->lang = $GLOBALS['__phpmorphy_strtolower']($lang);
        $this->lang = strtolower($lang);
    }

    /**
     * @return string
     */
    public function getCommonAutomatFile() {
        return $this->genFileName('common_aut');
    }

    /**
     * @return string
     */
    public function getPredictAutomatFile() {
        return $this->genFileName('predict_aut');
    }

    /**
     * @return string
     */
    public function getGramInfoFile() {
        return $this->genFileName('morph_data');
    }

    /**
     * @return string
     */
    public function getGramInfoAncodesCacheFile() {
        return $this->genFileName('morph_data_ancodes_cache');
    }

    /**
     * @return string
     */
    public function getAncodesMapFile() {
        return $this->genFileName('morph_data_ancodes_map');
    }

    /**
     * @return string
     */
    public function getGramTabFile() {
        return $this->genFileName('gramtab');
    }

    /**
     * @return string
     */
    public function getGramTabFileWithTextIds() {
        return $this->genFileName('gramtab_txt');
    }

    /**
     * @param string $type
     * @return string
     */
    public function getDbaFile($type) {
        if(!isset($type)) {
            $type = 'db3';
        }

        return $this->genFileName("common_dict_$type");
    }

    /**
     * @return string
     */
    public function getGramInfoHeaderCacheFile() {
        return $this->genFileName('morph_data_header_cache');
    }

    /**
     * @param string $token
     * @param string|null $extraExt
     * @return string
     */
    protected function genFileName($token, $extraExt = null) {
        return $this->dir . $token . '.' . $this->lang . (isset($extraExt) ? '.' . $extraExt : '') . '.bin';
    }
}