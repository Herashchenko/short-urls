<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220529152953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE url (id INT AUTO_INCREMENT NOT NULL, url_from VARCHAR(255) NOT NULL, short_code VARCHAR(20) NOT NULL, expiration_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_F47645AE17D2FE0D (short_code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE url_statistics (id INT AUTO_INCREMENT NOT NULL, url_id INT NOT NULL, user_agent VARCHAR(255) NOT NULL, ip VARCHAR(15) NOT NULL, date DATETIME NOT NULL, INDEX IDX_A298861F81CFDAE7 (url_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE url_statistics ADD CONSTRAINT FK_A298861F81CFDAE7 FOREIGN KEY (url_id) REFERENCES url (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_statistics DROP FOREIGN KEY FK_A298861F81CFDAE7');
        $this->addSql('DROP TABLE url');
        $this->addSql('DROP TABLE url_statistics');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
