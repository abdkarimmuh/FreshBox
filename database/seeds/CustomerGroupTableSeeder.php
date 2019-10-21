<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::statement("
        INSERT INTO `master_customer_group` (`id`, `name`, `description`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
        (1,	'Kyati Group',	'Kyati Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (2,	'Biko Group',	'Biko Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (3,	'Union Group',	'Union Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (4,	'Fat Shogun',	'Fat Shogun Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (5,	'Codefin Group',	'Codefin Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (6,	'Pochajjang Group',	'Pochajjang Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (7,	'Fedwell',	'Fedwell Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (8,	'Ismaya Group',	'Ismaya Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (9,	'Doubletree',	'Doubletree Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (10,	'I-Tasuki (Central Kitchen',	'I-Tasuki (Central Kitchen Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (11,	'The Goods Group',	'The Goods Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (12,	'Ikkudo Ichi Group',	'Ikkudo Ichi Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (13,	'The Garden Group',	'The Garden Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (14,	'Hurricanes Group',	'Hurricanes Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (15,	'Sushi Sen Group',	'Sushi Sen Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (16,	'Hog Wild',	'Hog Wild Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (17,	'Saladstop',	'Saladstop Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (18,	'Weekly',	'Weekly Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (19,	'Monthly',	'Monthly Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (20,	'Crazy Uncle',	'Crazy Uncle Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (21,	'Gran Melia',	'Gran Melia Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (22,	'Hotel Mulia',	'Hotel Mulia Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (23,	'Kopi Kulo',	'Kopi Kulo Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (24,	'Omnikopi',	'Omnikopi Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (25,	'Paradise Group',	'Paradise Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (26,	'Boga Group',	'Boga Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (27,	'SIBAS',	'SIBAS Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (28,	'Tea Amo',	'Tea Amo Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (29,	'PT.Graha Food Entertainment',	'PT.Graha Food Entertainment Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL),
        (30,	'Warung Pedas Kemang',	'Warung Pedas Kemang Group',	1,	1,	NULL,	'2019-10-10 13:05:27',	NULL);
        ");
    }
}
