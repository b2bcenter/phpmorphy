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

abstract class phpMorphy_Morphier_MorphierAbstract implements phpMorphy_Morphier_MorphierInterface {
    protected
        /**
         * @var phpMorphy_Finder_FinderInterface
         */
        $finder,
        /**
         * @var phpMorphy_Helper
         */
        $helper;

    public function __construct(phpMorphy_Finder_FinderInterface $finder, phpMorphy_Helper $helper) {
        $this->finder = $finder;

        $this->helper = clone $helper;
        $this->helper->setAnnotDecoder($finder->getAnnotDecoder());
    }

    /**
     * @return phpMorphy_Finder_FinderInterface
     */
    public function getFinder() {
        return $this->finder;
    }

    /**
     * @return phpMorphy_Helper
     */
    public function getHelper() {
        return $this->helper;
    }

    public function getAnnot($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->decodeAnnot($annots, true);
    }

    public function getParadigmCollection($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getParadigmCollection($word, $annots);
    }

    public function getAllFormsWithAncodes($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getAllFormsWithResolvedAncodes($word, $annots);
    }

    public function getPartOfSpeech($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getPartOfSpeech($annots);
    }

    public function getBaseForm($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getBaseForm($word, $annots);
    }

    public function getPseudoRoot($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getPseudoRoot($word, $annots);
    }

    public function getAllForms($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getAllForms($word, $annots);
    }

    public function getAncode($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getAncode($annots);
    }

    public function getGrammarInfo($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getGrammarInfo($annots);
    }

    public function getGrammarInfoMergeForms($word) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->getGrammarInfoMergeForms($annots);
    }

    public function castFormByGramInfo($word, $partOfSpeech, $grammems, $returnOnlyWord = false, $callback = null) {
        if(false === ($annots = $this->finder->findWord($word))) {
            return false;
        }

        return $this->helper->castFormByGramInfo($word, $annots);
    }

    public function castFormByPattern($word, $patternWord, $returnOnlyWord = false, $callback = null) {
        if(false === ($orig_annots = $this->finder->findWord($word))) {
            return false;
        }

        if(false === ($pattern_annots = $this->finder->findWord($patternWord))) {
            return false;
        }

        return $this->helper->castFormByPattern(
            $word, $orig_annots,
            $patternWord, $pattern_annots,
            $returnOnlyWord,
            $callback
        );
    }
};