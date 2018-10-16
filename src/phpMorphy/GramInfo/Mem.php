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

class phpMorphy_GramInfo_Mem extends phpMorphy_GramInfo_GramInfoAbstract {
    public function getGramInfoHeaderSize() {
        return 20;
    }

    public function readGramInfoHeader($offset) {
        $__mem = $this->resource;

        $result = unpack(
            'vid/vfreq/vforms_count/vpacked_forms_count/vancodes_count/vancodes_offset/vancodes_map_offset/vaffixes_offset/vaffixes_size/vbase_size',
            $GLOBALS['__phpmorphy_substr']($__mem, $offset, 20)        );

        $result['offset'] = $offset;

        return $result;
    }

    protected function readAncodesMap($info) {
        $__mem = $this->resource;

        // TODO: this can be wrong due to aligning ancodes map section
        $offset = $info['offset'] + 20 + $info['forms_count'] * 2;


        $forms_count = $info['packed_forms_count'];
        return unpack("v$forms_count",  $GLOBALS['__phpmorphy_substr']($__mem, $offset, $forms_count * 2));
    }

    protected function splitAncodes($ancodes, $map) {
        $result = array();
        for($i = 1, $c = count($map), $j = 1; $i <= $c; $i++) {
            $res = array();

            for($k = 0, $kc = $map[$i]; $k < $kc; $k++, $j++) {
                $res[] = $ancodes[$j];
            }

            $result[] = $res;
        }

        return $result;
    }

    public function readAncodes($info) {
        $__mem = $this->resource;

        // TODO: this can be wrong due to aligning ancodes section
        $offset = $info['offset'] + 20;


        $forms_count = $info['forms_count'];
        $ancodes = unpack("v$forms_count", $GLOBALS['__phpmorphy_substr']($__mem, $offset, $forms_count * 2));

        /*
        if(!$expand) {
            return $ancodes;
        }
        */

        $map = $this->readAncodesMap($info);

        return $this->splitAncodes($ancodes, $map);
    }

    public function readFlexiaData($info) {
        $__mem = $this->resource;

        $offset = $info['offset'] + 20;

        if(isset($info['affixes_offset'])) {
            $offset += $info['affixes_offset'];
        } else {
            $offset += $info['forms_count'] * 2 + $info['packed_forms_count'] * 2;
        }

                return explode($this->ends, $GLOBALS['__phpmorphy_substr']($__mem, $offset, $info['affixes_size'] - $this->ends_size));
    }

    public function readAllGramInfoOffsets() {
        return $this->readSectionIndex($this->header['flex_index_offset'], $this->header['flex_count']);
    }

    protected function readSectionIndex($offset, $count) {
        $__mem = $this->resource;


        return array_values(unpack("V$count", $GLOBALS['__phpmorphy_substr']($__mem, $offset, $count * 4)));
    }

    public function readAllFlexia() {
        $__mem = $this->resource;

        $result = array();

        $offset = $this->header['flex_offset'];

        foreach($this->readSectionIndexAsSize($this->header['flex_index_offset'], $this->header['flex_count'], $this->header['flex_size']) as $size) {
            $header = $this->readGramInfoHeader($offset);
            $affixes = $this->readFlexiaData($header);
            $ancodes = $this->readAncodes($header, true);

            $result[$header['id']] = array(
                'header' => $header,
                'affixes' => $affixes,
                'ancodes' => $ancodes
            );

            $offset += $size;
        }

        return $result;
    }

    public function readAllPartOfSpeech() {
        $__mem = $this->resource;

        $result = array();

        $offset = $this->header['poses_offset'];

        foreach($this->readSectionIndexAsSize($this->header['poses_index_offset'], $this->header['poses_count'], $this->header['poses_size']) as $size) {

            $res = unpack(
                'vid/Cis_predict',
                $GLOBALS['__phpmorphy_substr']($__mem, $offset, 3)            );

            $result[$res['id']] = array(
                'is_predict' => (bool)$res['is_predict'],
                'name' => $this->cleanupCString($GLOBALS['__phpmorphy_substr']($__mem, $offset + 3, $size - 3))
            );

            $offset += $size;
        }

        return $result;
    }

    public function readAllGrammems() {
        $__mem = $this->resource;

        $result = array();

        $offset = $this->header['grammems_offset'];

        foreach($this->readSectionIndexAsSize($this->header['grammems_index_offset'], $this->header['grammems_count'], $this->header['grammems_size']) as $size) {

            $res = unpack(
                'vid/Cshift',
                $GLOBALS['__phpmorphy_substr']($__mem, $offset, 3)            );

            $result[$res['id']] = array(
                'shift' => $res['shift'],

                'name' => $this->cleanupCString($GLOBALS['__phpmorphy_substr']($__mem, $offset + 3, $size - 3))
            );

            $offset += $size;
        }

        return $result;
    }

    public function readAllAncodes() {
        $__mem = $this->resource;

        $result = array();

        $offset = $this->header['ancodes_offset'];

        for($i = 0; $i < $this->header['ancodes_count']; $i++) {
            $res = unpack('vid/vpos_id', $GLOBALS['__phpmorphy_substr']($__mem, $offset, 4));
            $offset += 4;

            list(, $grammems_count) = unpack('v', $GLOBALS['__phpmorphy_substr']($__mem, $offset, 2));
            $offset += 2;

            $result[$res['id']] = array(
                'pos_id' => $res['pos_id'],
                'grammem_ids' => $grammems_count ?
                    array_values(unpack("v$grammems_count", $GLOBALS['__phpmorphy_substr']($__mem, $offset, $grammems_count * 2))) :
                    array(),
                'offset' => $offset,
            );

            $offset += $grammems_count * 2;
        }

        return $result;
    }
}