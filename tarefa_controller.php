<?php
    
    $cod = $_POST['tarefa'];
    $rgcod = '/^[A-Z]{3}[\d]{4}\.[\d]{1}-[\d]{2}$/';
    if(preg_match($rgcod, $cod)){
    require_once '../../app_lista_tarefas/tarefa_controller.php';
    }else{
    echo 'campo invalido';
}
?>