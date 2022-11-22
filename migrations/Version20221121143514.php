<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221121143514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attack (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, cost INT DEFAULT 1, gain INT DEFAULT 1, success_rate INT DEFAULT 100, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attack_unicorn (attack_id INT NOT NULL, unicorn_id INT NOT NULL, INDEX IDX_A145B4D8F5315759 (attack_id), INDEX IDX_A145B4D82AF80346 (unicorn_id), PRIMARY KEY(attack_id, unicorn_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unicorn (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, avatar VARCHAR(255) DEFAULT NULL, score INT DEFAULT NULL, fights INT DEFAULT 0, won_fights INT DEFAULT 0, lost_fights INT DEFAULT 0, ko_fights INT DEFAULT 0, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(45) NOT NULL, lastname VARCHAR(45) NOT NULL, nickname VARCHAR(45) NOT NULL, avatar VARCHAR(255) DEFAULT \'avatar.png\', description LONGTEXT DEFAULT NULL, score INT DEFAULT 1000, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649A188FE64 (nickname), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attack_unicorn ADD CONSTRAINT FK_A145B4D8F5315759 FOREIGN KEY (attack_id) REFERENCES attack (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attack_unicorn ADD CONSTRAINT FK_A145B4D82AF80346 FOREIGN KEY (unicorn_id) REFERENCES unicorn (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attack_unicorn DROP FOREIGN KEY FK_A145B4D8F5315759');
        $this->addSql('ALTER TABLE attack_unicorn DROP FOREIGN KEY FK_A145B4D82AF80346');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE attack');
        $this->addSql('DROP TABLE attack_unicorn');
        $this->addSql('DROP TABLE unicorn');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
