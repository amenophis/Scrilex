<?php

namespace Migration;

use Knp\Migration\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class UserCreateMigration extends AbstractMigration
{
    public function schemaUp(Schema $schema)
    {
        //User
        $userTable = $schema->createTable('user');
        $userTable->addColumn('id', 'integer', array(
            'autoincrement' => true
        ));
        $userTable->addColumn('username', 'string', array('length' => 32));
        $userTable->addColumn('password', 'string', array('length' => 255));
        //$userTable->addColumn('enabled', 'boolean');
        //$userTable->addColumn('accountNonExpired', 'boolean');
        //$userTable->addColumn('credentialsNonExpired', 'boolean');
        //$userTable->addColumn('accountNonLocked', 'boolean');
        $userTable->addColumn('firstname', 'string');
        $userTable->addColumn('lastname', 'string');
        $userTable->addColumn('roles', 'string', array('length' => 255));
        $userTable->addColumn('is_manager', 'boolean');
        
        $userTable->setPrimaryKey(array('id'));
        $userTable->addUniqueIndex(array('username'));
        
        //Project
        $projectTable = $schema->createTable('project');
        $projectTable->addColumn('id', 'integer', array(
            'unsigned'      => true,
            'autoincrement' => true
        ));
        $projectTable->addColumn('name', 'string');
        $projectTable->setPrimaryKey(array('id'));
        $projectTable->addUniqueIndex(array('name'));
        
        //Task
        $taskTable = $schema->createTable('task');
        $taskTable->addColumn('id', 'integer', array(
            'unsigned'      => true,
            'autoincrement' => true
        ));
        $taskTable->addColumn('project_id', 'integer', array(
            'unsigned'      => true
        ));
        $taskTable->addColumn('user_id', 'integer', array(
            'unsigned'      => true
        ));
        $taskTable->addColumn('pos', 'integer');
        $taskTable->addColumn('col', 'integer');
        $taskTable->addColumn('severity', 'integer');
        $taskTable->addColumn('content', 'string');
        
        $taskTable->setPrimaryKey(array('id'));
        
        $taskTable = $schema->getTable('task');
        
        $taskTable->addIndex(array('project_id', 'user_id'));
        
        $taskTable->addForeignKeyConstraint($projectTable, array('project_id'), array('id'), array('onDelete' => 'CASCADE'));
        $taskTable->addForeignKeyConstraint($userTable, array('user_id'), array('id'), array('onDelete' => 'CASCADE'));
        
        
        //Users <-> Projects
        $usersProjectsTable = $schema->createTable('users_projects');
        $usersProjectsTable->addColumn('user_id', 'integer', array(
            'unsigned'      => true
        ));
        $usersProjectsTable->addColumn('project_id', 'integer', array(
            'unsigned'      => true
        ));
        $usersProjectsTable->setPrimaryKey(array('user_id', 'project_id'));
        
        $usersProjectsTable->addIndex(array('user_id', 'project_id'));
        
        $usersProjectsTable->addForeignKeyConstraint($projectTable, array('project_id'), array('id'), array('onDelete' => 'CASCADE'));
        $usersProjectsTable->addForeignKeyConstraint($userTable, array('user_id'), array('id'), array('onDelete' => 'CASCADE'));
    }

    public function getMigrationInfo()
    {
        return 'Database initial setup';
    }
}