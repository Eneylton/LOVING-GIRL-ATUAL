<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Fornecedor
{


    public $id;
    public $nome;
    public $email;
    public $telefone;

    public function cadastar()
    {


        $obdataBase = new Database('fornecedor');

        $this->id = $obdataBase->insert([

            'nome'                => $this->nome,
            'email'               => $this->email,
            'telefone'            => $this->telefone

        ]);

        return true;
    }



    public function atualizar()
    {
        return (new Database('fornecedor'))->update('id = ' . $this->id, [

            'nome'                => $this->nome,
            'email'               => $this->email,
            'telefone'            => $this->telefone
        ]);
    }


    public static function getList($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('fornecedor'))->select($fields, $table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('fornecedor'))->select('COUNT(*) as qtd', 'fornecedor', null, null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('fornecedor'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }

  

    public function excluir()
    {
        return (new Database('fornecedor'))->delete('id = ' . $this->id);
    }


    public static function getUsuarioPorEmail($email)
    {

        return (new Database('fornecedor'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
