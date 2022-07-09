<?php
namespace App\Services;

use App\Repositories\SorteiosRepository;
use Illuminate\Support\Facades\DB;

class SorteiosServices implements SorteiosServicesInterface{
    
    private $sorteiosRepository;
    
    public function __construct(
        SorteiosRepository $sorteiosRepository
    ){
        $this->sorteiosRepository = $sorteiosRepository;
    }

    public function index(){
        $data = $this->sorteiosRepository->index();
        return $data;
    }

    public function get(){
        return $this->sorteiosRepository->get();
    }

    public function create($dados){
        try{
            // $created = $this->sorteiosRepository->create($data->all());
            
            $sql = "
                set @sorteio_id = ( select ifnull( max( sorteio_id ) , 0 ) + 1 from sorteios where cliente_id = '$dados->cliente_id' and sala_id = '$dados->sala_id') ;
                insert into 
                sorteios( cliente_id , sala_id , sorteio_id , sorteio_tipo , sorteio_nome , sorteio_quantidade_tickets_pre , sorteio_quantidade_tickets_livre , sorteio_quantidade_venda , sorteio_quantidade_numeros , sorteio_quantidade_rodadas , sorteio_quantidade_giros , sorteio_criacao_data , sorteio_selecao_tipo , sorteio_selecao_limite , sorteio_selecao_forcar ) 
                values( '$dados->cliente_id' , '$dados->sala_id' , @sorteio_id , '$dados->sorteio_tipo' , '$dados->sorteio_nome' , '$dados->sorteio_quantidade_tickets_pre' , '$dados->sorteio_quantidade_tickets_livre' , '$dados->sorteio_quantidade_venda' , '$dados->sorteio_quantidade_numeros' , '$dados->sorteio_quantidade_rodadas' , '$dados->sorteio_quantidade_giros' , now() , $dados->sorteio_selecao_tipo , $dados->sorteio_selecao_limite , $dados->sorteio_selecao_forcar );
            ";

            $sql = $sql . "insert into rodadas( cliente_id , sala_id , sorteio_id , rodada_id , rodada_criacao_data ) values ";
            for( $x=1 ; $x<=$dados->sorteio_quantidade_rodadas ; $x++ ){
                if ($x==$dados->sorteio_quantidade_rodadas ){
                $sql = $sql . "( '$dados->cliente_id' , '$dados->sala_id' , @sorteio_id , '$x' , now() );";
                } else {
                $sql = $sql . "( '$dados->cliente_id' , '$dados->sala_id' , @sorteio_id , '$x' , now() ),";
                }
            }

            if ( $dados->sorteio_quantidade_giros > 0 ){
                $sql = $sql . "insert into giros( cliente_id , sala_id , sorteio_id , giro_id , giro_criacao_data ) values ";
                for( $x=1 ; $x<=$dados->sorteio_quantidade_giros ; $x++ ){
                if ($x==$dados->sorteio_quantidade_giros ){
                    $sql = $sql . "( '$dados->cliente_id' , '$dados->sala_id' , @sorteio_id , '$x' , now() );";
                } else {
                    $sql = $sql . "( '$dados->cliente_id' , '$dados->sala_id' , @sorteio_id , '$x' , now() ),";
                }
                }
            }

            $quantidade = ( $dados->sorteio_quantidade_tickets_pre * $dados->sorteio_quantidade_venda ) + ( $dados->sorteio_quantidade_tickets_livre * $dados->sorteio_quantidade_venda ); 

            if ( $dados->sorteio_tipo == 90 ){
                $sql = $sql . criar_cartelas_90( $dados->cliente_id , $dados->sala_id , '@sorteio_id' , $quantidade ) ; 
            } else if( $dados->sorteio_tipo == 60 ){
                $sql = $sql . criar_cartelas_60( $dados->cliente_id , $dados->sala_id , '@sorteio_id' , $quantidade ) ; 
            } else if( $dados->sorteio_tipo == 5 ){
                $sql = $sql . criar_cartelas_5( $dados->cliente_id , $dados->sala_id , '@sorteio_id' , $quantidade ) ; 
            } else if( $dados->sorteio_tipo == 6 ){
                $sql = $sql . criar_cartelas_6( $dados->cliente_id , $dados->sala_id , '@sorteio_id' , $quantidade ) ; 
            }

            $quantidade = ( $dados->sorteio_quantidade_tickets_pre * $dados->sorteio_quantidade_numeros ) + ( $dados->sorteio_quantidade_tickets_livre * $dados->sorteio_quantidade_numeros ); 

            if ( $dados->sorteio_tipo == 90 ){
                $sql = $sql . criar_numeros_6( $dados->cliente_id , $dados->sala_id , '@sorteio_id' , $quantidade  ) ; 
            } else if( $dados->sorteio_tipo == 60 ){
                $sql = $sql . criar_numeros_6( $dados->cliente_id , $dados->sala_id , '@sorteio_id' , $quantidade  ) ; 
            } else if( $dados->sorteio_tipo == 5 ){
                $sql = $sql . criar_numeros_6( $dados->cliente_id , $dados->sala_id , '@sorteio_id' , $quantidade  ) ; 
            } else if( $dados->sorteio_tipo == 6 ){
                $sql = $sql . criar_numeros_6( $dados->cliente_id , $dados->sala_id , '@sorteio_id' , $quantidade  ) ; 
            }

            /*
                criacao do pre venda.
            */

            $quantidade = ( $dados->sorteio_quantidade_tickets_pre * $dados->sorteio_quantidade_venda ) ; 

            $sql = $sql . "
                set @inc = -1;
                set @tic = 0;
                set @qtd = $dados->sorteio_quantidade_venda;
                insert into pre_vendas_cartelas( cliente_id , sala_id , sorteio_id , grupo_id , cartela_id )
                select $dados->cliente_id , $dados->sala_id , @sorteio_id , grupo_id , cartela_id from (
                    select 
                    cartela_id , 
                    @inc:=@inc+1 as inc , 
                    if ( ( @inc % @qtd ) = 0 , @tic:=@tic+1 , @tic ) as grupo_id
                    from cartelas
                    where 
                    cliente_id = $dados->cliente_id and
                    sala_id = $dados->sala_id and
                    sorteio_id = @sorteio_id
                    limit $quantidade
                ) a ;

                insert into pre_vendas( cliente_id , sala_id , sorteio_id , grupo_id )
                select distinct $dados->cliente_id , $dados->sala_id , @sorteio_id , grupo_id 
                from pre_vendas_cartelas
                where 
                cliente_id = $dados->cliente_id and
                sala_id = $dados->sala_id and
                sorteio_id = @sorteio_id;
            ";

            $quantidade = ( $dados->sorteio_quantidade_tickets_pre * $dados->sorteio_quantidade_numeros ) ; 

            $sql = $sql . "
                set @inc = -1;
                set @tic = 0;
                set @qtd = $dados->sorteio_quantidade_numeros;
                insert into pre_vendas_numeros( cliente_id , sala_id , sorteio_id , grupo_id , numero_id )
                select $dados->cliente_id , $dados->sala_id , @sorteio_id , grupo_id , numero_id from (
                    select 
                    numero_id , 
                    @inc:=@inc+1 as inc , 
                    if ( ( @inc % @qtd ) = 0 , @tic:=@tic+1 , @tic ) as grupo_id
                    from numeros
                    where 
                    cliente_id = $dados->cliente_id and
                    sala_id = $dados->sala_id and
                    sorteio_id = @sorteio_id
                    limit $quantidade
                ) a ;
            ";

            echo $sql;
            dd($sql);

            $created = Sorteios::select($sql);
            return $created;
        }catch(Exception $e){
            return $e->message();
        }
    }

