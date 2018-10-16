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

interface phpMorphy_MorphyInterface {
    const RESOLVE_ANCODES_AS_TEXT = 0;
    const RESOLVE_ANCODES_AS_DIALING = 1;
    const RESOLVE_ANCODES_AS_INT = 2;

    const NORMAL = 1;
    const IGNORE_PREDICT = 2;
    const ONLY_PREDICT = 3;

    const PREDICT_BY_NONE = 'none';
    const PREDICT_BY_SUFFIX = 'by_suffix';
    const PREDICT_BY_DB = 'by_db';

    /**
    * @return phpMorphy_Morphier_MorphierInterface
    */
    public function getCommonMorphier();

    /**
    * @return phpMorphy_Morphier_MorphierInterface
    */
    public function getPredictBySuffixMorphier();

    /**
    * @return phpMorphy_Morphier_MorphierInterface
    */
    public function getPredictByDatabaseMorphier();

    /**
    * @return phpMorphy_Morphier_Bulk
    */
    public function getBulkMorphier();

    /**
    * @return string
    */
    public function getEncoding();

    /**
    * @return string
    */
    public function getLocale();

    /**
     * @return bool
     */
    public function isInUpperCase();

    /**
     * @return phpMorphy_GrammemsProvider_GrammemsProviderAbstract
     */
    public function getGrammemsProvider();

    /**
     * @return phpMorphy_GrammemsProvider_GrammemsProviderAbstract
     */
    public function getDefaultGrammemsProvider();

    /**
    * @return phpMorphy_Shm_Cache
    */
    public function getShmCache();

    /**
    * @return bool
    */
    public function isLastPredicted();

    /**
    * @return one of PREDICT_BY_NONE, PREDICT_BY_SUFFIX, PREDICT_BY_DB
    */
    public function getLastPredictionType();

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return phpMorphy_Paradigm_Collection
    */
    public function findWord($word, $type = self::NORMAL);

    /**
    * Alias for getBaseForm
    *
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    public function lemmatize($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    public function getBaseForm($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    public function getAllForms($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    public function getPseudoRoot($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    public function getPartOfSpeech($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    public function getAllFormsWithAncodes($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @paradm bool $asText - represent graminfo as text or ancodes
    * @param mixed $type - prediction managment
    * @return array
    */
    public function getAllFormsWithGramInfo($word, $asText = true, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    public function getAncode($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    public function getGramInfo($word, $type = self::NORMAL);

    /**
    * @param mixed $word - string or array of strings
    * @param mixed $type - prediction managment
    * @return array
    */
    public function getGramInfoMergeForms($word, $type = self::NORMAL);

    /**
    * @param string $word
    * @param mixed $ancode
    * @param mixed $commonAncode
    * @param bool $returnOnlyWord
    * @param mixed $callback
    * @param mixed $type
    * @return array
    */
    public function castFormByAncode($word, $ancode, $commonAncode = null, $returnOnlyWord = false, $callback = null, $type = self::NORMAL);

    /**
    * @param string $word
    * @param mixed $partOfSpeech
    * @param array $grammems
    * @param bool $returnOnlyWord
    * @param mixed $callback
    * @param mixed $type
    * @return array
    */
    public function castFormByGramInfo($word, $partOfSpeech, $grammems, $returnOnlyWord = false, $callback = null, $type = self::NORMAL);

    /**
    * @param string $word
    * @param mixed $partOfSpeech
    * @param array $grammems
    * @param bool $returnOnlyWord
    * @param mixed $callback
    * @param mixed $type
    * @return array
    */
    //function castFormByFilter($word, $returnOnlyWord = false, $callback = null, $type = self::NORMAL);

    /**
    * @param string $word
    * @param string $patternWord
    * @param mixed $essentialGrammems
    * @param bool $returnOnlyWord
    * @param mixed $callback
    * @param mixed $type
    * @return array
    */
    public function castFormByPattern($word, $patternWord, phpMorphy_GrammemsProvider_GrammemsProviderInterface $grammemsProvider = null, $returnOnlyWord = false, $callback = null, $type = self::NORMAL);
}