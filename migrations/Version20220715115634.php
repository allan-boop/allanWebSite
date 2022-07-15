<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220715115634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE language_projet (language_id INT NOT NULL, projet_id INT NOT NULL, INDEX IDX_4C06A5CF82F1BAF4 (language_id), INDEX IDX_4C06A5CFC18272 (projet_id), PRIMARY KEY(language_id, projet_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE language_projet ADD CONSTRAINT FK_4C06A5CF82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE language_projet ADD CONSTRAINT FK_4C06A5CFC18272 FOREIGN KEY (projet_id) REFERENCES projet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE photo ADD projet_id INT NOT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B78418C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_14B78418C18272 ON photo (projet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE language_projet');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B78418C18272');
        $this->addSql('DROP INDEX IDX_14B78418C18272 ON photo');
        $this->addSql('ALTER TABLE photo DROP projet_id');
    }
}
