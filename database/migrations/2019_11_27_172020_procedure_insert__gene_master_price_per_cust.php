<?php

use Illuminate\Database\Migrations\Migration;

class ProcedureInsertGeneMasterPricePerCust extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GeneMasterPricePerCust');

        DB::unprepared("CREATE PROCEDURE GeneMasterPricePerCust( IN UserID INT)
        BEGIN
            declare Counts int;
            declare	countitem int;
            declare	tglterakhir date;

            insert into master_price_log
            select a.* from
            master_price as a,
            `price_temp` as b,
            `master_customer` as c
            where
                a.`skuid` = b.`SKU`
                and a.`customer_id` = c.`id`
                and b.`customer_group_id` = c.`customer_group_id`
                and c.`customer_group_id` = customer_group
                and a.`end_periode` < EndPeriod;

            update `master_price` as b
            join
                price_temp as a
                on
                a.`SKU` = b.`skuid`
            join
                `master_customer` as c
                on
                    a.`customer_group_id` = c.`customer_group_id`
                and b.`customer_id`  = c.`id`
            set b.`amount_basic` = a.`Pricelist`
            , b.`amount_discount` = a.`Discount`
            ,b.`amount`	=  (`Pricelist` - `Discount`)
            , b.`updated_at` = now()
            ,b.`start_periode` = StartPeriod
            , b.`end_periode` = EndPeriod
            where  (ifnull(a.`Final`,0) > 0)
            and a.`customer_group_id` = customer_group;

            insert into master_price
            select distinct  0 as ID,
            b.`skuid`,
            b.`uom_id`,
            c.`id`,
            a.Pricelist as amount_basic,
            a.`Discount` as amount_discount,
            a.`Final` as amount,
            NULL as tax_value,
            a.`start_period`,
            a.`End_Period`,
            '' as `remarks`,
            1 as Createdby,
            null as updatedby,
            null as deletedat,
            now() as createdat,
            null as updateat
            from
                `price_temp` as a join
                `master_item` as b
            on
                a.`SKU` = b.`skuid` join
                `master_customer` as c
            on
                c.`customer_group_id` = 33
            where
                a.`SKU` not in
                (select `skuid` from
                    `master_price` as mp,
                    `master_customer` as mc
                where
                mp.`customer_id` = mc.id
                and mc.`customer_group_id` = customer_group)
                and a.final > 0;
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS GeneMasterPricePerCust');
    }
}
