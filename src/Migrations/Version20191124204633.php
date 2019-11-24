<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191124204633 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create connection table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE connection (id CHAR(36) NOT NULL, status VARCHAR(255) NOT NULL, userA CHAR(36) NOT NULL, userB CHAR(36) NOT NULL, INDEX IDX_29F77366DC54F469 (userA), INDEX IDX_29F77366455DA5D3 (userB), PRIMARY KEY(id, userA, userB)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE connection ADD CONSTRAINT FK_29F77366DC54F469 FOREIGN KEY (userA) REFERENCES app_user (id)');
        $this->addSql('ALTER TABLE connection ADD CONSTRAINT FK_29F77366455DA5D3 FOREIGN KEY (userB) REFERENCES app_user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE connection');
    }
}
