<?php
namespace Extlib;

/**
 * Generator class
 *
 * @category    Extlib
 * @author      Lukasz Ciolecki <ciolecki.lukasz@gmail.com> 
 * @copyright   Copyright (c) Lukasz Ciolecki (mart)
 */
final class Generator 
{    
    /* Configuration */
    const RAND_MIN = 1;
    const RAND_MAX = 1000000;
    const CUT_LEN = 4;
    
    /* Algorithm types */
    const ALGO_MD5 = 'md5';
    const ALGO_SHA256 = 'sha256';
    const ALGO_SHA1   = 'shad1';

    /**
     * Array allowed types of algorithm
     * 
     * @var array 
     */
    static protected $allowedAlgorithm = array(
        self::ALGO_MD5,
        self::ALGO_SHA256,
        self::ALGO_SHA1
    );
    
    /**
     * Doctrine v1.2 generate method
     * 
     * 
     * @param string $tableName
     * @param string $field
     * @param string $length
     * @return string
     * @throws Extlib\Exception 
     */
    static public function doctrine($tableName, $field, $length = 16)
    {
        do {
            $generate = self::generate($length);
        } while (function($tableName, $field, $generate) {
            return \Doctrine_Query::create()->from($tableName)->where("$field = ?", $generate)->fetchOne();
        });
        
        return $generate;
    }
    
    /**
     * Doctrine v2.x generate method
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     * @param string $entityName
     * @param string $field
     * @param int $length
     * @return string
     */
    static public function generateDoctrine2(\Doctrine\ORM\EntityManager $entityManager, $entityName, $field, $length = 16)
    {        
        do {
            $generate = self::generate($length);
        } while (function(\Doctrine\ORM\EntityManager $entityManager, $entityName, $field, $generate) {
            return $entityManager->getRepository($entityName)->findOneBy(array($field => $generate));
        });
        
        return $generate;
    }
    
    /**
     * Phalcon ORM generate method
     * 
     * @param string $modelName
     * @param string $field
     * @param int $length
     * @return string
     */
    static public function generatePhalcon($modelName, $field, $length = 16)
    {
        do {
            $generate = self::generate($length);
        } while (self::phalconQuery($modelName, $field, $generate));
        
        return $generate;
    }
    
    /**
     * Phalcon generate query
     * 
     * @param string $modelName
     * @param string $field
     * @param string $generate
     * @return int
     */
    static protected function phalconQuery($modelName, $field, $generate)
    {
        $return = \Phalcon\Mvc\Model::query()
                                    ->setModelName($modelName)
                                    ->where("$field = :value:")
                                    ->bind(array('value' => $generate))
                                    ->execute();

        return (boolean) $return->count();
    }

    /**
     * Generate random string
     * 
     * @param int $length
     * @param string $algorithm
     * @return string
     * @throws \Extlib\Exception 
     */
    static public function generate($length = 16, $algorithm = 'sha256')
    {
        if (!in_array($algorithm, self::$allowedAlgorithm)) {
            throw new Exception("Hash algorithm $algorithm doesn't exists!");    
        }

        $salt = hash($algorithm, time());

        return substr(hash($algorithm, (mt_rand(self::RAND_MIN, self::RAND_MAX) % $length) . $salt . mt_rand(self::RAND_MIN, self::RAND_MAX)), self::CUT_LEN, $length);
    }
}
