<?php

/*
 * Copyright (C) 2013 George Marques <george at georgemarques.com.br>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace Anazu\Tests;

/**
 * Generic test case for databases.
 *
 * @author George Marques <george at georgemarques.com.br>
 * @package Anazu
 * @category Tests
 * @license https://raw.github.com/vnen/Anazu/master/LICENSE GNU Public License v2
 */
abstract class DatabaseTestCase extends \PHPUnit_Extensions_Database_TestCase
{
    static private $pdo = null;
 
    private $connection = null;
 
    final public function getConnection()
    {
        if ($this->connection === null) {
            if (self::$pdo == null) {
                self::$pdo = new \PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
            }
            $this->connection = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']);
        }
 
        return $this->connection;
    }
}
