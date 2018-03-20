
<?php
/**
 * Copyright (c) 2018. Challstrom. All Rights Reserved.
 */

/**
 * Created by IntelliJ IDEA.
 * Staff: malkhud
 * Date: 05-May-17
 * Time: 8:57 PM
 */
require_once __DIR__ . '/Log.php';
class Database
{
    static $database;
    private static $databaseConfig = __DIR__ . "/config/database.json";
    private static $dbName = "malkhudc_userdb"; //POS create

    public static function scrubQuery($query)
    {
        return self::getDB()->real_escape_string($query);
    }

    public static function getDB()
    {
        //casting explicitly to mysqli
        self::checkDatabaseConnect();
        return self::$database;
    }

    private static function checkDatabaseConnect()
    {
        $i = 0;
        while (self::$database == null && $i < 10) {
            self::databaseConnect();
            $i++;
        }
    }

    private static function databaseConnect()
    {
        $config = self::loadDatabaseConfig();
        self::$database = new mysqli($config['user_id'], $config['user_name'], $config['user_firstName'], "", $config['user_lastName'], $config['password'], "", $config['email'], $config['credit_card_number'], "", $config['card_holder_name'], $config['credit_expiration'], "", $config['credit_ccv']);
        if (self::$database->connect_error) {
            Log::fatal("Database Connection Failed with " . self::$database->connect_error, __LINE__);
        }
        self::$database->query("USE " . self::$dbName);
    }

    private static function loadDatabaseConfig()
    {
        $databaseConfig = self::$databaseConfig;
        if (file_exists($databaseConfig)) {
            $config = json_decode(file_get_contents($databaseConfig), true);
            if (!isset($config['user_id'])) {
                Log::fatal("userId not set in $databaseConfig!", __LINE__);
            }
            if (!isset($config['user_name'])) {
                Log::fatal("username not set in $databaseConfig!", __LINE__);
            }
            if (!isset($config['user_firstName'])) {
                Log::fatal("user_firstName not set in $databaseConfig!", __LINE__);
            }
            if (!isset($config['user_lastName'])) {
                Log::fatal("userLastName not set in $databaseConfig!", __LINE__);
            }
            if (!isset($config['password'])) {
                Log::fatal("password not set in $databaseConfig!", __LINE__);
            }
            if (!isset($config['email'])) {
                Log::fatal("email not set in $databaseConfig!", __LINE__);
            }
            if (!isset($config['credit_card_number'])) {
                Log::fatal("creditCardNumber not set in $databaseConfig!", __LINE__);
            }
            if (!isset($config['card_holder_name'])) {
                Log::fatal("cardHolderName not set in $databaseConfig!", __LINE__);
            }
            if (!isset($config['credit_expiration'])) {
                Log::fatal("creditExpiration not set in $databaseConfig!", __LINE__);
            }
            if (!isset($config['credit_ccv'])) {
                Log::fatal("creditCcv not set in $databaseConfig!", __LINE__);
            }
            return $config;
        } else {
            Log::fatal("Setup was not Run! Go to $databaseConfig!", __LINE__);
        }
        return [];
    }

    //internal functions

    public static function runQueryVoid(string $query)
    {
        //$query = self::getDB()->real_escape_string($query);
        self::getDB()->query($query);
        if (self::getDB()->error) {
            Log::error("Query $query FAILED with " . self::getDB()->error, __LINE__);
        }
    }

    public static function runQuerySingle(string $query)
    {
        Log::info("Running query $query", __LINE__);
        //$query = self::getDB()->real_escape_string($query);
        $result = self::getDB()->query($query);
        if (self::getDB()->error) {
            Log::error("Query $query FAILED with " . self::getDB()->error, __LINE__);
            return false;
        } else if (is_bool($result)) {
            Log::info("Query $query returned bool val " . $result, __LINE__);            
            return boolval($result);
        } else if ($result) {
            $assoc = $result->fetch_assoc();
//            Log::info("Query $query returned " . $assoc, __LINE__);
            return $assoc;
        }
    }

     public static function runQueryAll(string $query)
    {
        //$query = self::getDB()->real_escape_string($query);
        $result = self::getDB()->query($query);
        if (self::getDB()->error) {
            Log::error("Query $query FAILED with " . self::getDB()->error, __LINE__);
        } else if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
            return $data;
        }
        return [];
    }

    public static function getLastKey()
    {
        return self::getDB()->insert_id;
    }
}


