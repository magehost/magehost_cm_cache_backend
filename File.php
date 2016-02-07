<?php
/**
 * MageHost_Hosting
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this Module to
 * newer versions in the future.
 *
 * @category     MageHost
 * @package      MageHost_Hosting
 * @copyright    Copyright (c) 2015 MageHost BVBA (http://www.magentohosting.pro)
 */

/**
 * Class MageHost_Cm_Cache_Backend_File
 * This class adds some functionality to Cm_Cache_Backend_File, mainly events.
 *
 * {@inheritdoc}
 */
class MageHost_Cm_Cache_Backend_File extends Cm_Cache_Backend_File
{
    /** @var string|null */
    protected $frontendPrefix = null;

    /**
     * This method will dispatch the events 'magehost_clean_backend_cache_before'
     *                                  and 'magehost_clean_backend_cache_after'.
     * Event listeners can change the mode or tags.
     *
     * {@inheritdoc}
     */
    public function clean($mode = Zend_Cache::CLEANING_MODE_ALL, $tags = array()) {
        $transportObject = new Varien_Object;
        /** @noinspection PhpUndefinedMethodInspection */
        $transportObject->setMode( $mode );
        /** @noinspection PhpUndefinedMethodInspection */
        $transportObject->setTags( $tags );
        Mage::dispatchEvent( 'jv_clean_backend_cache', array( 'transport' => $transportObject ) ); // deprecated
        Mage::dispatchEvent( 'magehost_clean_backend_cache_before', array( 'transport' => $transportObject ) );
        /** @noinspection PhpUndefinedMethodInspection */
        $mode = $transportObject->getMode();
        /** @noinspection PhpUndefinedMethodInspection */
        $tags = $transportObject->getTags();
        $result = parent::clean($mode, $tags);
        $transportObject->setResult( $result );
        Mage::dispatchEvent( 'magehost_clean_backend_cache_after', array( 'transport' => $transportObject ) );
        $result = $transportObject->getResult();
        return $result;
    }

    /**
     * This method will dispatch the event 'magehost_cache_miss_mh' when a cache key miss occurs loading a key
     * from MageHost_BlockCache.
     *
     * {@inheritdoc}
     */
    public function load($id, $doNotTestCacheValidity = false) {
        $result = parent::load($id, $doNotTestCacheValidity);
        if ( false === $result && false !== strpos($id,'_JV_') ) {
            Mage::dispatchEvent('jv_cache_miss_jv', array('id' => $id)); // deprecated
            Mage::dispatchEvent('magehost_cache_miss_jv', array('id' => $id));
        }
        if ( false === $result && false !== strpos($id,'_MH_') ) {
            Mage::dispatchEvent('magehost_cache_miss_mh', array('id' => $id));
        }
        return $result;
    }

    /**
     * This method will dispatch the event 'magehost_cache_save_block' when cache is saved for a html block.
     *
     * {@inheritdoc}
     */
    public function save($data, $id, $tags = array(), $specificLifetime = false)
    {
        if ( in_array( $this->getFrontendPrefix().'BLOCK_HTML', $tags ) ) {
            $transportObject = new Varien_Object;
            /** @noinspection PhpUndefinedMethodInspection */
            $transportObject->setTags($tags);
            Mage::dispatchEvent('jv_cache_save_block', array('id' => $id,'transport' => $transportObject));
            Mage::dispatchEvent('magehost_cache_save_block', array('id' => $id,'transport' => $transportObject));
            /** @noinspection PhpUndefinedMethodInspection */
            $tags = $transportObject->getTags();
        }
        return parent::save( $data, $id, $tags, $specificLifetime );
    }

    protected function getFrontendPrefix() {
        if ( is_null($this->frontendPrefix) ) {
            $this->frontendPrefix = Mage::app()->getCacheInstance()->getFrontend()->getOption('cache_id_prefix');
        }
        return $this->frontendPrefix;
    }
}
