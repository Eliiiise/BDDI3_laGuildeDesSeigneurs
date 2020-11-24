<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201124110438 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE players ADD gls_lastname VARCHAR(64) NOT NULL, ADD gls_password VARCHAR(64) NOT NULL, ADD gls_creation DATETIME NOT NULL, ADD gls_modification DATETIME NOT NULL, DROP lastname, DROP password, DROP creation, DROP modification, CHANGE firstname gls_firstname VARCHAR(16) NOT NULL, CHANGE email gls_email VARCHAR(255) NOT NULL, CHANGE mirian gls_mirian INT DEFAULT NULL, CHANGE identifier gls_identifier VARCHAR(40) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE players ADD lastname VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD password VARCHAR(64) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD creation DATETIME NOT NULL, ADD modification DATETIME NOT NULL, DROP gls_lastname, DROP gls_password, DROP gls_creation, DROP gls_modification, CHANGE gls_firstname firstname VARCHAR(16) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE gls_mirian mirian INT DEFAULT NULL, CHANGE gls_identifier identifier VARCHAR(40) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
