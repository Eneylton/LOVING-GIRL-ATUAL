<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Deposito
{


    public $id;
    public $data;
    public $valor;
    public $forma_pagamento_id;
    public $banco_id;

    public function cadastar()
    {


        $obdataBase = new Database('deposito');

        $this->id = $obdataBase->insert([

            'valor'                       => $this->valor,
            'data'                        => $this->data,
            'banco_id'                    => $this->banco_id,
            'forma_pagamento_id'          => $this->forma_pagamento_id

        ]);

        return true;
    }



    public function atualizar()
    {
        return (new Database('deposito'))->update('id = ' . $this->id, [

            'valor'                       => $this->valor,
            'data'                        => $this->data,
            'banco_id'                    => $this->banco_id,
            'forma_pagamento_id'          => $this->forma_pagamento_id
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('deposito'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('deposito'))->select('COUNT(*) as qtd', 'deposito', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('deposito'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

  

    public function excluir()
    {
        return (new Database('deposito'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('deposito'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
