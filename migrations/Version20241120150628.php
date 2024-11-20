<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120150628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE users ALTER name TYPE VARCHAR(60)');
        $this->addSql('ALTER TABLE users ALTER surnames TYPE VARCHAR(80)');
        $this->addSql('ALTER TABLE users ALTER age DROP NOT NULL');
        $this->addSql('ALTER TABLE users ALTER email TYPE VARCHAR(180)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON users (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL');
        $this->addSql('ALTER TABLE users DROP roles');
        $this->addSql('ALTER TABLE users ALTER email TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE users ALTER name TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE users ALTER surnames TYPE VARCHAR(60)');
        $this->addSql('ALTER TABLE users ALTER age SET NOT NULL');
    }
}
