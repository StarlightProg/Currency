<?php

declare(strict_types=1);

namespace Migrations;

use App\Models\Currencies;
use Doctrine\DBAL\Types\Types;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230721230132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $currencies = $schema->createTable('currencies');

        $currencies->addColumn('NumCode', Types::INTEGER);
        $currencies->addColumn('CharCode', Types::STRING);
        $currencies->addColumn('Nominal', Types::INTEGER);
        $currencies->addColumn('Name', Types::STRING);  
        $currencies->addColumn('Value', Types::STRING);
        $currencies->addColumn('created_at', Types::DATETIME_MUTABLE);   

        $currencies->setPrimaryKey(['NumCode']);
    }

    public function postUp(Schema $schema): void{
        $currencyModel = new Currencies();

        $currencyModel->add_currencies();
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $schema->dropTable('currencies');
    }
}
