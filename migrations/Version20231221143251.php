<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231221143251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id INT AUTO_INCREMENT NOT NULL, liste_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_169E6FB9E85441D8 (liste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE liste_user (liste_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_ACC4169AE85441D8 (liste_id), INDEX IDX_ACC4169AA76ED395 (user_id), PRIMARY KEY(liste_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9E85441D8 FOREIGN KEY (liste_id) REFERENCES liste (id)');
        $this->addSql('ALTER TABLE liste_user ADD CONSTRAINT FK_ACC4169AE85441D8 FOREIGN KEY (liste_id) REFERENCES liste (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE liste_user ADD CONSTRAINT FK_ACC4169AA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9E85441D8');
        $this->addSql('ALTER TABLE liste_user DROP FOREIGN KEY FK_ACC4169AE85441D8');
        $this->addSql('ALTER TABLE liste_user DROP FOREIGN KEY FK_ACC4169AA76ED395');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE liste');
        $this->addSql('DROP TABLE liste_user');
        $this->addSql('DROP TABLE `user`');
    }
}
