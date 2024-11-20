<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120150841 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id SERIAL NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE notes (id SERIAL NOT NULL, id_user_id INT NOT NULL, id_photo_id INT DEFAULT NULL, title VARCHAR(150) NOT NULL, content TEXT DEFAULT NULL, is_archived BOOLEAN NOT NULL, creation_date DATE NOT NULL, last_modified TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, reminder_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_11BA68C79F37AE5 ON notes (id_user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_11BA68C2E45A019 ON notes (id_photo_id)');
        $this->addSql('CREATE TABLE notes_categories (notes_id INT NOT NULL, categories_id INT NOT NULL, PRIMARY KEY(notes_id, categories_id))');
        $this->addSql('CREATE INDEX IDX_623AB7ECFC56F556 ON notes_categories (notes_id)');
        $this->addSql('CREATE INDEX IDX_623AB7ECA21214B7 ON notes_categories (categories_id)');
        $this->addSql('CREATE TABLE photos (id SERIAL NOT NULL, name VARCHAR(255) DEFAULT NULL, resource_path VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE users (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(60) NOT NULL, surnames VARCHAR(80) NOT NULL, age INT DEFAULT NULL, birthdate DATE DEFAULT NULL, username VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON users (email)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C79F37AE5 FOREIGN KEY (id_user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notes ADD CONSTRAINT FK_11BA68C2E45A019 FOREIGN KEY (id_photo_id) REFERENCES photos (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notes_categories ADD CONSTRAINT FK_623AB7ECFC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE notes_categories ADD CONSTRAINT FK_623AB7ECA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE notes DROP CONSTRAINT FK_11BA68C79F37AE5');
        $this->addSql('ALTER TABLE notes DROP CONSTRAINT FK_11BA68C2E45A019');
        $this->addSql('ALTER TABLE notes_categories DROP CONSTRAINT FK_623AB7ECFC56F556');
        $this->addSql('ALTER TABLE notes_categories DROP CONSTRAINT FK_623AB7ECA21214B7');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE notes');
        $this->addSql('DROP TABLE notes_categories');
        $this->addSql('DROP TABLE photos');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
