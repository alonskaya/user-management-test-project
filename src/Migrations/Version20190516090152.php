<?php

declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20190516090152
 * @package DoctrineMigrations
 */
final class Version20190516090152 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Initial migration creating tables';
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        /** ------------ Tables creation ------------ */
        $this->addSql(
            '
            CREATE TABLE IF NOT EXISTS user_entity(
                id serial PRIMARY KEY,
                email VARCHAR (320) UNIQUE NOT NULL,
                last_name VARCHAR (35),
                first_name VARCHAR (35),
                state boolean DEFAULT TRUE,
                creation_date TIMESTAMP NOT NULL DEFAULT NOW()
            );'
        );
        $this->addSql(
            '
            CREATE TABLE IF NOT EXISTS user_group(
                id serial PRIMARY KEY,
                group_name VARCHAR (100) UNIQUE NOT NULL
            );'
        );
        $this->addSql(
            '
            CREATE TABLE IF NOT EXISTS user_to_group(
                user_id INTEGER NOT NULL,
                group_id INTEGER NOT NULL,
                PRIMARY KEY(user_id, group_id) 
            );'
        );

        /** ------------ Foreign keys creation ------------ */
        $this->addSql(
            '
            ALTER TABLE user_to_group
            ADD FOREIGN KEY (user_id) 
            REFERENCES user_entity(id);
            '
        );
        $this->addSql(
            '
            ALTER TABLE user_to_group
            ADD FOREIGN KEY (group_id) 
            REFERENCES user_group(id);
            '
        );
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE user_to_group;');
        $this->addSql('DROP TABLE user_group;');
        $this->addSql('DROP TABLE user_entity;');
    }
}
