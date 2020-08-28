<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200501131642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, categorys_id INT NOT NULL, users_id INT NOT NULL, annonce_title VARCHAR(255) NOT NULL, annonce_description LONGTEXT NOT NULL, annonce_order INT NOT NULL, annonce_publier TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, annonce_picture VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME NOT NULL, budget NUMERIC(6, 2) NOT NULL, city VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, INDEX IDX_F65593E5A96778EC (categorys_id), INDEX IDX_F65593E567B3B43D (users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, description_categorie LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, author VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, crea_ted_at DATETIME NOT NULL, INDEX IDX_9474526C7294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE condition_footer (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, INDEX IDX_75AF073F12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quartier (id INT AUTO_INCREMENT NOT NULL, nom_quartier VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remenberme_token (id INT AUTO_INCREMENT NOT NULL, value VARCHAR(88) NOT NULL, last_used DATETIME NOT NULL, class VARCHAR(100) NOT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) NOT NULL, image_size INT NOT NULL, updated_at DATETIME NOT NULL, titre VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE social_network (id INT AUTO_INCREMENT NOT NULL, icone VARCHAR(255) NOT NULL, lien VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE types_footer (id INT AUTO_INCREMENT NOT NULL, categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, first_name VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, telephone INT NOT NULL, password VARCHAR(255) NOT NULL, villes VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, date_naissance DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_annonce (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, user_id INT DEFAULT NULL, titrearticle VARCHAR(255) NOT NULL, checkbox TINYINT(1) NOT NULL, description_article LONGTEXT NOT NULL, budget NUMERIC(6, 2) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_AE588DEFBCF5E72D (categorie_id), INDEX IDX_AE588DEFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, quartier_id INT NOT NULL, ville VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_43C3D9C3DF1E57AB (quartier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5A96778EC FOREIGN KEY (categorys_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E567B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C7294869C FOREIGN KEY (article_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE condition_footer ADD CONSTRAINT FK_75AF073F12469DE2 FOREIGN KEY (category_id) REFERENCES types_footer (id)');
        $this->addSql('ALTER TABLE user_annonce ADD CONSTRAINT FK_AE588DEFBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE user_annonce ADD CONSTRAINT FK_AE588DEFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C3DF1E57AB FOREIGN KEY (quartier_id) REFERENCES quartier (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C7294869C');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5A96778EC');
        $this->addSql('ALTER TABLE user_annonce DROP FOREIGN KEY FK_AE588DEFBCF5E72D');
        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C3DF1E57AB');
        $this->addSql('ALTER TABLE condition_footer DROP FOREIGN KEY FK_75AF073F12469DE2');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E567B3B43D');
        $this->addSql('ALTER TABLE user_annonce DROP FOREIGN KEY FK_AE588DEFA76ED395');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE condition_footer');
        $this->addSql('DROP TABLE quartier');
        $this->addSql('DROP TABLE remenberme_token');
        $this->addSql('DROP TABLE slider');
        $this->addSql('DROP TABLE social_network');
        $this->addSql('DROP TABLE types_footer');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_annonce');
        $this->addSql('DROP TABLE ville');
    }
}
