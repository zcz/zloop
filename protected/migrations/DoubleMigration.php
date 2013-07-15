<?php

class DoubleMigration extends CDbMigration
{
        public $table_name = "haha";
        public $real_name = "tb_haha";
        public $para = array();

        public function up()
        {
                $this->createTable("$this->table_name", $this->para, 'ENGINE InnoDB');

                $this->real_name = $this->dbConnection->tablePrefix . $this->table_name;
                $this->createTable($this->real_name, $this->para, 'ENGINE InnoDB');
        }

        public function down()
        {
                $this->dropTable("$this->table_name" );

                $this->real_name = $this->dbConnection->tablePrefix . $this->table_name;
                $this->dropTable( $this->real_name );
        }
}
