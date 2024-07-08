<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240708124034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE member_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE project_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE time_entry_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, external_id VARCHAR(255) DEFAULT NULL, name VARCHAR(100) NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE member (id INT NOT NULL, external_id VARCHAR(255) DEFAULT NULL, name VARCHAR(250) NOT NULL, email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE project (id INT NOT NULL, client_id INT DEFAULT NULL, external_id VARCHAR(255) DEFAULT NULL, name VARCHAR(250) NOT NULL, billable BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2FB3D0EE19EB6921 ON project (client_id)');
        $this->addSql('CREATE TABLE time_entry (id INT NOT NULL, project_id INT DEFAULT NULL, member_id INT DEFAULT NULL, external_id VARCHAR(255) DEFAULT NULL, description VARCHAR(3000) DEFAULT NULL, start_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, end_time TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6E537C0C166D1F9C ON time_entry (project_id)');
        $this->addSql('CREATE INDEX IDX_6E537C0C7597D3FE ON time_entry (member_id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE time_entry ADD CONSTRAINT FK_6E537C0C166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE time_entry ADD CONSTRAINT FK_6E537C0C7597D3FE FOREIGN KEY (member_id) REFERENCES member (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE member_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE project_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE time_entry_id_seq CASCADE');
        $this->addSql('ALTER TABLE project DROP CONSTRAINT FK_2FB3D0EE19EB6921');
        $this->addSql('ALTER TABLE time_entry DROP CONSTRAINT FK_6E537C0C166D1F9C');
        $this->addSql('ALTER TABLE time_entry DROP CONSTRAINT FK_6E537C0C7597D3FE');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE time_entry');
    }
}
