<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191231062918 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE taxonomy (uuid VARCHAR(150) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(uuid)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD taxonomy_id VARCHAR(150) DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD9557E6F6 FOREIGN KEY (taxonomy_id) REFERENCES taxonomy (uuid)');
        $this->addSql('CREATE INDEX IDX_D34A04AD9557E6F6 ON product (taxonomy_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD9557E6F6');
        $this->addSql('DROP TABLE taxonomy');
        $this->addSql('DROP INDEX IDX_D34A04AD9557E6F6 ON product');
        $this->addSql('ALTER TABLE product DROP taxonomy_id');
    }
}
