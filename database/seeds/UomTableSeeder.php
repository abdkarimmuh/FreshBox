<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UomTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement("
            INSERT INTO `master_uom` (`id`, `name`, `description`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
            (1,	'Kg',	'kilogram',	1,	NULL,	NULL,	'2019-05-06 00:32:20',	NULL),
            (2,	'Pcs',	'Piece',	1,	NULL,	NULL,	'2019-05-06 00:33:36',	NULL),
            (3,	'Pack',	'Pack',	1,	NULL,	NULL,	'2019-05-06 00:34:04',	NULL),
            (4,	'Botol',	'Botol',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL),
            (5,	'Sisir',	'Sisir',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL),
            (6,	'Klg',	'Kaleng',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL),
            (7,	'Peti',	'Peti',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL),
            (8,	'ltr',	'Liter',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL),
            (9,	'Box',	'Box',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL),
            (10,	'Karung',	'Karung',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL),
            (11,	'Can',	'Can',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL),
            (12,	'Pail',	'Pail',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL),
            (13,	'Bag',	'Bag',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL),
            (15,	'Karton',	'Karton',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL),
            (16,	'Jerigen',	'Jerigen',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL),
            (20,	'Butir',	'Butir',	1,	NULL,	NULL,	'2019-06-19 10:00:00',	NULL);
        ");
    }
}
