<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Banco
{


    public $id;
    public $nome;

    public function cadastar()
    {


        $obdataBase = new Database('banco');

        $this->id = $obdataBase->insert([

            'nome'              => $this->nome

        ]);

        return true;
    }



    public function atualizar()
    {
        return (new Database('banco'))->update('id = ' . $this->id, [

            'nome'              => $this->nome
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('banco'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('banco'))->select('COUNT(*) as qtd', 'banco', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('banco'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

  

    public function excluir()
    {
        return (new Database('banco'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('banco'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
