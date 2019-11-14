<?php
    class TarefaService{
        private $conexao;
        private $tarefa;
        public function __construct(Conexao $conexao, Tarefa $tarefa){
            $this->conexao = $conexao->conectar();
            $this->tarefa = $tarefa;
        }
        public function inserir(){
            //Create
            $query = 'INSERT INTO tb_tarefas (tarefa) values (:tarefa)';
            //A execução da instrução prepare consiste em dois estágios:
            //preparar e executar. No estágio de preparação, um modelo de instrução é enviado
            //ao servidor de banco de dados. O servidor executa uma verificação de sintaxe e 
            //inicializa os recursos internos do servidor para uso posterior.
            $stmt = $this->conexao->prepare($query);
            // bindValue Vincula um valor a um parâmetro
            $stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
            $stmt->execute();
        }
        public function recuperar(){
            //Read
            $query = 'SELECT
                        t.id, s.status, t.tarefa
                    FROM 
                        tb_tarefas as t 
                        LEFT JOIN tb_status AS s ON (t.id_status = s.id)
            ';
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public function atualizar(){
            //Update
            $query = 'UPDATE tb_tarefas SET tarefa = ? WHERE id = ?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('tarefa'));
            $stmt->bindValue(2, $this->tarefa->__get('id'));
            return $stmt->execute();
        }
        public function remover(){
            $query = 'DELETE FROM tb_tarefas WHERE id = ?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('id'));
            $stmt->execute();
        }
        
        public function marcarRealizada(){
            //Update
            $query = 'UPDATE tb_tarefas SET id_status = ? WHERE id = ?';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(1, $this->tarefa->__get('id_status'));
            $stmt->bindValue(2, $this->tarefa->__get('id'));
            return $stmt->execute();
        }
        public function recuperarTarefasPendentes() {
            $query = '
                select 
                    t.id, s.status, t.tarefa 
                from 
                    tb_tarefas as t
                    left join tb_status as s on (t.id_status = s.id)
                where
                    t.id_status = :id_status
            ';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>