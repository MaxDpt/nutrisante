<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230926170543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recipes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, prepa_time TIME NOT NULL, cooking_time TIME DEFAULT NULL, rest_time TIME DEFAULT NULL, diet LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', allergen LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', description LONGTEXT NOT NULL, ingredient LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', stage LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', score INT DEFAULT NULL, images LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE recipes');
    }
}
