<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200609151540 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE UNIQUE INDEX UNIQ_F65593E5989D9B62 ON annonce (slug)');
        $this->addSql('ALTER TABLE categorie ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497DD634989D9B62 ON categorie (slug)');
        $this->addSql('ALTER TABLE comment ADD slug VARCHAR(128) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9474526C989D9B62 ON comment (slug)');
        $this->addSql('ALTER TABLE condition_footer CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quartier CHANGE villes_id villes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE slider CHANGE titre titre VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_F65593E5989D9B62 ON annonce');
        $this->addSql('DROP INDEX UNIQ_497DD634989D9B62 ON categorie');
        $this->addSql('ALTER TABLE categorie DROP slug');
        $this->addSql('DROP INDEX UNIQ_9474526C989D9B62 ON comment');
        $this->addSql('ALTER TABLE comment DROP slug');
        $this->addSql('ALTER TABLE condition_footer CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quartier CHANGE villes_id villes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE slider CHANGE titre titre VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`');
    }
}
