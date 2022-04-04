<?php

namespace App\Entidy;

use \App\Db\Database;

use \PDO;

class Compra
{


    public $id; 
    public $codigo;
    public $barra;
    public $nome;
    public $qtd;
    public $valor_compra;
    public $subtotal;
    public $produtos_id;
    public $usuarios_id;
    public $status;
    public $fornecedor_id;
 

    public function cadastar()
    {


        $obdataBase = new Database('compras');

        $this->id = $obdataBase->insert([

            'codigo'          => $this->codigo, 
            'barra'           => $this->barra, 
            'nome'            => $this->nome, 
            'qtd'             => $this->qtd, 
            'valor_compra'    => $this->valor_compra, 
            'subtotal'        => $this->subtotal, 
            'produtos_id'     => $this->produtos_id, 
            'fornecedor_id'   => $this->fornecedor_id, 
            'usuarios_id'     => $this->usuarios_id, 
            'status'          => $this->status
          

        ]);

        return true;
    }

    
    public function atualizar()
    {
        return (new Database('compras'))->update('id = ' . $this->id, [

            'codigo'          => $this->codigo, 
            'barra'           => $this->barra, 
            'nome'            => $this->nome, 
            'qtd'             => $this->qtd, 
            'valor_compra'    => $this->valor_compra, 
            'subtotal'        => $this->subtotal, 
            'produtos_id'     => $this->produtos_id, 
            'fornecedor_id'   => $this->fornecedor_id, 
            'usuarios_id'     => $this->usuarios_id, 
            'status'          => $this->status

        ]);
    }


    public static function getList($fields = null,$table = null,$where = null, $order = null, $limit = null)
    {

        return (new Database('compras'))->select($fields,$table, $where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }



    public static function getQtd($fields = null, $table = null, $where = null, $order = null, $limit = null)
    {

        return (new Database('compras'))->select('COUNT(*) as qtd', 'compras',null,null)
            ->fetchObject()
            ->qtd;
    }


    public static function getID($fields, $table, $where, $order, $limit)
    {
        return (new Database('compras'))->select($fields, $table, 'id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }
    public static function getReceberID($fields, $table, $where, $order, $limit)
    {
        return (new Database('compras'))->select($fields, $table, 'produtos_id = ' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public static function getBarra($fields, $table, $where, $order, $limit)
    {
        return (new Database('compras'))->select2($fields, $table, 'barra LIKE "%' . $where, $order, $limit)
            ->fetchObject(self::class);
    }


    public function excluir()
    {
        return (new Database('compras'))->delete('id = ' . $this->id);
    }

    public static function getUsuarioPorEmail($email)
    {

        return (new Database('compras'))->select('email = "' . $email . '"')->fetchObject(self::class);
    }
}
