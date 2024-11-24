<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241124091441 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Makes the product_review table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE product_review (id INT AUTO_INCREMENT NOT NULL,  rating INT NOT NULL,product_id INT NOT NULL, comment LONGTEXT NOT NULL, review_date DATETIME NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_1B3FC0624584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_review ADD CONSTRAINT FK_1B3FC0624584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE product_review DROP FOREIGN KEY FK_1B3FC0624584665A');
        $this->addSql('DROP TABLE product_review');
    }
}
