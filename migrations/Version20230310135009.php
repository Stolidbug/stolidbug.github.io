<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230310135009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE blog_article (id UUID NOT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EECCB3E5989D9B62 ON blog_article (slug)');
        $this->addSql('COMMENT ON COLUMN blog_article.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN blog_article.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE article_category (article_id UUID NOT NULL, category_id UUID NOT NULL, PRIMARY KEY(article_id, category_id))');
        $this->addSql('CREATE INDEX IDX_53A4EDAA7294869C ON article_category (article_id)');
        $this->addSql('CREATE INDEX IDX_53A4EDAA12469DE2 ON article_category (category_id)');
        $this->addSql('CREATE TABLE article_author (article_id UUID NOT NULL, author_id UUID NOT NULL, PRIMARY KEY(article_id, author_id))');
        $this->addSql('CREATE INDEX IDX_D7684F487294869C ON article_author (article_id)');
        $this->addSql('CREATE INDEX IDX_D7684F48F675F31B ON article_author (author_id)');
        $this->addSql('CREATE TABLE blog_author (id UUID NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_28E07D09989D9B62 ON blog_author (slug)');
        $this->addSql('CREATE TABLE blog_category (id UUID NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_72113DE6989D9B62 ON blog_category (slug)');
        $this->addSql('ALTER TABLE article_category ADD CONSTRAINT FK_53A4EDAA7294869C FOREIGN KEY (article_id) REFERENCES blog_article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_category ADD CONSTRAINT FK_53A4EDAA12469DE2 FOREIGN KEY (category_id) REFERENCES blog_category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_author ADD CONSTRAINT FK_D7684F487294869C FOREIGN KEY (article_id) REFERENCES blog_article (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE article_author ADD CONSTRAINT FK_D7684F48F675F31B FOREIGN KEY (author_id) REFERENCES blog_author (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article_category DROP CONSTRAINT FK_53A4EDAA7294869C');
        $this->addSql('ALTER TABLE article_category DROP CONSTRAINT FK_53A4EDAA12469DE2');
        $this->addSql('ALTER TABLE article_author DROP CONSTRAINT FK_D7684F487294869C');
        $this->addSql('ALTER TABLE article_author DROP CONSTRAINT FK_D7684F48F675F31B');
        $this->addSql('DROP TABLE blog_article');
        $this->addSql('DROP TABLE article_category');
        $this->addSql('DROP TABLE article_author');
        $this->addSql('DROP TABLE blog_author');
        $this->addSql('DROP TABLE blog_category');
    }
}
