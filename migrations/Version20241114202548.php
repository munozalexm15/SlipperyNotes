<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241114202548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notes_categories (notes_id INT NOT NULL, categories_id INT NOT NULL, PRIMARY KEY(notes_id, categories_id))');
        $this->addSql('CREATE INDEX IDX_623AB7ECFC56F556 ON notes_categories (notes_id)');
        $this->addSql('CREATE INDEX IDX_623AB7ECA21214B7 ON notes_categories (categories_id)');
        $this->addSql('ALTER TABLE notes_categories ADD CONSTRAINT FK_623AB7ECFC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notes_categories ADD CONSTRAINT FK_623AB7ECA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notes ADD id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE notes ADD id_photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C2E45A019 FOREIGN KEY (id_photo_id) REFERENCES photos (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_11BA68C79F37AE5 ON notes (id_user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_11BA68C2E45A019 ON notes (id_photo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE notes_categories DROP CONSTRAINT FK_623AB7ECFC56F556');
        $this->addSql('ALTER TABLE notes_categories DROP CONSTRAINT FK_623AB7ECA21214B7');
        $this->addSql('DROP TABLE notes_categories');
        $this->addSql('ALTER TABLE notes DROP CONSTRAINT FK_11BA68C79F37AE5');
        $this->addSql('ALTER TABLE notes DROP CONSTRAINT FK_11BA68C2E45A019');
        $this->addSql('DROP INDEX IDX_11BA68C79F37AE5');
        $this->addSql('DROP INDEX UNIQ_11BA68C2E45A019');
        $this->addSql('ALTER TABLE notes DROP id_user_id');
        $this->addSql('ALTER TABLE notes DROP id_photo_id');
    }
}
