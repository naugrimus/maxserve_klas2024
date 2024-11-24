<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241124141517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'adds api_created_at and api_updated_at to product';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE product ADD api_updated_at DATETIME DEFAULT NULL, ADD api_created_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP api_updated_at, DROP api_created_at');
    }
}
