<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220531012340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_statistics DROP FOREIGN KEY FK_A298861F81CFDAE7');
        $this->addSql('ALTER TABLE url_statistics ADD CONSTRAINT FK_A298861F81CFDAE7 FOREIGN KEY (url_id) REFERENCES url (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE url_statistics DROP FOREIGN KEY FK_A298861F81CFDAE7');
        $this->addSql('ALTER TABLE url_statistics ADD CONSTRAINT FK_A298861F81CFDAE7 FOREIGN KEY (url_id) REFERENCES url (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