    public function update($data){
        try{
            $updated = $this->sorteiosRepository->updateById($data->id, $data->all());
            return $updated;
        }catch(Exception $e){
            return $e->message();
        }
    }

    public function delete($sala_id){
        $data = $this->sorteiosRepository->destroy($sala_id);
        return $data;
    }

    public function criar_cartelas_90( $cliente_id , $sala_id , $sorteio_id , $qtd ){
        global $conn;
        $seq = 1;
        $count = $this->deposito_90x15_count();
        $sql = "
          set @seq=0;
          insert into cartelas( cliente_id , sala_id , sorteio_id , cartela_id , cartela_numeros )
          select '$cliente_id' , '$sala_id' , $sorteio_id , @seq := @seq +1 , deposito_90x15_numeros from deposito_90x15 
          where deposito_90x15_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
        ";
        return $sql;
    }


    
  #-------------------------------------------------------------------------------------------  
  # depositos
  #------------------------------------------------------------------------------------------  

  public function deposito_5x1_list( $qtd ){
    global $conn;
    $count = $this->deposito_5x1_count();
    $sql = "
      select deposito_5x1_numeros 
      from deposito_5x1 
      where deposito_5x1_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
    ";
    return database_exec( $conn , $sql );
    
  }

  public function deposito_5x1_count(){
    $sql = "select count(*) qtd from deposito_5x1;";
    return DB::select($sql)[0]->qtd;
  }

  public function deposito_6x1_list( $qtd ){
    global $conn;
    $count = $this->deposito_6x1_count();
    $sql = "
      select deposito_6x1_numeros 
      from deposito_6x1 
      where deposito_6x1_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
    ";
    return database_exec( $conn , $sql );
  }

  public function deposito_6x1_count(){
    $sql = "select count(*) qtd from deposito_6x1;";
    return DB::select($sql)[0]->qtd;
  }


  public function deposito_60x15_list( $qtd ){
    global $conn;
    $count = deposito_60x15_count();
    $sql = "
      select deposito_60x15_numeros 
      from deposito_60x15 
      where deposito_60x15_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
    ";
    return database_exec( $conn , $sql );
  }

  public function deposito_60x15_count(){
    $sql = "select count(*) qtd from deposito_60x15;";
    return DB::select($sql)[0]->qtd;
  }

  public function deposito_90x15_list( $qtd ){
    global $conn;
    $count = $this->deposito_90x15_count();
    $sql = "
      select deposito_90x15_numeros 
      from deposito_90x15 
      where deposito_90x15_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
    ";
    return database_exec( $conn , $sql );
  }

  public function deposito_90x15_count(){
    $sql = "select count(*) qtd from deposito_90x15;";
    return DB::select($sql)[0]->qtd;
  }

}