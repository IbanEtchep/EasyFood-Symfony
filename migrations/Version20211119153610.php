<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211119153610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2C0F37DD6');
        $this->addSql('DROP INDEX UNIQ_24CC0DF2C0F37DD6 ON panier');
        $this->addSql('ALTER TABLE panier DROP le_client_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panier ADD le_client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2C0F37DD6 FOREIGN KEY (le_client_id) REFERENCES utilisateurs (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_24CC0DF2C0F37DD6 ON panier (le_client_id)');
    }
}
