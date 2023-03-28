<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230328092503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE operation (
                id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                wallet_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\',
                type VARCHAR(255) NOT NULL,
                operation_data_balance_before_value INT NOT NULL,
                operation_data_balance_before_currency VARCHAR(3) NOT NULL,
                operation_data_balance_after_value INT NOT NULL,
                operation_data_balance_after_currency VARCHAR(3) NOT NULL,
                created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
                updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
                INDEX IDX_1981A66D712520F3 (wallet_id), PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D712520F3 FOREIGN KEY (wallet_id) REFERENCES wallet (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP FOREIGN KEY FK_1981A66D712520F3');
        $this->addSql('DROP TABLE operation');
    }
}
