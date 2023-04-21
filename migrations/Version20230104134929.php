<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104134929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE webpage_page (id UUID NOT NULL, name VARCHAR(255) NOT NULL, content TEXT DEFAULT NULL, author VARCHAR(255) NOT NULL, publication_date DATE DEFAULT NULL, status BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE webpage_page ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AA51FE77989D9B62 ON webpage_page (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_AA51FE77989D9B62');
        $this->addSql('DROP TABLE webpage_page');
    }
}
