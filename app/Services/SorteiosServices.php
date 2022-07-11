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
        DB::beginTransaction();
        try{
            // $created = $this->sorteiosRepository->create($data->all());
            
                $s_id = DB::select("select ifnull( max( sorteio_id ) , 0 ) + 1 as result from sorteios where cliente_id = '$dados->cliente_id' and sala_id = '$dados->sala_id'");
                // dd($s_id[0]->result);
                $criar_sorteios = "
                    insert into sorteios( cliente_id , sala_id , sorteio_id , sorteio_tipo , sorteio_nome , sorteio_quantidade_tickets_pre , sorteio_quantidade_tickets_livre , sorteio_quantidade_venda , sorteio_quantidade_numeros , sorteio_quantidade_rodadas , sorteio_quantidade_giros , sorteio_criacao_data , sorteio_selecao_tipo , sorteio_selecao_limite , sorteio_selecao_forcar ) 
                    values( '$dados->cliente_id' , '$dados->sala_id' , '".$s_id[0]->result."' , '$dados->sorteio_tipo' , '$dados->sorteio_nome' , '$dados->sorteio_quantidade_tickets_pre' , '$dados->sorteio_quantidade_tickets_livre' , '$dados->sorteio_quantidade_venda' , '$dados->sorteio_quantidade_numeros' , '$dados->sorteio_quantidade_rodadas' , '$dados->sorteio_quantidade_giros' , now() , $dados->sorteio_selecao_tipo , $dados->sorteio_selecao_limite , $dados->sorteio_selecao_forcar );
                ";

                DB::select($criar_sorteios);
                // echo $criar_sorteios."<br><br>";

                $criar_rodadas = "insert into rodadas( cliente_id , sala_id , sorteio_id , rodada_id , rodada_criacao_data ) values ";
                for( $x=1 ; $x<=$dados->sorteio_quantidade_rodadas ; $x++ ){
                    if ($x==$dados->sorteio_quantidade_rodadas ){
                    $criar_rodadas = $criar_rodadas . "( '$dados->cliente_id' , '$dados->sala_id' , ".$s_id[0]->result." , '$x' , now() );";
                    } else {
                    $criar_rodadas = $criar_rodadas . "( '$dados->cliente_id' , '$dados->sala_id' , ".$s_id[0]->result." , '$x' , now() ),";
                    }
                }

                DB::select($criar_rodadas);
                // echo $criar_rodadas."<br><br>";

                if ( $dados->sorteio_quantidade_giros > 0 ){
                    $criar_giros = "insert into giros( cliente_id , sala_id , sorteio_id , giro_id , giro_criacao_data ) values ";
                    for( $x=1 ; $x<=$dados->sorteio_quantidade_giros ; $x++ ){
                    if ($x==$dados->sorteio_quantidade_giros ){
                        $criar_giros = $criar_giros . "( '$dados->cliente_id' , '$dados->sala_id' , ".$s_id[0]->result." , '$x' , now() );";
                    } else {
                        $criar_giros = $criar_giros . "( '$dados->cliente_id' , '$dados->sala_id' , ".$s_id[0]->result." , '$x' , now() ),";
                    }
                    }
                }
                DB::select($criar_giros);
                // echo $criar_giros."<br><br>";
                

                $quantidade = ( $dados->sorteio_quantidade_tickets_pre * $dados->sorteio_quantidade_venda ) + ( $dados->sorteio_quantidade_tickets_livre * $dados->sorteio_quantidade_venda ); 
                $criar_cartelas = '';
                if ( $dados->sorteio_tipo == 90 ){
                    $criar_cartelas = $criar_cartelas . $this->criar_cartelas_90( $dados->cliente_id , $dados->sala_id , $s_id[0]->result , $quantidade ) ; 
                } else if( $dados->sorteio_tipo == 60 ){
                    $criar_cartelas = $criar_cartelas . $this->criar_cartelas_60( $dados->cliente_id , $dados->sala_id , $s_id[0]->result , $quantidade ) ; 
                } else if( $dados->sorteio_tipo == 5 ){
                    $criar_cartelas = $criar_cartelas . $this->criar_cartelas_5( $dados->cliente_id , $dados->sala_id , $s_id[0]->result , $quantidade ) ; 
                } else if( $dados->sorteio_tipo == 6 ){
                    $criar_cartelas = $criar_cartelas . $this->criar_cartelas_6( $dados->cliente_id , $dados->sala_id , $s_id[0]->result , $quantidade ) ; 
                }
                DB::raw($criar_cartelas);
                // echo $criar_cartelas."<br><br>";

                $quantidade = ( $dados->sorteio_quantidade_tickets_pre * $dados->sorteio_quantidade_numeros ) + ( $dados->sorteio_quantidade_tickets_livre * $dados->sorteio_quantidade_numeros ); 
                $criar_numeros = '';
                if ( $dados->sorteio_tipo == 90 ){
                    $criar_numeros = $criar_numeros . $this->criar_numeros_6( $dados->cliente_id , $dados->sala_id , $s_id[0]->result , $quantidade  ) ; 
                } else if( $dados->sorteio_tipo == 60 ){
                    $criar_numeros = $criar_numeros . $this->criar_numeros_6( $dados->cliente_id , $dados->sala_id , $s_id[0]->result , $quantidade  ) ; 
                } else if( $dados->sorteio_tipo == 5 ){
                    $criar_numeros = $criar_numeros . $this->criar_numeros_6( $dados->cliente_id , $dados->sala_id , $s_id[0]->result , $quantidade  ) ; 
                } else if( $dados->sorteio_tipo == 6 ){
                    $criar_numeros = $criar_numeros . $this->criar_numeros_6( $dados->cliente_id , $dados->sala_id , $s_id[0]->result , $quantidade  ) ; 
                }
                DB::raw($criar_numeros);
                // echo $criar_numeros."<br><br>";

                /*
                    criacao do pre venda.
                */

                $quantidade = ( $dados->sorteio_quantidade_tickets_pre * $dados->sorteio_quantidade_venda ) ; 

                $pre_vendas_cartelas = "
                    set @inc = -1;
                    set @tic = 0;
                    set @qtd = $dados->sorteio_quantidade_venda;
                    insert into pre_vendas_cartelas( cliente_id , sala_id , sorteio_id , grupo_id , cartela_id )
                    select $dados->cliente_id , $dados->sala_id , ".$s_id[0]->result." , grupo_id , cartela_id from (
                        select 
                        cartela_id , 
                        @inc:=@inc+1 as inc , 
                        if ( ( @inc % @qtd ) = 0 , @tic:=@tic+1 , @tic ) as grupo_id
                        from cartelas
                        where 
                        cliente_id = $dados->cliente_id and
                        sala_id = $dados->sala_id and
                        sorteio_id = ".$s_id[0]->result."
                        limit $quantidade
                    ) a ;

                    insert into pre_vendas( cliente_id , sala_id , sorteio_id , grupo_id )
                    select distinct $dados->cliente_id , $dados->sala_id , ".$s_id[0]->result." , grupo_id 
                    from pre_vendas_cartelas
                    where 
                    cliente_id = $dados->cliente_id and
                    sala_id = $dados->sala_id and
                    sorteio_id = ".$s_id[0]->result.";
                ";
                
                DB::raw($pre_vendas_cartelas);
                // echo $pre_vendas_cartelas."<br><br>";

                $quantidade = ( $dados->sorteio_quantidade_tickets_pre * $dados->sorteio_quantidade_numeros ) ; 

                $pre_vendas_numeros = "
                    set @inc = -1;
                    set @tic = 0;
                    set @qtd = $dados->sorteio_quantidade_numeros;
                    insert into pre_vendas_numeros( cliente_id , sala_id , sorteio_id , grupo_id , numero_id )
                    select $dados->cliente_id , $dados->sala_id , ".$s_id[0]->result." , grupo_id , numero_id from (
                        select 
                        numero_id , 
                        @inc:=@inc+1 as inc , 
                        if ( ( @inc % @qtd ) = 0 , @tic:=@tic+1 , @tic ) as grupo_id
                        from numeros
                        where 
                        cliente_id = $dados->cliente_id and
                        sala_id = $dados->sala_id and
                        sorteio_id = ".$s_id[0]->result."
                        limit $quantidade
                    ) a ;
                ";

                // DB::select($pre_vendas_numeros);
                // echo $pre_vendas_numeros;
                // dd($pre_vendas_numeros);

                $created = DB::raw($pre_vendas_numeros);
                DB::commit();
                return $created;
        }catch(Exception $e){
            DB::rollback();
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


    
  #-------------------------------------------------------------------------------------------  
  # depositos
  #------------------------------------------------------------------------------------------  

  public function deposito_5x1_list( $qtd ){
    $count = $this->deposito_5x1_count();
    $sql = "
      select deposito_5x1_numeros 
      from deposito_5x1 
      where deposito_5x1_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
    ";
    return DB::select($sql);
    
  }

  public function deposito_5x1_count(){
    $sql = "select count(*) qtd from deposito_5x1;";
    return DB::select($sql)[0]->qtd;
  }

  public function deposito_6x1_list( $qtd ){
    $count = $this->deposito_6x1_count();
    $sql = "
      select deposito_6x1_numeros 
      from deposito_6x1 
      where deposito_6x1_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
    ";
    return DB::select($sql);
  }

  public function deposito_6x1_count(){
    $sql = "select count(*) qtd from deposito_6x1;";
    return DB::select($sql)[0]->qtd;
  }


  public function deposito_60x15_list( $qtd ){
    $count = $this->deposito_60x15_count();
    $sql = "
      select deposito_60x15_numeros 
      from deposito_60x15 
      where deposito_60x15_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
    ";
    return DB::select($sql);
  }

  public function deposito_60x15_count(){
    $sql = "select count(*) qtd from deposito_60x15;";
    return DB::select($sql)[0]->qtd;
  }

  public function deposito_90x15_list( $qtd ){
    $count = $this->deposito_90x15_count();
    $sql = "
      select deposito_90x15_numeros 
      from deposito_90x15 
      where deposito_90x15_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
    ";
    return DB::select($sql);
  }

  public function deposito_90x15_count(){
    $sql = "select count(*) qtd from deposito_90x15;";
    return DB::select($sql)[0]->qtd;
  }


  
  function criar_cartelas_90( $cliente_id , $sala_id , $sorteio_id , $qtd ){
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
  
  function criar_cartelas_60( $cliente_id , $sala_id , $sorteio_id , $qtd ){
    $seq = 1;
    $count = $this->deposito_60x15_count();
    $sql = "
      set @seq=0;
      insert into cartelas( cliente_id , sala_id , sorteio_id , cartela_id , cartela_numeros )
      select '$cliente_id' , '$sala_id' , $sorteio_id , @seq := @seq +1 , deposito_60x15_numeros from deposito_60x15 
      where deposito_60x15_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
    ";
    return $sql;
  }

  function criar_cartelas_5( $cliente_id , $sala_id , $sorteio_id , $qtd ){
    $seq = 1;
    $count = $this->deposito_5x1_count();
    $sql = "
      set @seq=0;
      insert into cartelas( cliente_id , sala_id , sorteio_id , cartela_id , cartela_numeros )
      select '$cliente_id' , '$sala_id' , $sorteio_id , @seq := @seq +1 , deposito_5x1_numeros from deposito_5x1 
      where deposito_5x1_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
    ";
    return $sql;
  }

  function criar_cartelas_6( $cliente_id , $sala_id , $sorteio_id , $qtd ){
    $seq = 1;
    $count = $this->deposito_6x1_count();
    $sql = "
      set @seq=0;
      insert into cartelas( cliente_id , sala_id , sorteio_id , cartela_id , cartela_numeros )
      select '$cliente_id' , '$sala_id' , $sorteio_id , @seq := @seq +1 , deposito_6x1_numeros from deposito_6x1 
      where deposito_6x1_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
    ";
    return $sql;
  }
  
  function criar_numeros_6( $cliente_id , $sala_id , $sorteio_id , $qtd ){
    $seq = 1;
    $count = $this->deposito_6x1_count();
    $sql = "
      set @seq=0;
      insert into numeros( cliente_id , sala_id , sorteio_id , numero_id , numero_numeros )
      select '$cliente_id' , '$sala_id' , $sorteio_id , @seq := @seq +1 , deposito_6x1_numeros from deposito_6x1 
      where deposito_6x1_id >= truncate(rand()*($count-$qtd),0) limit $qtd;
    ";
    return $sql;
  }

}