<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211015162711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE print_screen (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, file_type VARCHAR(255) DEFAULT NULL, fail_on_error TINYINT(1) NOT NULL, scroll_to_element VARCHAR(255) DEFAULT NULL, selector VARCHAR(255) DEFAULT NULL, full_page TINYINT(1) NOT NULL, lazy_load TINYINT(1) NOT NULL, width INT NOT NULL, height INT NOT NULL, url_image VARCHAR(255)  DEFAULT NULL,status TINYINT(1) NOT NULL, create_date DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE print_screen');
    }
}
