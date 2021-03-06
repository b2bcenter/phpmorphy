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

class phpMorphy_Generator_Fsa_HelperTree extends phpMorphy_Generator_Fsa_HelperAbstract {
    /**
     * @return string
     */
    public function getType() {
        return 'Tree';
    }

    /**
     * @return string
     */
    public function checkLLast($var) {
        return "($var & 0x0200)";
    }

    /**
     * @return string
     */
    public function checkRLast($var) {
        return "($var & 0x0400)";
    }

    /**
     * @return string
     */
    public function getRootTransOffset() {
        return $this->getOffsetInFsa(0);
    }

    /**
     * @return string
     */
    public function getAnnotIdx($var) {
        return "(($var & 0xFF) << 21) | (($var >> 11) & 0x1FFFFF)";
    }

    /**
     * @return string
     */
    public function getDest($var) {
        return "(($var) >> 11) & 0x1FFFFF";
    }

    /**
     * @return string
     */
    public function getIndexByTrans($transVar, $charVar) {
        return "($transVar >> 11) & 0x1FFFFF";
    }

    /**
     * @return string
     */
    public function getAnnotIndexByTrans($transVar) {
        return $this->getIndexByTrans($transVar, 'Generated from ' . __FILE__ . ':' . __LINE__);
    }
}