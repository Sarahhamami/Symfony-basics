<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231017144923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON product');
        $this->addSql('ALTER TABLE product ADD ref INT NOT NULL, DROP id');
        $this->addSql('ALTER TABLE product ADD PRIMARY KEY (ref)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD id INT AUTO_INCREMENT NOT NULL, DROP ref, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
    }
}
