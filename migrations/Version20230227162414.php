<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227162414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_entity (id INT AUTO_INCREMENT NOT NULL, urgency_id INT NOT NULL, status_id INT NOT NULL, text LONGTEXT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_746A2EA34D44979A (urgency_id), INDEX IDX_746A2EA36BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_of_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, ticket_id INT NOT NULL, INDEX IDX_24670728A76ED395 (user_id), INDEX IDX_24670728700047D2 (ticket_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE urgency_entity (id INT AUTO_INCREMENT NOT NULL, time INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ticket_entity ADD CONSTRAINT FK_746A2EA34D44979A FOREIGN KEY (urgency_id) REFERENCES urgency_entity (id)');
        $this->addSql('ALTER TABLE ticket_entity ADD CONSTRAINT FK_746A2EA36BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE ticket_of_user ADD CONSTRAINT FK_24670728A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket_of_user ADD CONSTRAINT FK_24670728700047D2 FOREIGN KEY (ticket_id) REFERENCES ticket_entity (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_entity DROP FOREIGN KEY FK_746A2EA34D44979A');
        $this->addSql('ALTER TABLE ticket_entity DROP FOREIGN KEY FK_746A2EA36BF700BD');
        $this->addSql('ALTER TABLE ticket_of_user DROP FOREIGN KEY FK_24670728A76ED395');
        $this->addSql('ALTER TABLE ticket_of_user DROP FOREIGN KEY FK_24670728700047D2');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE ticket_entity');
        $this->addSql('DROP TABLE ticket_of_user');
        $this->addSql('DROP TABLE urgency_entity');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
