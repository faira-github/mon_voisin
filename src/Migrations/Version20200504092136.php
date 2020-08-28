<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200504092136 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE condition_footer CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quartier ADD villes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quartier ADD CONSTRAINT FK_FEE8962D286C17BC FOREIGN KEY (villes_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_FEE8962D286C17BC ON quartier (villes_id)');
        $this->addSql('ALTER TABLE slider CHANGE titre titre VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3DF1E57AB');
        $this->addSql('DROP INDEX UNIQ_43C3D9C3DF1E57AB ON ville');
        $this->addSql('ALTER TABLE ville DROP quartier_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE condition_footer CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quartier DROP FOREIGN KEY FK_FEE8962D286C17BC');
        $this->addSql('DROP INDEX IDX_FEE8962D286C17BC ON quartier');
        $this->addSql('ALTER TABLE quartier DROP villes_id');
        $this->addSql('ALTER TABLE slider CHANGE titre titre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
        $this->addSql('ALTER TABLE ville ADD quartier_id INT NOT NULL');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3DF1E57AB FOREIGN KEY (quartier_id) REFERENCES quartier (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_43C3D9C3DF1E57AB ON ville (quartier_id)');
    }
}
